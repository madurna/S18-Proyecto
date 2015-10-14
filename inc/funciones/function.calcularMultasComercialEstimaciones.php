<?php

function calcularMultasComercialEstimaciones($cliente_inicial = 0, $estimaciones = array(), $parametros = array()) {
    $cant = 1;
    $monto_estimado = 0;
    $multas_calculadas = array();

//    var_dump($estimaciones);
//        exit;

    foreach ($estimaciones as $est) {

        //corte de control
        if ($cliente_inicial == $est['est_cli_id']) {

            if ($cant > $est['cant_estimaciones_minimas']) {

                $multas_calculadas[$est['est_cli_id']]['emp_cod_oceba'] = $est['emp_cod_oceba'];
                $multas_calculadas[$est['est_cli_id']]['cli_cod_suministro'] = $est['cli_cod_suministro'];
                $multas_calculadas[$est['est_cli_id']]['cli_suc_id'] = $est['cli_suc_id'];
                $multas_calculadas[$est['est_cli_id']]['suc_nombre'] = $est['suc_nombre'];
                $multas_calculadas[$est['est_cli_id']]['cli_titular'] = $est['cli_titular'];
                $multas_calculadas[$est['est_cli_id']]['cli_direccion'] = $est['cli_direccion'];
                $multas_calculadas[$est['est_cli_id']]['cli_nro'] = $est['cli_nro'];
                $multas_calculadas[$est['est_cli_id']]['cli_piso'] = $est['cli_piso'];
                $multas_calculadas[$est['est_cli_id']]['cli_dpto'] = $est['cli_dpto'];
                $multas_calculadas[$est['est_cli_id']]['tarifa_nombre'] = $est['tarifa_nombre'];
                $multas_calculadas[$est['est_cli_id']]['cant_estimaciones_minimas'] = $est['cant_estimaciones_minimas'];
                $multas_calculadas[$est['est_cli_id']]['multa'] += $est['multa'];
                $multas_calculadas[$est['est_cli_id']]['multa_obs'] = $est['multa_obs'];
                


                //debo acumular para el calculo
                $monto_estimado+= $est['est_montoest'];
                $porc_multa = round(($parametros['valor_porcentaje'] / 100), 2);
                $valor_multa = $monto_estimado * $porc_multa;
                $multas_calculadas[$est['est_cli_id']]['multa_calculada'] = number_format($valor_multa, 4);
                $multas_calculadas[$est['est_cli_id']]['cant_estimaciones_multa'] = $cant;
                $multas_archivo = $multas_calculadas[$est['est_cli_id']]['multa'];
                if ($multas_archivo > 0)
                    $multas_calculadas[$est['est_cli_id']]['diferencia'] = "% " . round(abs(($multas_archivo - $valor_multa) / $multas_archivo * 100), 2);
                else
                    $multas_calculadas[$est['est_cli_id']]['diferencia'] = "-";
                $_SESSION['reportes_estimaciones']['multa_calculada'] = $multas_calculadas[$est['est_cli_id']]['multa_calculada'];
            }
        }
        else {
            //Paso al siguiente cliente
            $cliente_inicial = $est['est_cli_id'];

            //Vuelvo a uno
            $cant = 1;
        }

        $cant++;
    }

    return $multas_calculadas;
}
