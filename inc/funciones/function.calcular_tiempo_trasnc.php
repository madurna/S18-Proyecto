<?php
/**
 * Me da los valores confirmados
 * @param <array> $session
 */
function calcular_tiempo_trasnc($hora1,$hora2){
    $separar[1]=explode(':',$hora1);
    $separar[2]=explode(':',$hora2);

    $total_minutos_trasncurridos[1] = ($separar[1][0]*60)+$separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0]*60)+$separar[2][1];
    $total_minutos_trasncurridos = $total_minutos_trasncurridos[1]-$total_minutos_trasncurridos[2];
    return ($total_minutos_trasncurridos);
    //if($total_minutos_trasncurridos<=59) return ($total_minutos_trasncurridos);
//    elseif($total_minutos_trasncurridos>59){
//        $HORA_TRANSCURRIDA = round($total_minutos_trasncurridos/60);
//        if($HORA_TRANSCURRIDA<=9) $HORA_TRANSCURRIDA='0'.$HORA_TRANSCURRIDA;
//        $MINUITOS_TRANSCURRIDOS = $total_minutos_trasncurridos%60;
//        if($MINUITOS_TRANSCURRIDOS<=9) $MINUITOS_TRANSCURRIDOS='0'.$MINUITOS_TRANSCURRIDOS;
//        echo ($HORA_TRANSCURRIDA.':'.$MINUITOS_TRANSCURRIDOS.' Horas');
//        exit;
//    }
}
?>