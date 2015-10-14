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
     $hora = 0;
     $horas = array();
     
     
     if($procesa['frecuencia'] == 1 || $procesa['duracion'] == 1){

        for($i=intval($hora_cierre);$i<=(intval($hora_cierre)+$cant_horas);$i++){
            if($i == 0 || $hora == 0){
                $horas[] = 24;
            }
            else{
                if($hora == 24){
                    $horas[] = 24;
                    $hora = 0;
                }
                else{
                    $horas[] = $hora;
                }
            }
            $hora++;
        }

        if($hora_cierre == 0){
            $hora_cierre = 24;
        }
		
        //Bueno tengo las horas ahora tengo que ver los extremos
        $inicio = 60 - $minuto_cierre;        
        $interrupcion = array();
     
        $coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'];
        $interrupcion[$hora_cierre] = ($coeficientes[$emp_id][$tarifa_id][$hora_cierre]['valor'])*($inicio/60);
        $interrupcion[$hora_apertura] = ($coeficientes[$emp_id][$tarifa_id][$hora_apertura]['valor'])*($minuto_apertura/60);

        //Quito los de las puntas
        unset($horas[$hora_cierre]);
        unset($horas[$hora_apertura]);

        //Calculo las del medio
        foreach($horas as $h){            
//            echo($coeficientes[$emp_id][$tarifa_id][$h]['valor']);
//            echo '<br />';
            $interrupcion[] = floatval($coeficientes[$emp_id][$tarifa_id][$h]['valor']);
        }
        
        //Paso el array para calcular la multa
        return ($interrupcion);
    }
    else{
        return 0;
    }
}
