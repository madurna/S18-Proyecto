<?php
ini_set("memory_limit","3072M");
include_once('MDB2.php');
require_once(INC_PATH.'/funciones/calcularEnergiaNoSuministrada.php');
require_once(INC_PATH.'/funciones/function.accionesPostCalculoMultas.php');
require_once(INC_PATH.'/funciones/function.regLog.php');
function calcularMultasServicioPorCliente($arch_id = 0, $cod_sum = 0,$mdb2 = null)
{
    define('CANTCLIENTES',50000);
    define('COMMITSQL',50000);
    define('PROCESAR',1);
    define('REDONDEOENS',2); //salida
    define('REDONDEOENFAC',8);
    define('REDONDEOMULTA',2); //salida
    define('REDONDEOFORM',2);
    define('REDONDEOPEN',8);
    define('REDONDEOINT',8);
    

//    $config = PEAR::getStaticProperty("DB_DataObject",'options');
//    $mdb2 =& MDB2::connect($config['database']);
//
//    if (PEAR::isError($mdb2)) {
//        die($mdb2->getMessage());
//    }

    if(PROCESAR){
		echo_debug("Muestro con un redondeo de ".REDONDEOENS." decimales la energia no suministrada. <br>");
		echo_debug("Calculo la penalizacion (int*ki) para energia no suministrada  con un redondeo de ".REDONDEOPEN." decimales. <br>");
		echo_debug("La muestra de las formulas de energia no suministrada es con ".REDONDEOPEN." decimales que es lo que se utiliza para calcular.<br>");		
		echo_debug("Muestro con un redondeo de ".REDONDEOMULTA." decimales la multa calculada.<br>");
		echo_debug("La muestra de las formulas de la multa es con ".REDONDEOFORM." decimales que es lo que se utiliza para calcular.<br>");		
		echo_debug("Calculo con un redondeo a ".REDONDEOINT." decimales las interrupciones.<br>");
		
        unset($_SESSION['frecuencia']);
		unset($_SESSION['duracion']);

        echo_debug('Busco semestre, empresa, tipo de distribuidora y zona de archivos importacion<br>');
        //Busco los datos de semestre, empresa, etc de acuerdo al arch_id
        $sql = "SELECT ai.arch_id, ai.arch_semestre, ai.arch_emp_id, e.emp_tdist_id, e.emp_zona_id FROM archivos_importacion ai
                        INNER JOIN empresas e ON e.emp_id = ai.arch_emp_id
                        WHERE (arch_fecha_anulacion IS NULL OR arch_fecha_anulacion = '0000-00-00 00:00:00')
                        AND arch_id = ".$arch_id;

        $res = $mdb2->query($sql);

        //Datos de prueba
        $sem_id = 9;
        $emp_id = 1;
        $tipo_distribuidora_id = 3;
        $zona_id = 3;
        //$arch_lineas_procesadas = 0;
        $minimoMinutos = 3;
        $minimoHoras = 1;

        while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
            $sem_id = $do['arch_semestre'];
            $emp_id = $do['arch_emp_id'];
            $zona_id = $do['emp_zona_id'];
            $tipo_distribuidora_id = $do['emp_tdist_id'];
        }

        $res->free();

        echo_debug('Calculando multas para el semestre: '.$sem_id.'<br>');

        //Vector con penalizaciones
        $penaliza = array();

        //Me fijo la cantidad de usuarios en cortes por usuario
        echo_debug('Busco el codigo de suministro: '.$cod_sum.' en cortes por usuario <br>');
        $sql = "SELECT cortesusua_cli_id FROM cortes_por_usuario
                INNER JOIN clientes ON cli_id = cortesusua_cli_id
                WHERE cortesusua_arch_id = ".$arch_id."
                AND cli_cod_suministro = ".$cod_sum;

        $res = $mdb2->query($sql);

        $lista_clientes = array();
        $i = 0;
        while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
            set_time_limit(30);
            $lista_clientes[] = $do['cortesusua_cli_id'];
            $cliente_id = $do['cortesusua_cli_id'];
            $i++;
        }


        $cant_lotes_clientes = 0;
        echo_debug('Cortes encontrados: '.$i.' <br>');

        $lotes_clientes = array_chunk($lista_clientes,CANTCLIENTES);
        $cant_lotes_clientes = count($lotes_clientes);
        //echo_debug('Proceso en lotes de : '.CANTCLIENTES.' ');

        for($i= 0; $i < $cant_lotes_clientes; $i++){
            $multas_por_usuario_calculada = array();
            $j = 0;

            //Calculo de multas
            $penaliza = calcularEnergiaNoSuministrada($minimoMinutos,$minimoHoras,$sem_id,$emp_id,$tipo_distribuidora_id,$zona_id,$cliente_id,$arch_id,$lotes_clientes[$i],$mdb2);

            //Traigo el valor de las tarifas
            $sql = "SELECT * FROM costo_energia_no_suministrada";
            $res = $mdb2->query($sql);

            $costos_energia_no_suministrada = array();


            while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                $costos_energia_no_suministrada[$do['cens_tarifa_id']] = $do['cens_valor'];
            }

            $res->free();

            //Sumo las multas de ese usuario
            $multas_calculadas = array();

            foreach($penaliza as $key => $pen){
                //Busco el valor de la multa segun
                if($pen['energia_no_suministrada'] != 0){
                    $penaliza[$key]['multa_usuario'] = $pen['energia_no_suministrada'];
                    $penaliza[$key]['multa_usuario_formula'] = $pen['energia_no_suministrada'];
                }
                else{
                    $penaliza[$key]['multa_usuario'] = 0;
                    $penaliza[$key]['multa_usuario_formula'] = 0;
                }

                //$penaliza[$key]['energia_no_suministrada_total'] = $penaliza[$key]['interrupcion'] * ($penaliza[$key]['energia_facturada']/4380);

                $multas_calculadas[$pen['cli_id']]['tarifa_id'] = $penaliza[$key]['tarifa_id'];
                $multas_calculadas[$pen['cli_id']]['cli_id'] = $penaliza[$key]['cli_id'];
                //$multas_calculadas[$pen['cli_id']]['ct_id'] = $penaliza[$key]['ct_id'];
                $multas_calculadas[$pen['cli_id']]['arch_id'] = $arch_id;
                //$multas_calculadas[$pen['cli_id']]['arch_linea'] = $penaliza[$key]['arch_linea'];
                
                $multas_calculadas[$pen['cli_id']]['frecuencia'] = $penaliza[$key]['frecuencia'];

                if($_SESSION['duracion'][$pen['cli_id']] > 0)
                    $multas_calculadas[$pen['cli_id']]['duracion'] = 1;
                    
                $multas_calculadas[$pen['cli_id']]['numero_corte'] = $penaliza[$key]['numero_corte'];
                $multas_calculadas[$pen['cli_id']]['sem_id'] = $penaliza[$key]['sem_id'];
                $multas_calculadas[$pen['cli_id']]['energia_facturada'] = $penaliza[$key]['energia_facturada'];
                $multas_calculadas[$pen['cli_id']]['energia_no_suministrada'] += $penaliza[$key]['energia_no_suministrada'];
                $multas_calculadas[$pen['cli_id']]['multa_calculada'] += round($penaliza[$key]['multa_usuario'],REDONDEOFORM);
                $multas_calculadas[$pen['cli_id']]['multa_calculada_formula'][] = round($penaliza[$key]['multa_usuario_formula'],REDONDEOFORM);
                $multas_calculadas[$pen['cli_id']]['interrupcion_formula'][] = $penaliza[$key]['interrupcion_formula'];
                
                $multas_calculadas[$pen['cli_id']]['energia_no_suministrada_total'] += $penaliza[$key]['energia_no_suministrada_total'];

                if($penaliza[$key]['energia_no_suministrada_total_formula'] != null)                    
                    $multas_calculadas[$pen['cli_id']]['energia_no_suministrada_total_formula'][] = $penaliza[$key]['energia_no_suministrada_total_formula'];
            
                if($penaliza[$key]['energia_no_suministrada_formula'] != null)
                    $multas_calculadas[$pen['cli_id']]['energia_no_suministrada_formula'][] = $penaliza[$key]['energia_no_suministrada_formula'];                    
    
            }


            //var_dump($penaliza);
		
            unset($penaliza);
            $penaliza = array();
            $multa_usuario_formula = null;
            $interrupcion_formula = null;

            //Recorro penaliza para acumular las multas            
            foreach($multas_calculadas as $key => $pen){
                //$total_energ_no_sum = "(".array_sum($pen['multa_calculada_formula']).")";
                $multa_usuario_formula = '('.implode('+',$pen['multa_calculada_formula']).") * ".$costos_energia_no_suministrada[$pen['tarifa_id']];
                //$multa_usuario_formula = '('.round($total_energ_no_sum,4).") * ".$costos_energia_no_suministrada[$pen['tarifa_id']];
                $interrupcion_formula = '('.implode(')+(',$pen['interrupcion_formula']).')';

                if($pen['energia_no_suministrada_total_formula'] != '')
                    $energia_no_suministrada_total_formula = '('.implode('+',$pen['energia_no_suministrada_total_formula']).') * '.$pen['energia_facturada'].'/4380';
                else
                    $energia_no_suministrada_total_formula = '';
                    
                if($pen['energia_no_suministrada_formula'] != '')
                    $energia_no_suministrada_formula = '('.implode('+',$pen['energia_no_suministrada_formula']).') * '.$pen['energia_facturada'].'/4380';
                else
                    $energia_no_suministrada_formula = '';
                    
                
                //Para el insert en la base
                $multas_por_usuario_calculada[] = "<td>".$sem_id."</td><td>".$pen['cli_id']."</td><td>".round($pen['energia_facturada'],REDONDEOENFAC)."</td><td>".round($pen['energia_no_suministrada'],REDONDEOENS)."</td><td>".str_replace('.',',',$energia_no_suministrada_formula)."</td><td>".round($pen['multa_calculada'] * $costos_energia_no_suministrada[$pen['tarifa_id']],REDONDEOMULTA)."</td><td>".str_replace('.',',',$multa_usuario_formula)."</td><td>".$arch_id."</td><td>".$pen['numero_corte']."</td><td>".intval($pen['frecuencia'])."</td><td>".intval($pen['duracion'])."</td><td>".str_replace('.',',',$interrupcion_formula)."</td><td>".round($pen['energia_no_suministrada_total'],REDONDEOENS)."</td><td>".str_replace('.',',',$energia_no_suministrada_total_formula)."</td><td>";
                $j++;
                unset($_SESSION['frecuencia'][$pen['cli_id']]);
                unset($_SESSION['duracion'][$$pen['cli_id']]);
            }
            unset($multas_calculadas);
            echo "<style>td {text-align:center}</style>";
            echo "<table border='1' cellspacing='0' cellpadding='0'>";
            echo "<tr>";
            echo "<th>multasusuacalc_sem_id</th>";
            echo "<th>multasusuacalc_cli_id</th>";
            echo "<th>multasusuacalc_enerfacturada</th>";
            echo "<th>multasusuacalc_enernosum</th>";
            echo "<th>multasusuacalc_enernosum_formula</th>";
            echo "<th>multasusuacalc_multa</th>";
            echo "<th>multasusuacalc_multa_formula</th>";
            echo "<th>multasusuacalc_arch_id</th>";
            echo "<th>multasusuacalc_numero_corte</th>";
            echo "<th>multasusuacalc_frecuencia</th>";
            echo "<th>multasusuacalc_duracion</th>";
            echo "<th>multasusuacalc_interrup_formula</th>";
            echo "<th>multasusuacalc_enernosum_total</th>";
            echo "<th>multasusuacalc_enernosum_total_formula</th>";
            echo "</tr>";
            echo "<tr>";
                    foreach($multas_por_usuario_calculada as $lot){
                        echo $lot;
                    }
            echo "</tr>";
            echo "</table>";
            
//            foreach($lotes as $lot){
//                set_time_limit(30);
//                try{
//                    $res = $mdb2->query("BEGIN");
//
//                    $sql = "INSERT INTO multas_por_usuario_calculada (
//                                        multasusuacalc_sem_id,
//                                        multasusuacalc_cli_id,
//                                        multasusuacalc_enerfacturada,
//                                        multasusuacalc_enernosum,
//                                        multasusuacalc_enernosum_formula,
//                                        multasusuacalc_multa,
//                                        multasusuacalc_multa_formula,
//                                        multasusuacalc_arch_id,
//                                        multasusuacalc_numero_corte,
//                                        multasusuacalc_frecuencia,
//                                        multasusuacalc_duracion,
//                                        multasusuacalc_interrup_formula) VALUES ".implode(',',$lot);
//
//                    $res = $mdb2->query($sql);
//                    $res = $mdb2->query("COMMIT");
//                    echo_debug('Inserto en multas por usuario real '.$j.' registros en un commit de '.COMMITSQL.' ');
//                }
//                catch(Exception $e){
//                    $res = $mdb2->query("ROLLBACK");
//                    die($e->getMessage());
//                }
//            }

            unset($multas_por_usuario_calculada);

        }
        echo_debug('Finalizado el calculo de multa para este usuario<br>');
    }
    
    //accionesPostCalculoMultas($arch_id,$mdb2);
}
