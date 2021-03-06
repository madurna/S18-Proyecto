<?php
ini_set("memory_limit","3072M");
include_once('MDB2.php');
require_once(INC_PATH.'/funciones/cargarCortesEstimados.php');
require_once(INC_PATH.'/funciones/calcularEnergiaNoSuministradaEstimada.php');
require_once(INC_PATH.'/funciones/function.accionesPostCalculoMultas.php');
//require_once(INC_PATH.'/funciones/function.regLog.php');

function calcularMultaEstimada($arch_id = 0,$cts = null,$clientes = null)
{
    define('CANTCLIENTES',50000);
    define('COMMITSQL',50000);
    define('PROCESAR',1);
    define('REDONDEOENS',2);
    define('REDONDEOENFAC',8);
    define('REDONDEOMULTA',2);
    define('REDONDEOFORM',2);
    define('REDONDEOPEN',2);
    define('REDONDEOINT',8);

    // Si me pasan como parametro cts
    // puedo actualizar esos los clientes de esos cts

    //DB_DataObject::debugLevel(5);
    $config = PEAR::getStaticProperty("DB_DataObject",'options');
    $mdb2 =& MDB2::connect($config['database']);

    if (PEAR::isError($mdb2)) {
        die($mdb2->getMessage());
    }

    if(PROCESAR){

        $row = null;
        $penaliza = array();

        //Datos para testeo
        $minimoMinutos = 3;
        $minimoHoras = 1;
        $sem_id = 9;
        $emp_id = 1;
        $tipo_distribuidora_id = 2;
        $zona_id = 2;
        unset($_SESSION['frecuencia']);

        echo_debug("Muestro con un redondeo de ".REDONDEOENS." decimales la energia no suministrada.");
		echo_debug("Calculo la penalizacion (int*ki) para energia no suministrada  con un redondeo de ".REDONDEOPEN." decimales.");
		echo_debug("La muestra de las formulas de energia no suministrada es con ".REDONDEOPEN." decimales que es lo que se utiliza para calcular.");		
		echo_debug("La muestra del costo de energia no suministrada es con ".REDONDEOENFAC." decimales.");		
		echo_debug("Muestro con un redondeo de ".REDONDEOMULTA." decimales la multa calculada.");
		echo_debug("La muestra de las formulas de la multa es con ".REDONDEOFORM." decimales que es lo que se utiliza para calcular.");		
		echo_debug("Calculo con un redondeo a ".REDONDEOINT." decimales las interrupciones.");


        echo_debug('Busco semestre, empresa, tipo de distribuidora y zona de archivos importacion para el arch_id '.$arch_id.'');
        $sql = "SELECT ai.arch_id, ai.arch_semestre, ai.arch_emp_id, e.emp_tdist_id, e.emp_zona_id
                  FROM archivos_importacion ai
                  INNER JOIN empresas e ON e.emp_id = ai.arch_emp_id
                  WHERE (arch_fecha_anulacion IS NULL OR arch_fecha_anulacion = '0000-00-00 00:00:00')
                  AND arch_id = ".$arch_id;
        //$do->query($sql);

        $res = $mdb2->query($sql);
	
        if($res->numRows() > 0){
            while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                $sem_id = $do['arch_semestre'];
                $emp_id = $do['arch_emp_id'];
                $zona_id = $do['emp_zona_id'];
                $tipo_distribuidora_id = $do['emp_tdist_id'];

            }

            $semestre_calculado = 0;

            //Cargo la tabla de cortes por usuario estimado
            echo_debug('Inicio de la generacion de cortes estimados');
	    $semestre_calculado = cargarCortesEstimados($sem_id,$tipo_distribuidora_id,$arch_id,$cts,$clientes,$mdb2);

            echo_debug('Calculando multas para el semestre: '.$semestre_calculado.'');

            //Vector con penalizaciones
            $penaliza = array();

            //Me fijo la cantidad de usuarios en cortes por usuario
            echo_debug('Busco los clientes de cortes por usuario estimado agrupados por cliente');
            $sql = "SELECT cortesusuaest_cli_id FROM cortes_por_usuario_estimado
                    WHERE cortesusuaest_arch_id = ".$arch_id."
                    AND cortesusuaest_sem_id = ".$semestre_calculado."
                    GROUP BY cortesusuaest_cli_id";

            $res = $mdb2->query($sql);

            $lista_clientes = array();
            $i = 0;
            if($res->numRows() > 0){
                while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                    set_time_limit(30);
                    $lista_clientes[] = $do['cortesusuaest_cli_id'];
                    $i++;
                }
            }

            echo_debug('Cortes encontrados: '.$i.'');
            $cant_lotes_clientes = 0;

            $lotes_clientes = array_chunk($lista_clientes,CANTCLIENTES);
            $cant_lotes_clientes = count($lotes_clientes);
            echo_debug('Proceso en lotes de : '.CANTCLIENTES.'');

            for($i= 0; $i < $cant_lotes_clientes; $i++){
                $multas_por_usuario_estimada = array();
                $j = 0;

                $penaliza = calcularEnergiaNoSuministradaEstimada($minimoMinutos,$minimoHoras,$semestre_calculado,$emp_id,$tipo_distribuidora_id,$zona_id,$arch_id,$lotes_clientes[$i],$mdb2);

                if(count($penaliza) > 0){

                    //Traigo el valor de las tarifas
                    $sql = "SELECT cens_valor, cens_tarifa_id FROM costo_energia_no_suministrada";
                    $res2 = $mdb2->query($sql);


                    $costos_energia_no_suministrada = array();

                    //Busco los cortes de energia no suministrada
                    while($do = $res2->fetchRow(MDB2_FETCHMODE_ASSOC)){
                        $costos_energia_no_suministrada[$do['cens_tarifa_id']] = $do['cens_valor'];
                    }

    //                var_dump($costos_energia_no_suministrada);
    //                exit;

                    //Sumo las multas de ese usuario
                    $multa_total_calculada = 0;

    //                var_dump($penaliza);
    //                exit;

                    //Sumo las multas de ese usuario
                    $multas_calculadas = array();

                    foreach($penaliza as $key => $pen){
                        //Busco el valor de la multa segun
                        if(isset($costos_energia_no_suministrada[$pen['tarifa_id']]))
                            $penaliza[$key]['costo_energia_no_suministrada'] = $costos_energia_no_suministrada[$pen['tarifa_id']];
                        else
                            $penaliza[$key]['costo_energia_no_suministrada'] = 0;

                        $penaliza[$key]['multa_usuario'] = $pen['energia_no_suministrada'] * $costos_energia_no_suministrada[$pen['tarifa_id']];
                        //$penaliza[$key]['multa_usuario_formula'] = $pen['energia_no_suministrada']." * ".$costos_energia_no_suministrada[$pen['tarifa_id']];
                        
                        //$penaliza[$key]['multa_usuario_formula'] = '';

                        $penaliza[$key]['energia_no_suministrada_total'] = $penaliza[$key]['interrupcion'] * ($penaliza[$key]['energia_facturada']/4380);

                        //$penaliza[$key]['multa_usuario'] = number_format(($pen['energia_no_suministrada'] * $costos_energia_no_suministrada[$pen['tarifa_id']]),2);
                        $multa_total_calculada+= $penaliza[$key]['multa_usuario'];


                        $multas_calculadas[$pen['cli_id']]['cli_id'] = $penaliza[$key]['cli_id'];
                        $multas_calculadas[$pen['cli_id']]['ct_id'] = ($penaliza[$key]['ct_id'] == '') ? 'NULL' : $penaliza[$key]['ct_id'];
                        $multas_calculadas[$pen['cli_id']]['arch_id'] = $arch_id;
                        $multas_calculadas[$pen['cli_id']]['arch_linea'] = $penaliza[$key]['arch_linea'];
                        $multas_calculadas[$pen['cli_id']]['frecuencia'] = $penaliza[$key]['frecuencia'];
                        $multas_calculadas[$pen['cli_id']]['duracion'] = $penaliza[$key]['duracion'];
                        $multas_calculadas[$pen['cli_id']]['numero_corte'] = $penaliza[$key]['numero_corte'];
                        $multas_calculadas[$pen['cli_id']]['sem_id'] = $penaliza[$key]['sem_id'];
                        $multas_calculadas[$pen['cli_id']]['energia_facturada'] = $penaliza[$key]['energia_facturada'];
                        $multas_calculadas[$pen['cli_id']]['costo_energia_no_suministrada'] = $penaliza[$key]['costo_energia_no_suministrada'];
                        $multas_calculadas[$pen['cli_id']]['energia_no_suministrada'] = $penaliza[$key]['energia_no_suministrada'];
                        $multas_calculadas[$pen['cli_id']]['multa_calculada'] += $penaliza[$key]['multa_usuario'];
                        $multas_calculadas[$pen['cli_id']]['multa_calculada_formula'][] = $penaliza[$key]['multa_usuario_formula'];
                        $multas_calculadas[$pen['cli_id']]['interrupcion_formula'][] = $penaliza[$key]['interrupcion_formula'];
                        $multas_calculadas[$pen['cli_id']]['energia_no_suministrada_formula'] = $penaliza[$key]['energia_no_suministrada_formula'];
                        $multas_calculadas[$pen['cli_id']]['energia_no_suministrada_total'] += $penaliza[$key]['energia_no_suministrada_total'];

                    }

//                    print_r($multas_calculadas);
//                    exit;
    //
                    unset($penaliza);
                    $penaliza = array();
                    $multa_usuario_formula = null;
                    $interrupcion_formula = null;

                    //Recorro penaliza para acumular las multas
                    foreach($multas_calculadas as $key => $pen){
                        //Guardo la info en multas de usuario
                        $sql = "SELECT COUNT(*) AS cantidad_multas, multasusuaest_id
                                FROM multas_por_usuario_estimada mpue
                                WHERE mpue.multasusuaest_multa = ".$pen['multa_usuario']."
                                AND mpue.multasusuaest_enernosum_pen = ".$pen['costo_energia_no_suministrada']."
                                AND mpue.multasusuaest_enernosum_tot = ".$pen['energia_no_suministrada']."
                                AND mpue.multasusuaest_cli_id = ".$pen['cli_id']."
                                AND mpue.multasusuaest_sem_id = ".$pen['sem_id'];


                        $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);

                        $multa_usuario_formula = '('.implode(')+(',$pen['multa_calculada_formula']).')';
                        $interrupcion_formula = '('.implode(')+(',$pen['interrupcion_formula']).')';


                        if($row->cantidad_multas > 0){
                            $sql = "UPDATE multas_por_usuario_estimada
                                    SET multasusuaest_multa = ".$pen['multa_usuario']."
                                    WHERE multasusuaest_id = ".$row['multasusuaest_id'];
                            $res2 = $mdb2->query($sql);

                        }
                        else{
                            $j++;
                            $multas_por_usuario_estimada[] = "(".round($pen['multa_calculada'],REDONDEOMULTA).",".round($pen['costo_energia_no_suministrada'],REDONDEOENFAC).",".round($pen['energia_no_suministrada'],REDONDEOENS).",".$pen['cli_id'].",".$pen['ct_id'].",".$pen['sem_id'].",".$arch_id.",".$pen['numero_corte'].",".$pen['frecuencia'].",".$pen['duracion'].",'".$interrupcion_formula."','".$pen['energia_no_suministrada_formula']."',".round($pen['energia_no_suministrada_total'],REDONDEOENS).")";
                        }
                    }

                    unset($multas_calculadas);;
                }

//                print_r($multas_por_usuario_estimada);
//                exit;
                
                $lotes = array_chunk($multas_por_usuario_estimada,COMMITSQL);

                try{
                    $res = $mdb2->query("BEGIN");
                    foreach($lotes as $lot){
                        set_time_limit(30);
                        $sql = "INSERT INTO multas_por_usuario_estimada (
                                multasusuaest_multa,
                                multasusuaest_enernosum_pen,
                                multasusuaest_enernosum_tot,
                                multasusuaest_cli_id,
                                multasusuaest_ct_id,
                                multasusuaest_sem_id,
                                multasusuaest_ct_arch_id,
                                multasusuaest_numero_corte,
                                multasusuaest_frecuencia,
                                multasusuaest_duracion,
                                multasusuaest_interrup_formula,
                                multasusuaest_enernosum_formula,
                                multasusuaest_enernosum_total) VALUES ".implode(',',$lot);

                        $res = $mdb2->query($sql);

                    }

                    $res = $mdb2->query("COMMIT");

                    echo_debug('Inserto en multas por usuario estimada '.$j.' registros ');

                }
                catch(Exception $e){
                    echo $sql;
                    $res = $mdb2->query("ROLLBACK");
                    die($e->getMessage());
                }

                unset($multas_por_usuario_estimada);
                $multas_por_usuario_estimada = array();

            }
        }
            echo_debug('Finalizada la inserción de multas por usuario estimada ');
    }

    //accionesPostCalculoMultasEstimada($arch_id,$mdb2);
}
