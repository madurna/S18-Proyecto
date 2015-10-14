<?php
function rangoFechas($fechaInicio=null,$fechaFin=null)
{
    $dias = array();
    if (($fechaFin < $fechaInicio) or (!$fechaFin))
		return array();
	
	for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
        $dias[intval(date("md", $i))] = date("Y-m-d", $i);
    }
    return $dias;
}