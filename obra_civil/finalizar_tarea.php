<?php
    ob_start();
	require_once('../config/web.config');
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	//require_once('../seguridad/seguridad.config');
	// PEAR
	require_once ('DB.php');
	require_once('DB/DataObject/FormBuilder.php');
	require_once('HTML/QuickForm.php');
	// Librerias propias
	require_once(INC_PATH.'/comun.php');	
	require_once(INC_PATH.'/rutinas.php');	
	require_once(INC_PATH.'/grilla.php');	
	require_once(AUTHFILE);
	
	//DB_DataObject::debugLevel(5); 

	$_SESSION['menu_principal'] = 6;

	$obra_civil = $_GET['contenido'];

	$tpl = new tpl();
	$titulo_grilla = 'Agregar tareas';

	$do_obra_civil = DB_DataObject::factory('obra_civil');
	$do_obra_civil -> obra_civil_id = $obra_civil;

	$do_obra_civil_hito = DB_DataObject::factory('obra_civil_hito');

	$do_hito = DB_DataObject::factory('hito');
	$do_obra_civil_hito -> joinAdd($do_hito);

	$do_obra_civil_hito_tarea = DB_DataObject::factory('obra_civil_hito_tarea');
	//join tarea
	$do_tarea = DB_DataObject::factory('tarea');

	$do_obra_civil_hito_tarea -> joinAdd($do_tarea);
	$do_obra_civil_hito -> joinAdd($do_obra_civil_hito_tarea);
	$do_obra_civil -> joinAdd($do_obra_civil_hito);
	//$j=-2;
	$do_obra_civil -> orderBy('obra_civil_hito_id ASC');
	$do_obra_civil -> find();
	$i=0;
	if($do_obra_civil -> N > 0){
		while ( $do_obra_civil -> fetch())
			{
				if(($do_obra_civil -> hito_id <> $anterior_hito)or( $i==0 ))
					$hitos_finalizados.='<input name="obra_civil_hito_id[]" value="'.$do_obra_civil -> obra_civil_hito_id.'" type="hidden" />';

				$i++;

				if($do_obra_civil -> hito_id <> $anterior_hito){
					$hitos_finalizados.='
							<tr bgcolor="#e3503e" style="border: 0px;"> 
	            				<td align="center" style="vertical-align: middle; border: 0px" text-align="center">
									<font size="1px" color="#FFFFFF">'.$do_obra_civil -> hito_nombre.' - Peso: '.$do_obra_civil -> obra_civil_hito_peso.' </font></td><td style="border: 0px">
								</td>
							</tr>
							';					
				}		
				if($do_obra_civil -> obra_civil_hito_tarea_estado == 1){
					$hitos_finalizados.='
							<tr>
								<td border="0" align="right" valign="top"><b>'.$do_obra_civil -> tarea_descripcion.'</b></td>
								<td border="0" valign="top" align="left"><img title="Finalizada" src="../img/spirit20_icons/system-tick-alt-02.png"> '.fechaAntiISO($do_obra_civil -> obra_civil_hito_tarea_fecha_finalizacion).'</td>
						 	</tr>';
					//$j++;
				}
				else{
					$hitos_finalizados.='
								 <tr>
									<td border="0" align="right" valign="top"><b>'.$do_obra_civil -> tarea_descripcion.'</b> </td>
									<td border="0" valign="top" align="left">	<input name="tarea[]" type="checkbox" value="'.$do_obra_civil -> obra_civil_hito_tarea_id.'"/></td>
							 	 </tr>';
					//$j++;
				}
				
				if(!($anterior_hito))
					$estado_avance_nombre = $do_obra_civil -> estado_avance_descripcion;

				$anterior_hito = $do_obra_civil -> hito_id;

			}
			$botones='
			<tr border="0">
							<td align="right" valign="top"></td>
							<td valign="top" align="left"><input name="agregar" value="Agregar" type="submit" /><input name="cerrar" value="Cerrar" type="button" onclick="cerrarDialogo()" /></td>
			</tr>';
	}else{
		$hitos_finalizados='<tr bgcolor="#e3503e" style="border: 0px;"> 
	            				<td align="center" style="vertical-align: middle; border: 0px" text-align="center">
									<font size="1px" color="#FFFFFF">Debe configurar hitos, antes de finalizar tareas</font></td><td style="border: 0px">
								</td>
							</tr>';
		$botones='
			<tr border="0">
							<td align="right" valign="top"></td>
							<td valign="top" align="left"><input name="cerrar" value="Cerrar" type="button" onclick="cerrarDialogo()" /></td>
			</tr>';

	}
	/*$do_tarea_hito = DB_DataObject::factory('tarea_hito');
	$do_tarea = DB_DataObject::factory('tarea');
	$do_tarea_hito -> joinAdd($do_tarea);
	$do_tarea_hito -> find();

	while ( $do_tarea_hito -> fetch())
		{
			$tareas_mostrar.='<tr>
								<td border="0" align="right" valign="top"><b>'.$do_tarea_hito -> tarea_descripcion.'</b></td>
								<td border="0" valign="top" align="left" style="width:3px">	<input name="tarea[]" type="checkbox" value="'.$do_tarea_hito -> tarea_id.'"/></td>
						 	 </tr>';
		}*/

	$body =
           '
           <br /><div id="contenido"><h3>'.$titulo_grilla.'</h3></div><br />
          	<div id="contenido"><p>'.$datos.'</p></div>	
            <div id="contenido"><p>
            	<form action="index.php" border="0" method="post">
            		<table border="0">
            			
            			<tr bgcolor="#b6192a" style="border: 0px;"> 
            				<td align="center" style="vertical-align: middle; border: 0px" text-align="center">
								<font size="1px" color="#FFFFFF">Datos de avance</font></td><td style="border: 0px">
							</td>
						</tr>
						 <tr>
							<td border="0" align="right" valign="top"><b>Fecha</b></td>
							<td valign="top" align="left">
								<input id="avance_fecha" readonly type="text" name="avance_fecha" title="DD-MM-AAAA" size="11" value="'.date('d-m-Y').'">
							</td>						
						 </tr>

						<tr bgcolor="#b6192a" style="border: 0px;"> 
            				<td align="center" style="vertical-align: middle; border: 0px" text-align="center">
								<font size="1px" color="#FFFFFF">Hitos</font></td><td style="border: 0px">
							</td>
						</tr>
						 '.$hitos_finalizados.'
						 '.$botones.'
					</table>
            	</form>
            </p></div>';

	$tpl->assign('body', $body);
    //$tpl->assign('menu','popUpSinEncabezado.htm');
	//$tpl->assign('webTitulo', WEB_TITULO);
	//$tpl->assign('secTitulo', WEB_SECCION . ' - Alta unidad funcional');
	//$tpl->assign('links',$links1);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre'] );
	$tpl->display('popUpSinEncabezado.htm');
	ob_end_flush();
?>