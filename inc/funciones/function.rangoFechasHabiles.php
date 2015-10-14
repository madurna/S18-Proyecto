<?php
function rangoFechasHabiles($dias = array())
{
    $dias_habiles_no_habiles = array();

    foreach($dias as $dia){
        $fecha = explode("-",$dia);
        $date = date('D', mktime(0,0,0,$fecha[1],$fecha[2],$fecha[0]));
        
        if($date == 'Sat' || $date == 'Sun'){
            $dias_habiles_no_habiles['no_habiles'][intval($fecha[1].$fecha[2])] = $dia;
        }
        else{
            $dias_habiles_no_habiles['habiles']['dias'][intval($fecha[2])] = intval($fecha[2]);
            $dias_habiles_no_habiles['habiles']['meses'][intval($fecha[1])] = intval($fecha[1]);
            $dias_habiles_no_habiles['habiles']['anos'][intval($fecha[0])] = intval($fecha[0]);
        }
    }

    return $dias_habiles_no_habiles;
}