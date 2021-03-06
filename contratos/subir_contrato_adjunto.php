<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('contrato.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerías propias
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/rutinas.php');
	require_once(INC_PATH.'/grilla.php');
	require_once(AUTHFILE);
	require_once ('HTTP/Upload.php');
	$_SESSION['menu_principal'] = 8;

	$cliente_id = $_GET['contenido'];
	
	$frm = new HTML_QuickForm('fileuploadexample','POST', null,null,array("enctype" => "multipart/form-data"));

	$do_contrato = DB_DataObject::factory('contrato');
	
	$do_contrato -> fb_fieldsToRender = array (
    	'contrato_bibliorato',
		'contrato_caja_numero',
		'contrato_monto'
    );

    //Creo el formulario en base a la solicitud
	$fb =& DB_DataObject_FormBuilder::create($do_contrato);
	$frm =& $fb->getForm($_SERVER['REQUEST_URI'],null,'frm');
	$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
	$frm->setRequiredNote(FRM_NOTA);
	
	//DB_DataObject::debugLevel(5); 
		
	//obtengo tipos de adjunto
	$cantidad_tipo_adjuntos = 0;
	$do_tipo_adjunto = DB_DataObject::factory('tipo_adjunto');
	$do_tipo_adjunto -> orderBy('tipo_adjunto_id ASC');
	$do_tipo_adjunto -> find();
	while ($do_tipo_adjunto -> fetch()){
		$id = $do_tipo_adjunto -> tipo_adjunto_id;
		$valor = $do_tipo_adjunto -> tipo_adjunto_nombre;
		$tipo_adjunto_select = $tipo_adjunto_select.'<option value='.$id.'>'.$valor.'</option>';
		$ids = $ids.'-'.$id;
		$valores = $valores.'-'.$valor;
		$cantidad_tipo_adjuntos++;
	}
		
	//elementos ocultos para guardar los valores del select de tipo de adjuntos
	$frm ->addElement('hidden','hidden_ids', $ids, array('id' => 'hidden_ids'));
	$frm ->addElement('hidden','hidden_valores', $valores, array('id' => 'hidden_valores'));
	$frm ->addElement('hidden','hidden_cantidad_tipo_adjuntos', $cantidad_tipo_adjuntos, array('id' => 'hidden_cantidad_tipo_adjuntos'));
	$frm ->addElement('hidden','hidden_cliente', $cliente_id, array('id' => 'hidden_cliente'));
	
	//elemento oculto para guardar la cantidad de adjuntos
	$frm ->addElement('hidden','hidden_cantidad_adjuntos', '1', array('id' => 'hidden_cantidad_adjuntos'));
	//adjuntos
	$frm -> addElement('html','
			<td>
			</td>
			<td>
				<div style="padding:0.5em ; background:lightgray ; border:0"><strong><u>Adjunto</u></strong></div>
				<select name="tipo_adjunto_1" id="tipo_adjunto_1">'.$tipo_adjunto_select.'
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>	
				<input type="file" name="adjunto_1" id="adjunto_1">
				<a href="JavaScript:limpiar()"> Quitar </a>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<strong><u>Descripci&oacute;n del Adjunto</u></strong><br>
				<textarea cols="45" rows="3" name="descripcion_1" id="descripcion_1"></textarea>
			</td>
		</tr>
		<tr >
			<td>
			</td>
			<td id="contenedor"></td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<a href="JavaScript:agregarCampo()"> Agregar </a>
			</td>
		<tr>
	');
	
	// Posible cantidad de adjuntos
	$cantidad_adjuntos = $_POST['hidden_cantidad_adjuntos'];
	$cliente_post_id = $_POST['hidden_cliente'];
	
	//
	$frm ->addElement('html', '<tr><td colspan=2><br/></td></tr>');
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.location.href='index.php';"));
	$botones[] = $frm->createElement('reset','restaurar','Limpiar');
	$frm->addGroup($botones);
	
	$aceptar = $_POST['aceptar'];
	
	if ($aceptar == 'Guardar'){

		//print_r($_POST);exit;
		// Creo el objeto HTTP_Upload
		$upload = new HTTP_Upload('es');
			
		// Itero por la posible cantidad de adjuntos
		for ($i = 1; $i <= $cantidad_adjuntos; $i++) {
			// Nombre del input file
			$campo_adjunto = 'adjunto_'.$i; 
			
			// Obtengo el archivo a subir
			$file = $upload->getFiles($campo_adjunto); 
	
			// Valido el archivo
			if ($file->isValid()) { //print_r('holas');exit;
				// Creo una carpeta para los adjuntos, si existe al menos uno
				if ($campo_adjunto == 'adjunto_1'){
					$carpeta = WWW_PATH.'/contratos/cliente/'.$cliente_post_id;
					mkdir($carpeta, 0777);
				}
				
				// Obtengo el nombre del archivo cargado
				$nombre = $_FILES[$campo_adjunto]['name'];
	
				// Donde haya espacios en el nombre pongo guión bajo "_" porque así lo guarda en la carpeta
				$nom = str_replace(' ', '_', $nombre);
	
				// Ruta del archivo
				$ruta='../contratos/cliente/'.$cliente_post_id.'/'.$nom;
				
				// Muevo el archivo a la carpeta correspondiente
				$file->moveTo($carpeta);
				chmod($ruta, 0755);
				// Inserto en la tabla "contrato"
				$do_contrato = DB_DataObject::factory('contrato');
				$do_contrato -> contrato_bibliorato = $_POST['contrato_bibliorato'];
				$do_contrato -> contrato_caja_numero = $_POST['contrato_caja_numero'];
				$do_contrato -> contrato_monto = $_POST['contrato_monto'];
				$do_contrato -> contrato_cliente_id = $cliente_post_id;
				$do_contrato -> contrato_path = $ruta;
				$do_contrato -> contrato_descripcion = $_POST['descripcion_'.$i];
				$do_contrato -> contrato_fecha = date("Y-m-d");
				$id_adjunto = $do_contrato -> insert();				
			}
			//$do_contrato->query('BEGIN');
			
			//print_r($id_adjunto);exit;
			// si se inserto se redirije a index.php, de lo contrario se muestra el error
			if ($id_adjunto){
				$do_contrato->query('COMMIT');	
			}
			else{
				$do_contrato->query('ROLLBACK');			
				$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
			}
		}
		header('Location:contrato.php?contenido='.$cliente_post_id);
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Subir contrato cliente';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>
            <script language="javascript" type="text/javascript" src="../js/agregar_campo_file.js"></script>
            ';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Subir Contrato adjunto');
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>