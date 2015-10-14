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

	$obra_civil_id = $_GET['contenido'];

	$do_obra_civil_hito = DB_DataObject::factory('obra_civil_hito');
	//$do_obra_civil_hito -> whereAdd("");
	$do_hito = DB_DataObject::factory('hito');
	$do_obra_civil_hito -> joinAdd($do_hito);

	$do_obra_civil_hito -> whereAdd("((obra_civil_hito_obra_civil_id = $obra_civil_id))");
	//$do_tarea_hito -> whereAdd("");
	
	$do_obra_civil_hito -> find();

	$tpl = new tpl();
	$titulo_grilla = 'Agregar hitos';
	$i=0;
	while ( $do_obra_civil_hito -> fetch())
		{
			$i++;
			$checked = 'checked disabled ';
			
			$hitos_mostrar.='
						<tr>
							<td border="0" align="right" valign="top"><b>'.$do_obra_civil_hito -> hito_nombre.'</b></td>
							<td border="0" valign="top" align="left">	
								&nbsp;&nbsp;
								<input name="hito_finales[]" type="checkbox" value="'.$do_obra_civil_hito -> hito_id.'" '.$checked.' />
							</td>
						<tr>
							<td border="0" align="right" valign="top"><b>Peso</b></td>	
							<td border="0" valign="top" align="left">	
								<input name="peso_finales_'.$do_obra_civil_hito -> hito_id.'" size="8" type="text" value="'.$do_obra_civil_hito -> obra_civil_hito_peso.'" '.$checked.' />
							</td>
						</tr>';
			$v_hito[$i]=$do_obra_civil_hito -> hito_id;
		}

	$do_hito = DB_DataObject::factory('hito');
	$do_hito -> find();

	while ( $do_hito -> fetch())
		{
			$checked = ' ';
			$llave = 1;

			for($i=1;$i<=count($v_hito);$i++) 
			{
				if ($v_hito[$i] == $do_hito -> hito_id)
					$llave = 0;
			}
			if($llave)
				$hitos_mostrar.='
						<tr>
							<td border="0" align="right" valign="top"><b>'.$do_hito -> hito_nombre.'</b></td>
							<td border="0" valign="top" align="left">	
								&nbsp;&nbsp;
								<input name="hito[]" type="checkbox" value="'.$do_hito -> hito_id.'" '.$checked.' />
							</td>
						<tr>
							<td border="0" align="right" valign="top"><b>Peso</b></td>	
							<td border="0" valign="top" align="left">	
								<input name="peso_'.$do_hito -> hito_id.'" size="8" type="text" value="" '.$checked.' />
							</td>
						</tr>';
		}

	$do_obra_civil = DB_DataObject::factory('obra_civil');
	$do_obra_civil -> obra_civil_id = $obra_civil_id;
	$do_obra_civil -> find(true);

	$body =
           '<br /><div id="contenido"><h3>'.$titulo_grilla.'</h3></div><br />
          	<div id="contenido"><p>'.$datos.'</p></div>	
            <div id="contenido"><p>
            	<form action="index.php" border="0" method="post">
            		<table border="0">
            			<tr bgcolor="#b6192a" style="border: 0px;"> 
            				<td align="center" style="vertical-align: middle; border: 0px" text-align="center">
								<font size="1px" color="#FFFFFF">'.$do_obra_civil -> obra_civil_descripcion.'</font></td><td style="border: 0px">
							</td>
						</tr>
						'.$hitos_mostrar.'
						<tr border="0">
							<td align="right" valign="top"></td>
							<td valign="top" align="left">
								<input name="agregar" value="Agregar" type="submit" />
								<input name="cerrar" value="Cerrar" type="button" onclick="cerrarDialogo()" />
							</td>
							<input name="obra_civil" value="'.$obra_civil_id.'" type="hidden" />
						</tr>
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