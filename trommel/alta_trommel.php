<?php
	ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('trommel.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once ('HTTP/Upload.php');
	require_once(AUTHFILE);
	$_SESSION['menu_principal'] = 2;
	
	$planta_id = $_GET['contenido'];
	
	//DB_DataObject::debugLevel(5); 

	$frm = new HTML_QuickForm('fileuploadexample','POST', null,null,array("enctype" => "multipart/form-data"));

	$frm ->addElement('text','diametro','Di&aacute;metro (mts):', array('id' => 'diametro', 'value'=>''));
	$frm ->addElement('text','largo','Largo (mts):', array('id' => 'largo', 'value'=>''));
	$frm ->addElement('text','motor','Motor (HP):', array('id' => 'motor', 'value'=>''));
	$frm ->addElement('text','relacion','Relaci&oacute;n Engranaje:', array('id' => 'relacion', 'value'=>''));
	
	
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
	$frm ->addElement('hidden','hidden_planta', $planta_id, array('id' => 'hidden_planta'));
	
	//elemento oculto para guardar la cantidad de adjuntos
	$frm ->addElement('hidden','hidden_cantidad_adjuntos', '1', array('id' => 'hidden_cantidad_adjuntos'));
	//adjuntos
	$frm -> addElement('html','
			<td>
			</td>
			<td>
				<div style="padding:0.5em ; background:lightgray ; border:0"><strong><u>Adjuntar Plano</u></strong></div>
				<select name="tipo_adjunto_1" id="tipo_adjunto_1">'.$tipo_adjunto_select.'
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>	
				<input type="file" name="adjunto_1" id="adjunto_1">
			</td>
		</tr>
	');
	
	//$frm ->addElement('html', '<tr><td colspan=2><br/></td></tr>');
	
	//botones de aceptar , cancelar , limpiar
	$botones = array();
	$botones[] = $frm->createElement('submit','aceptar','Guardar');
	$botones[] = $frm->createElement('button','cancelar','Cancelar',array('onClick'=> "javascript: window.history.back();"));
	$botones[] = $frm->createElement('reset','restaurar','Limpiar');
	$frm->addGroup($botones);
	
	$cantidad_adjuntos = $_POST['hidden_cantidad_adjuntos'];
	// Datos POST Formulario
	$planta_post_id = $_POST['hidden_planta'];
	$diametro_post = $_POST['diametro'];
	$largo_post = $_POST['largo'];
	$motor_post = $_POST['motor'];
	$relacion_post = $_POST['relacion'];
	
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
					$carpeta = WWW_PATH.'/adjuntos/trommel/'.$planta_post_id;
					mkdir($carpeta, 0777);
				}
				
				// Obtengo el nombre del archivo cargado
				$nombre = $_FILES[$campo_adjunto]['name'];
	
				// Donde haya espacios en el nombre pongo guión bajo "_" porque así lo guarda en la carpeta
				$nom = str_replace(' ', '_', $nombre);
	
				// Ruta del archivo
				$ruta='/adjuntos/trommel/'.$planta_post_id.'/'.$nom;
				
				// Muevo el archivo a la carpeta correspondiente
				$file->moveTo($carpeta);
				chmod($ruta, 0777);
				// Inserto en la tabla "adjuntos"

				//FALTA RUUUUUUUUUUUUUUUUUUUUUUUUUUUUTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
				/*
				$do_trommel -> trommel_adjunto_direccion = $ruta;
				*/

				$do_trommel = DB_DataObject::factory('trommel');
				$do_trommel -> trommel_diametro = $diametro_post;
				$do_trommel -> trommel_largo = $largo_post;
				$do_trommel -> trommel_motor = $motor_post;
				$do_trommel -> trommel_plano = $nom;
				$do_trommel -> trommel_relacion_engranaje = $relacion_post;
				$do_trommel -> id_planta = $planta_post_id;
				$do_trommel -> trommel_estado_id = '1';
				$id_trommel = $do_trommel -> insert();

				if ($id_trommel){
					$do_trommel->query('COMMIT');	
				}
				else{
					$do_trommel->query('ROLLBACK');			
					$error = 'Error en la generaci&oacute;n de los datos</b></div>';				
				}				
			}
		}
		header('location:../planta/planta_pieza.php?contenido='.$planta_post_id);
		ob_end_flush();
		exit;
	}
	
	$tpl = new tpl();
	$titulo_grilla = 'Alta Trommel';
	$body =
           '<div id="contenido"><b>'.$titulo_grilla.'</b></div>
            <div id="contenido"><p>'.$frm->toHtml().'</p></div>
            ';
	$tpl->assign('body', $body);
    $tpl->assign('menu','menu_eco_reciclar.htm');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Alta Trommel');
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');
	ob_end_flush();
?>