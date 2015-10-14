<?php
/**
 * Calcula la interrupcion del servicio
 * @param <int> $tipo
 * @param <array> $procesa
 * @param <array> $coeficientes
 * @param <int> $hora_cierre
 * @param <int> $hora_apertura
 * @param <int> $emp_id
 * @param <int> $tarifa_id
 * @param <int> $cant_horas
 * @param <int> $cant_minutos
 * @param <int> $minuto_cierre
 * @param <int> $minuto_apertura
 * @return <float> Suma de los valores correspondientes al coeficiente por el tiempo de interrupcion
 */
function calcularInterrupcion(
    $tipo = 'D',
    $procesa = array(),
    $cliente_id = 0,
    $coeficientes = array(),
    $hora_cierre = null,
    $hora_apertura = null,
    $emp_id = 0,
    $tarifa_id = 0,
    $cant_horas = 0,
    $cant_minutos = 0,
    $minuto_cierre = 0,
    $minuto_apertura = 0,
    $segundo_cierre = 0,
    $segundo_apertura = 0
)
{	
	/*
	 * SELECT CONCAT(TIMESTAMPDIFF(MINUTE, cortesusua_fecha_apertura, cortesusua_fecha_cierre),'.', TIMESTAMPDIFF(SECOND, cortesusua_fecha_apertura, cortesusua_fecha_cierre)) AS duracion
FROM cortes_por_usuario WHERE cortesusua_cli_id = 1791654
    */
     //Busco las horas del medio
     $hora = intval($hora_apertura);
     
     $horas = array();
     $dias = array();
     //if($procesa['frecuencia'][$cliente_id] == 1 || $procesa['duracion'][$cliente_id] == 1){

        for($i=intval($hora_apertura);$i<=(intval($hora_apertura)+$cant_minutos/60);$i++){
               if($hora == 25){
                    $hora = 1;
                    $horas[$hora] = 1;
                    
                }
                else{
                    if($hora_apertura == $hora && $minuto_apertura == 0){
                        $horas[$hora] = $hora_apertura;
                    }
                    else{
                        $horas[$hora] = $hora;
                    }
                }

            $dias[$hora]++;
            $hora++;
        }

        if($hora_cierre == 0){
            $hora_cierre = 24;
        }

        if($hora_apertura == 0){
            $hora_apertura = 24;
        }
        
        unset($horas[$hora_cierre]);
        unset($horas[$hora_apertura]);

        //Bueno tengo las horas ahora tengo que ver los extremos
        $segundos_en_minutos_apertura = $segundo_apertura/60;
        $segundos_en_minutos_cierre = $segundo_cierre/60;
        
        if($hora_cierre != $hora_apertura){			
            $inicio = (60 - ($minuto_apertura + $segundos_en_minutos_apertura));
            $fin = $minuto_cierre + $segundos_en_minutos_cierre;
        }
        else{
            $inicio = 'No';
            $fin = ($minuto_cierre + $segundos_en_minutos_cierre) - ($minuto_apertura + $segundos_en_minutos_apertura);
        }
        
        $interrupcion = array();

        //if($coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'] == null)
            //echo_debug('No hay coeficientes para esta tarifa');
        //Calulo el valor de las multas de los extremos (coeficientes s/empresa, tarifa, hora) * (duracion en horas)
        //Saco los valores proporcionales de cantidad de horas para el cierre y la apertura de servicio
        //if($coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'] == null)
        
        
        if($inicio != 'No')
            $interrupcion[$hora_apertura] = round(($coeficientes[$emp_id][$tarifa_id][$hora_apertura]['valor'])*($inicio/60),REDONDEOINT);

        $interrupcion[$hora_cierre] = round(($coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'])*($fin/60),REDONDEOINT);
        
        if($dias[$hora_cierre] > 0)
            $interrupcion[$hora_cierre] += (($dias[$hora_cierre]-1))*$coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'];
        else
            $interrupcion[$hora_cierre] += (($dias[$hora_cierre]))*$coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'];

        if($dias[$hora_apertura] > 0)
            $interrupcion[$hora_apertura] += (($dias[$hora_apertura]-1))*$coeficientes[$emp_id][$tarifa_id][$hora_apertura]['valor'];
           else
            $interrupcion[$hora_apertura] += (($dias[$hora_apertura]))*$coeficientes[$emp_id][$tarifa_id][$hora_apertura]['valor'];
            
        //Quito los de las puntas
//        unset($horas[$hora_cierre]);
//        unset($horas[$hora_apertura]);

        //Calculo las del medio
        foreach($horas as $h){            
            //Tomo el valor de la multa de las horas, valor coeficientes s/empresa, tarifa, hora
            $interrupcion[$h] = round($coeficientes[$emp_id][$tarifa_id][$h]['valor']*$dias[$h],REDONDEOINT);
        }
        
        //Paso el array para calcular la multa
        return ($interrupcion);
//    }
//    else{
//        return 0;
//    }
}

function calcularInterrupcionToString(
    $tipo = 'D',
    $procesa = array(),
    $cliente_id = 0,
    $coeficientes = array(),
    $hora_cierre = null,
    $hora_apertura = null,
    $emp_id = 0,
    $tarifa_id = 0,
    $cant_horas = 0,
    $cant_minutos = 0,
    $minuto_cierre = 0,
    $minuto_apertura = 0
)
{

	
	
    //Busco las horas del medio
    $hora = intval($hora_apertura);

    $horas = array();
    $dias = array();

        for($i=intval($hora_apertura);$i<=(intval($hora_apertura)+$cant_minutos/60);$i++){
               if($hora == 25){
                    $hora = 1;
                    $horas[$hora] = 1;

                }
                else{
                    if($hora_apertura == $hora && $minuto_apertura == 0){
                        $horas[$hora] = $hora_apertura;
                    }
                    else{
                        $horas[$hora] = $hora;
                    }
                }

            $dias[$hora]++;
            $hora++;
        }


    if($hora_cierre == 0){
        $hora_cierre = 24;
    }

    if($hora_apertura == 0){
        $hora_apertura = 24;
    }
    
    unset($horas[$hora_cierre]);
    unset($horas[$hora_apertura]);

    //Bueno tengo las horas ahora tengo que ver los extremos
    $segundos_en_minutos_apertura = $segundo_apertura/60;
    $segundos_en_minutos_cierre = $segundo_cierre/60;
        
    if($hora_cierre != $hora_apertura){			
		$inicio = (60 - ($minuto_apertura + $segundos_en_minutos_apertura));
        $fin = $minuto_cierre + $segundos_en_minutos_cierre;
    }
    else{
		$inicio = 'No';
        $fin = ($minuto_cierre + $segundos_en_minutos_cierre) - ($minuto_apertura + $segundos_en_minutos_apertura);
    }

    $interrupcion = array();
    $interrupcionM = array();

    if($coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'] != null){
        if($inicio != 'No')
            $interrupcion[$hora_apertura] .= "(".round($coeficientes[$emp_id][$tarifa_id][$hora_apertura]['valor'],REDONDEOINT).")*(".$inicio."/60)";

        $interrupcion[$hora_cierre] .= "(".round($coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'],REDONDEOINT).")*(".$fin."/60)";
    }
    else{
        if($inicio != 'No')
            $interrupcion[$hora_apertura] = "S/C(".round($coeficientes[$emp_id][$tarifa_id][$hora_apertura]['valor'],REDONDEOINT).")*(".$inicio."/60)";

        $interrupcion[$hora_cierre] = "S/C(".round($coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'],REDONDEOINT).")*(".$fin."/60)";
    }
    
//    if($dias[$hora_cierre] > 0)
//        $interrupcion[$hora_cierre] .= "+(".($dias[$hora_cierre]-1).")*".$coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'];
//    else
//        $interrupcion[$hora_cierre] .= "+(".($dias[$hora_cierre]).")*".$coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'];
//
//    if($dias[$hora_apertura] > 0)
//        $interrupcion[$hora_apertura] .= "+(".($dias[$hora_apertura]-1).")*".$coeficientes[$emp_id][$tarifa_id][$hora_apertura]['valor'];
//    else
//        $interrupcion[$hora_apertura] .= "+(".($dias[$hora_apertura]).")*".$coeficientes[$emp_id][$tarifa_id][$hora_apertura]['valor'];
    $interrupcionA[0] = $interrupcion[$hora_apertura];
    //Calculo las del medio
    foreach($horas as $h){
        //Tomo el valor de la multa de las horas, valor coeficientes s/empresa, tarifa, hora
        if($coeficientes[$emp_id][$tarifa_id][$h]['valor'] == null)
            $interrupcionA[] = 'S/C('.round($coeficientes[$emp_id][$tarifa_id][$h]['valor']*$dias[$h],REDONDEOINT).')';
        else
            $interrupcionA[] = '('.round($coeficientes[$emp_id][$tarifa_id][$h]['valor']*$dias[$h],REDONDEOINT).')';
    }
    array_push($interrupcionA,$interrupcion[$hora_cierre]);

    return implode("+",$interrupcionA);
 
}
