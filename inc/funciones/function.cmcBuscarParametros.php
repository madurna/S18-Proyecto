<?php
function cmcBuscarParametros($con_modred = 0, $con_tarifa = null, $con_tipo = 'A', $mdb2 = null)
{
    $sql = "SELECT * FROM parametros_conexion
            WHERE parcom_modred = ".$con_modred."
            AND parcom_tipo = '".$con_tipo."'";

    $res = $mdb2->query($sql);
    
	if (PEAR::isError($res)) {
        echo '<br />'.$sql.'<br />';
        die($res->getMessage());
    }

    while($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
        $tarifas = explode(',',$row['parcom_tarifa']);
        $tarifa = array_search($con_tarifa,$tarifas);
        if($tarifa !== false){
            return $row['parcom_dias_habiles'];
        }
    }
    
    return false;
}