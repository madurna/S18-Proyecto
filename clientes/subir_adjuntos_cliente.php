<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// Links
	require_once('clientes.config');
	//require_once('../configuraciones/configuraciones.config');
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

	
	//DB_DataObject::debugLevel(5); 
	$do_cliente = DB_DataObject::factory('clientes');
	$do_cliente -> cliente_id = $cliente_id;
	$do_cliente -> find(true);
	
	$frm ->addElement('text','apellido','Apellido:', array('id' => 'apellido', 'value'=>$do_cliente -> cliente_apellido));
	$frm ->addElement('text','nombre','Nombre:', array('id' => 'nombre', 'value'=>$do_cliente -> cliente_nombre));
	$frm ->addElement('text','dni','Documento:', array('id' => 'dni', 'value'=> $do_cliente -> cliente_nro_doc));
	$frm ->freeze(nombre);
	$frm ->freeze(apellido);
	$frm ->freeze(dni);
	
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
		
		// Creo el objeto HTTP_Upload
		$upload = new HTTP_Upload('es');
			
		// Itero por la posible cantidad de adjuntos
		for ($i = 1; $i <= $cantidad_adjuntos; $i++) {
			// Nombre del input file
			$campo_adjunto = 'adjunto_'.$i;
			
			// Obtengo el archivo a subir
			$file = $upload->getFiles($campo_adjunto);
	
			// Valido el archivo
			if ($file->isValid()) {
				// Creo una carpeta para los adjuntos, si existe al menos uno
				if ($campo_adjunto == 'adjunto_1'){
					$carpeta = WWW_PATH.'/adjuntos/cliente/'.$cliente_post_id;
					mkdir($carpeta, 0777);
				}
				
				// Obtengo el nombre del archivo cargado
				$nombre = $_FILES[$campo_adjunto]['name'];
	
				// Donde haya espacios en el nombre pongo guión bajo "_" porque así lo guarda en la carpeta
				$nom = str_replace(' ', '_', $nombre);
	
				// Ruta del archivo
				$ruta='../adjuntos/cliente/'.$cliente_post_id.'/'.$nom;
				
				// Muevo el archivo a la carpeta correspondiente
				$file->moveTo($carpeta);
				chmod($ruta, 0755);
				// Inserto en la tabla "adjuntos"
				$do_adjuntos = DB_DataObject::factory('adjuntos_cliente');
				$do_adjuntos -> adjuntos_cliente_tipo_adjunto_id = $_POST['tipo_adjunto_'.$i];
				$do_adjuntos -> adjuntos_cliente_cliente_id = $cliente_post_id;
				$do_adjuntos -> adjuntos_cliente_direccion = $ruta;
				$do_adjuntos -> adjuntos_cliente_descripcion = $_POST['descripcion_'.$i];
				$do_adjuntos -> adjuntos_cliente_nombre = $nom;
				$id_adjunto = $do_adjuntos -> insert();
				
			}	
		}
		header('Location:index.php');
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Subir adjuntos cliente';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>
            <script language="javascript" type="text/javascript" src="../js/agregar_campo_file.js"></script>
            ';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_oceba.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Subir adjuntos cliente');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>