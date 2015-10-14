<?php
/**
 * Compara los clientes activos con las estimaciones para mostrar los que superan el porcentaje
 * @param <array> $clientes_activos
 * @param <array> $estimaciones_agrupadas
 * @param <float> $porcentaje
 */
function compararCliConEst($clientes_activos = array(),$estimaciones_agrupadas = array(),$porcentaje = null, $periodo = 0)
{
    $datos_comparados = array();
    $claves = array();
    if($estimaciones_agrupadas != null)
        $claves = array_merge(array_keys($clientes_activos),array_keys($estimaciones_agrupadas));
    $claves_unicas = array_unique($claves);

    //Hago la comparacion

    foreach($claves_unicas as $cl){
        $cant_clientes_porc = round($clientes_activos[$cl] * ($porcentaje/100),0);
        $cant_clientes = $clientes_activos[$cl];
        $cant_estimaciones = $estimaciones_agrupadas[$cl];

        $datos_comparados[$periodo.$cl]['periodo'] = $periodo;
        $datos_comparados[$periodo.$cl]['tarifa_nombre'] = $cl;
        $datos_comparados[$periodo.$cl]['cant_clientes'] = $cant_clientes;
        $datos_comparados[$periodo.$cl]['cant_estimaciones'] = intval($cant_estimaciones);
        $datos_comparados[$periodo.$cl]['porcentaje'] = '% '.$porcentaje;
        $datos_comparados[$periodo.$cl]['cant_clientes_porc'] = $cant_clientes_porc;

        if($cant_estimaciones > $cant_clientes_porc){
            $datos_comparados[$periodo.$cl]['supera'] = "Si";
        }
        else{
            $datos_comparados[$periodo.$cl]['supera'] = "No";
        }
    }

    return $datos_comparados;

}