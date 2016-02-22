<?php
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');	
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/comun_dg.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	
	$_SESSION['menu_principal'] = 2;
	//DB_DataObject::debugLevel(5); 
		
	//Ejecutar cliente
	$planta_id = $_GET['contenido'];
	
	$do_trommel = DB_DataObject::factory('trommel');
	$do_trommel -> whereAdd("id_planta = '$planta_id'");
	$do_trommel -> find(true);
	$do_prensa = DB_DataObject::factory('prensa');
	$do_prensa -> whereAdd("id_planta = '$planta_id'");
	$do_prensa -> find(true);
	$do_cinta_transportadora = DB_DataObject::factory('cinta_transportadora');
	$do_cinta_transportadora -> whereAdd("id_planta = '$planta_id'");
	$do_cinta_transportadora -> find(true);

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$columnas = array();
	$columnas[0] = '<font size="1px" color="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Expediente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>';
	$columnas[1] = '<font size="1px" color="#FFFFFF">Fecha de Solicitud</font>';
	$columnas[2] = '<font size="1px" color="#FFFFFF">Estado</font>';
	$columnas[3] = '<font size="1px" color="#FFFFFF">Iniciador</font>';
	$columnas[4] = '<font size="1px" color="#FFFFFF">Motivo</font>';
	$columnas[5] = '<font size="1px" color="#FFFFFF">Aprobar</font>';
	$columnas[6] = '<font size="1px" color="#FFFFFF">Rechazar</font>';	
	$pos = 0;
	while ($solicitudDesarchivo -> fetch()){
		$i++;
		
			if (esAtencionAUsuario($solicitudDesarchivo->expediente_id)){
				$do_tramite_union = DB_DataObject::factory('tramite_union');
				$do_tramite = DB_DataObject::factory('tramite');
				$do_expediente -> whereAdd("id_expediente = $solicitudDesarchivo->expediente_id");
				$do_tramite_union -> joinAdd ($do_expediente);
				$do_tramite -> joinAdd ($do_tramite_union);
				$do_tramite -> find (true);
				$iniciador_nombre= '<center>'.utf8_encode($do_tramite->tramite_titular).'<center>';
			}else{
				$do_tramite_union = DB_DataObject::factory('tramite_union');
				$do_nota_entrada = DB_DataObject::factory('nota_entrada');
				$do_iniciador_subtipo = DB_DataObject::factory('iniciador_subtipo');
				$do_expediente -> whereAdd("id_expediente = $solicitudDesarchivo->expediente_id");
				$do_nota_entrada -> joinAdd ($do_iniciador_subtipo);
				$do_nota_entrada -> joinAdd ($do_tramite_union);
				$do_nota_entrada -> find (true);
				$iniciador_nombre= '<center>'.utf8_encode($do_nota_entrada->iniciador_subtipo_nombre).'<center>';
			}

			if ($iniciador)
				$pos = strripos($iniciador_nombre, $iniciador);
				
			else 
				$pos = 0;
				
			if(($pos===0) || ($pos != false)){	
					$matriz[$i][0]= '<b><center>'.nroExpedienteCompleto($solicitudDesarchivo->expediente_id).'</center></b>';
					$matriz[$i][1]= '<center>'.getFecha($solicitudDesarchivo->fecha_motivo).'</center>';
					$matriz[$i][3]= $iniciador_nombre;
								
					$do_estado = DB_DataObject::factory('estado');
					$do_estado -> find();
					$matriz[$i][4]="";
					$matriz[$i][5]="";
					$matriz[$i][6]="";
					
					while ($do_estado -> fetch()){
						if ($do_estado->id_estado ==  $solicitudDesarchivo->estado_id){
						$matriz[$i][2]= '<center>'.$do_estado->descripcion.'<center>';
						}else{
							$estado='';
						}
					}
					
					
					
					$matriz[$i][4]= '<img src="../img/spirit20_icons/magnify.png" 
									border="0" title="Ver Motivo" 
									style="vertical-align:middle;cursor:pointer;" 
									onclick="javascript:mostrarDialogo(\'verMotivo.php?contenido='.$solicitudDesarchivo -> id_motivo.'\',800,600,1);" />';
					
					if($solicitudDesarchivo -> estado_id == 1){
					$matriz[$i][5] = '<form name="aprobar'.$i.'" method="POST" action="bandejaArchivo.php">
									<input name="enviado" type="hidden" value="1">
									<input name="aceptar" type="hidden" value="Filtrar">
									<input name="id_m" type="hidden" value="'.$solicitudDesarchivo->id_motivo.'">
									<img src="../img/ok16.png" onclick="if(confirm(\'\u00bf Esta seguro que desea aprobar el Archivo?\')) { document.aprobar'.$i.'.submit(); }" style="cursor:pointer">
									</form>';
				
					$matriz[$i][6] = '<form name="rechazar'.$i.'" method="POST" action="bandejaArchivo.php">
									<input name="rechazar" type="hidden" value="1">
									<input name="rechazar" type="hidden" value="Filtrar">
									<input name="expId" type="hidden" value="'.$solicitudDesarchivo->expediente_id.'">
									<input name="id_m" type="hidden" value="'.$solicitudDesarchivo->id_motivo.'">
									<img src="../img/spirit20_icons/system-delete-alt-02.png" onclick="if(confirm(\'\u00bf Esta seguro que desea rechazar el Archivo?\')) { document.rechazar'.$i.'.submit(); }" style="cursor:pointer">
									</form>';
						
				}
			}
		}
	}

			
	//armo grilla
	$cantidadColumnas = array();
	for ($i=0; $i <= 4; $i++) $cantidadColumnas[$i] = $i;
	$dg = new grilla(7);
	$dg -> setRendererOption ('convertEntities',false);
	$dg -> generateColumns($columnas); // Genero las columnas en la grilla utilizando el array que acabo de crear
	$dg -> bind($matriz,array(),'Array'); // Hago el Bind con la matriz, el 1er y 2do parámetro siempre son iguales
	// Oculto los links en los encabezados para que el usuario no pueda desordenar el contenido de la grilla
	$dg -> setRendererOption('hideColumnLinks', $cantidadColumnas);
	$table = new HTML_Table('cellpadding=5 walign=center border=0');
	$dg -> fill($table);


	//armo template
	$tpl = new tpl();
	if ($dg->getRecordCount() > 0 ) {		
	$salida_grilla=$dg->getOutput();
	$dg->setRenderer('Pager');
	$salida_grilla.=$dg->getOutput();
	$dg->setRendererOption('onMove', 'updateGrid', true);
	}
	//tpl
	//$body = '<div align=center><b>'.$titulo_grilla.'</b></div>';
	$body = '<div align="right">
				<a id="abrirAyuda" href="#ayuda" title="Ayuda"><img width="30" height="30" src="../img/spirit20_icons/help.png" onclick="javascript:window.scrollTo(0,0);" /></a>
				<div style="display: none;">
					<div id="ayuda" style="width:670px;height:400px;overflow:auto;">
						<p align="center"><strong>Ayuda sobre Desarchivo de Expedientes</strong></p>
						Para realizar la b&uacute;squeda deber&aacute; completar el filtro, que consta de 5 campos:
	    				<li>Iniciador</li>
	    				<li>N&uacute;mero</li>
	    				<li>Fecha desde</li>
	    				<li>Fecha hasta</li>
	    				<li>Estado</li><br />
						
	    				<strong>Iniciador:</strong> deber&aacute indicar el iniciador de la solicitud de desarchivo.<br />
						<strong>N&uacute;mero:</strong> deber&aacute indicar el n&uacute;mero de un expediente en particular.<br />
						
						<strong>Fecha desde</strong> y <strong>Fecha hasta:</strong> deber&aacute; indicar el intervalo de fechas de expedientes que desee visualizar. Estas fechas hacen referencia a la <em>fecha de solicitud de desarchivo</em> de los expedientes. 
						Para modificar este intervalo de fechas, deber&aacute; hacer click en el &iacute;cono <img style="vertical-align:middle;" src="../img/spirit20_icons/calendar.png" /> que 
						posee a la derecha cada campo. Se abrir&aacute; un calendario en donde podr&aacute; seleccionar el mes y por &uacute;ltimo el d&iacute;a deseado. La selecci&oacute;n realizada se ver&aacute; reflejada en el campo 
						correspondiente al &iacute;cono <img style="vertical-align:middle;" src="../img/spirit20_icons/calendar.png" /> presionado.<br />
						
						<strong>Estado:</strong> Podr&aacute; vizualizar en que situaciones se encuentran otros expedientes, eligiendo algunas de las dem&aacute;s opciones del estado: <b>Pendientes</b>, <b>Rechazados</b>, <b>Aprobados</b>.<br /><br />
						En la grilla se visualizar&aacute; la siguiente informaci&oacute;n: <em>N&uacute;mero Expediente</em>, <em>Fecha de Solicitud</em>, <em>Estado</em>. <br />
						Luego, las tres &uacute;ltimas columnas de la grilla ser&aacute;n:<br />
	    				<li>Motivo</li>
						<li>Aprobar</li>
	    				<li>Rechazar</li>
	    				<strong>Motivo:</strong> aqu&iacute; podr&aacute; ver el <em>motivo</em> por el cual se desea desarchivar este expediente, haciendo click sobre el &iacute;cono <img style="vertical-align:middle;" src="../img/spirit20_icons/magnify.png" />.<br />
						<strong>Aprobar:</strong> aqu&iacute; podr&aacute; <em>aprobar</em> el desarchivar expediente, haciendo click sobre el &iacute;cono <img style="vertical-align:middle;" src="../img/ok16.png" />.<br />
						<strong>Rechazar:</strong> aqu&iacute; podr&aacute; <em>rechazar</em> el desarchivar expediente, haciendo click sobre el &iacute;cono <img style="vertical-align:middle;" src="../img/spirit20_icons/system-delete-alt-02.png" />. 
					</div>
				</div>
			  </div>';
	$body .='<div><br/>'.$frm->toHTML().'</div>';
	$body .= '<div align=center><br/>'.$salida_grilla.'</div>';
	//$volver='<a href="bandejaArchivo.php">[Volver]</a><br/><br/>';
	$body .= '
		<link rel="stylesheet" href="../css/modal-message.css" type="text/css">
		<script type="text/javascript" src="../js/ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/ajax/ajax-dynamic-content.js"></script>
		<script type="text/javascript" src="../js/ajax/modal-message.js"></script>
	    <script>
			messageObj = new DHTML_modalMessage();
			function mostrarDialogo(url) {
				messageObj.setSource(url);
				messageObj.setCssClassMessageBox(false);
				messageObj.setSize(600,500);
				messageObj.setShadowDivVisible(true);	// Enable shadow for these boxes
				messageObj.display();
			}

			function cerrarDialogo() {
				messageObj.close();
			}
		</script>

	<div align=center><br/><br/>'.$volver.'</div>';

	if ((($estado)) && ($aceptar)){
		$do_estado_msj = DB_DataObject::factory('estado');
		$do_estado_msj -> id_estado = $estado;
		$do_estado_msj-> find(true);
		$tpl->assign('include_file', 'cartel.htm');
		$tpl->assign('imagen', 'informacion.jpg');
		$tpl->assign('msg', 'No hay solicitudes para el estado <b>'.$do_estado_msj->descripcion.'</b>.');
		}
		
		
	if ($pos === false){
		$tpl->assign('include_file', 'cartel.htm');
		$tpl->assign('imagen', 'informacion.jpg');
		$tpl->assign('msg', 'No hay solicitudes para el iniciador <b>'.$iniciador.'</b>.');
	}


	//print_r($solicitudDesarchivo);
	//print_r($aceptar);
	//print_r($estado_arreglo);




	if ((!($solicitudDesarchivo)) && ($aceptar)){ 
		$tpl->assign('include_file', 'cartel.htm');
		$tpl->assign('imagen', 'informacion.jpg');
		$tpl->assign('msg', 'No hay solicitudes de desarchivo.');
		}
		
	$tpl->assign('body',$body);
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION . ' - Bandeja Desarchivo');
	$tpl->assign('menu', "menu_oceba.htm");
	$tpl->assign('links',$links1);
	// $tpl->assign('sublinks',$sublinks2);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
    //armo template
	$tpl = new tpl();
	if ($dg->getRecordCount() > 0 ) {		
		$salida_grilla=$dg->getOutput();
		$dg->setRenderer('Pager');
		$salida_grilla.=$dg->getOutput();
		$dg->setRendererOption('onMove', 'updateGrid', true);
	}
	else{
		if ($aceptar == 'Filtrar') {
			$tpl->assign('include_file', 'cartel.htm'); 
			$tpl->assign('imagen', 'informacion.jpg');
			$tpl->assign('msg', 'No hay clientes para mostrar.');
			$tpl->assign('body', '<div align="center">'.$frm->toHTML().'</div>');
		}
	}
	$tpl->assign('body', '<div align=center><b>Clientes</b></div>
	<div align="center"><br/>'.$frm->toHTML().'</div><div><br/>'.$salida_grilla.'</div><br/><b>Se encontraron '.$dg->getRecordCount().' Clientes<b/><br/><br/>');
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo','Clientes');
	$tpl->assign('menu', "menu_oceba.htm");	
	$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('index.htm');	    
    exit;
?>