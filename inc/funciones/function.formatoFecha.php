<?php
/**
 * Xajax. Datos para transferir
 * 
 * @param object    $objResponse   Xajax Response
 */

function formatoFecha($fecha)
{
	$fechaAux = explode("-",$fecha);
	$dia = $fechaAux[2];
	$mes = $fechaAux[1];
	$ano = $fechaAux[0];
	
	$fecha = $dia."-".$mes."-".$ano;
	return $fecha;
}
?>