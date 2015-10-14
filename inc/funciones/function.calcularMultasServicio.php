<?php
ini_set("memory_limit","3072M");
include_once('MDB2.php');
require_once(INC_PATH.'/funciones/calcularEnergiaNoSuministrada.php');
require_once(INC_PATH.'/funciones/function.accionesPostCalculoMultas.php');
function calcularMultas($arch_id = 0, $clientes_a_consultar = array(), $fuerza_mayor = 1)
{
    define('CANTCLIENTES',5000);
    define('COMMITSQL',10000);
    define('PROCESAR',1);
    define('PORCONSOLA',0);
    define('REDONDEOENS',2);
    define('REDONDEOENFAC',8);
    define('REDONDEOMULTA',2);
    define('REDONDEOFORM',8);
    define('REDONDEOPEN',8);
    define('REDONDEOINT',8);
    define('LIMIT',null);

    $config = PEAR::getStaticProperty("DB_DataObject",'options');
    $mdb2 =& MDB2::connect($config['database']);

    if (PEAR::isError($mdb2)) {
        die($mdb2->getMessage());
    }

    if(PROCESAR){

        unset($_SESSION['frecuencia']);
		unset($_SESSION['duracion']);
		echo_debug("Muestro con un redondeo de ".REDONDEOENS." decimales la energia no suministrada.");
		echo_debug("Calculo la penalizacion (int*ki) para energia no suministrada  con un redondeo de ".REDONDEOPEN." decimales.");
		echo_debug("La muestra de las formulas de energia no suministrada es con ".REDONDEOPEN." decimales que es lo que se utiliza para calcular.");		
		echo_debug("Muestro con un redondeo de ".REDONDEOMULTA." decimales la multa calculada.");
		echo_debug("La muestra de las formulas de la multa es con ".REDONDEOFORM." decimales que es lo que se utiliza para calcular.");		
		echo_debug("Calculo con un redondeo a ".REDONDEOINT." decimales las interrupciones.");
		if(LIMIT != null)
                    echo_debug("Consulto ".LIMIT." registros.");


        echo_debug('Busco semestre, empresa, tipo de distribuidora y zona de archivos importacion');
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
        $cliente_id = null;
        $minimoMinutos = 3;
        $minimoHoras = 1;

        while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
            $sem_id = $do['arch_semestre'];
            $emp_id = $do['arch_emp_id'];
            $zona_id = $do['emp_zona_id'];
            $tipo_distribuidora_id = $do['emp_tdist_id'];
        }

        $res->free();

        echo_debug('Calculando multas para el semestre: '.$sem_id.'');

        //Vector con penalizaciones
        $penaliza = array();

        //Me fijo la cantidad de usuarios en cortes por usuario
        echo_debug('Busco los clientes de cortes por usuario agrupados por cliente ');
        $sql = "SELECT cortesusua_cli_id FROM cortes_por_usuario
                WHERE cortesusua_arch_id = ".$arch_id;

        if(count($clientes_a_consultar) > 0){
            $clientes = implode(",",$clientes_a_consultar);
            $sql .= " AND cortesusua_cli_id IN (".$clientes.")";
        }

        $sql .= " GROUP BY cortesusua_cli_id";
        
        $res = $mdb2->query($sql);

        $lista_clientes = array();
        $i = 0;
        while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
            set_time_limit(30);
            $lista_clientes[] = $do['cortesusua_cli_id'];
            $i++;
        }


        $cant_lotes_clientes = 0;
        echo_debug('Clientes encontrados con cortes: '.$i.' ');

        $lotes_clientes = array_chunk($lista_clientes,CANTCLIENTES);
        $cant_lotes_clientes = count($lotes_clientes);
        echo_debug('Proceso en lotes de : '.CANTCLIENTES.' ');

        for($i= 0; $i < $cant_lotes_clientes; $i++){
            $multas_por_usuario_calculada = array();
            $j = 0;

            //Calculo de multas
            $penaliza = calcularEnergiaNoSuministrada($minimoMinutos,$minimoHoras,$sem_id,$emp_id,$tipo_distribuidora_id,$zona_id,$cliente_id,$arch_id,$lotes_clientes[$i],$fuerza_mayor,LIMIT,$mdb2);

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
                
                $multas_calculadas[$pen['cli_id']]['frecuencia'] = $penaliza[$key]['frecuencia'];;

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

//            var_dump($penaliza);
//            exit;

            unset($penaliza);
            $penaliza = array();
            $multa_usuario_formula = null;
            $interrupcion_formula = null;

            //Recorro penaliza para acumular las multas
            //$clientes_a_consultar = array();
            foreach($multas_calculadas as $key => $pen){
                //$total_energ_no_sum = array_sum($pen['multa_calculada_formula']);
                $multa_usuario_formula = '('.implode('+',$pen['multa_calculada_formula']).") * ".$costos_energia_no_suministrada[$pen['tarifa_id']];
                //$multa_usuario_formula = '('.round($total_energ_no_sum,4).") * ".$costos_energia_no_suministrada[$pen['tarifa_id']];
                $interrupcion_formula = '('.implode(')+(',$pen['interrupcion_formula']).')';

                if($pen['energia_no_suministrada_total_formula'] != '')
                    $energia_no_suministrada_total_formula = '('.implode('+',$pen['energia_no_suministrada_total_formula']).') * '.round($pen['energia_facturada']).'/4380';
                else
                    $energia_no_suministrada_total_formula = '';
                    
                if($pen['energia_no_suministrada_formula'] != '')
                    $energia_no_suministrada_formula = '('.implode('+',$pen['energia_no_suministrada_formula']).') * '.round($pen['energia_facturada']).'/4380';
                else
                    $energia_no_suministrada_formula = '';

                //Verifico que no este cargada la multa para ese archivo_id si esta actualizo
                $sql = "SELECT COUNT(multasusuacalc_id) FROM multas_por_usuario_calculada
                        WHERE multasusuacalc_cli_id = ".$pen['cli_id']."
                        AND multasusuacalc_arch_id = ".$arch_id;

                $res = $mdb2->query($sql);

                if (PEAR::isError($res)) {
                    echo $sql;
                    die($res->getMessage());
                }

                if($res->numRows() == 0){
                    //Para el insert en la base
                    $multas_por_usuario_calculada[] = "(".$sem_id.",".$pen['cli_id'].",".round($pen['energia_facturada'],REDONDEOENFAC).",".round($pen['energia_no_suministrada'],REDONDEOENS).",'".str_replace('.',',',$energia_no_suministrada_formula)."',".round($pen['multa_calculada'] * $costos_energia_no_suministrada[$pen['tarifa_id']],REDONDEOMULTA).",'".str_replace('.',',',$multa_usuario_formula)."',".$arch_id.",".$pen['numero_corte'].",".intval($pen['frecuencia']).",".intval($pen['duracion']).",'".str_replace('.',',',$interrupcion_formula)."',".round($pen['energia_no_suministrada_total'],REDONDEOENS).",'".str_replace('.',',',$energia_no_suministrada_total_formula)."')";
                    $j++;

                }
                else{
                    //Actualizo
                    try{
                        echo_debug('Actualizo al cliente '.$pen['cli_id'].' para el arch_id '.$arch_id.' ');
                        $res = $mdb2->query("BEGIN");

                        $sql = "UPDATE multas_por_usuario_calculada SET
                                multasusuacalc_enerfacturada = ".round($pen['energia_facturada'],REDONDEOENFAC).",
                                multasusuacalc_enernosum = ".round($pen['energia_no_suministrada'],REDONDEOENS).",
                                multasusuacalc_enernosum_formula = '".str_replace('.',',',$energia_no_suministrada_formula)."',
                                multasusuacalc_multa = ".round($pen['multa_calculada'] * $costos_energia_no_suministrada[$pen['tarifa_id']],REDONDEOMULTA).",
                                multasusuacalc_multa_formula = '".str_replace('.',',',$multa_usuario_formula)."',
                                multasusuacalc_numero_corte = ".$pen['numero_corte'].",
                                multasusuacalc_frecuencia = ".intval($pen['frecuencia']).",
                                multasusuacalc_duracion = ".intval($pen['duracion']).",
                                multasusuacalc_interrup_formula = '".str_replace('.',',',$interrupcion_formula)."',
                                multasusuacalc_enernosum_total = ".round($pen['energia_no_suministrada_total'],REDONDEOENS).",
                                multasusuacalc_enernosum_total_formula = '".str_replace('.',',',$energia_no_suministrada_total_formula)."'
                                WHERE multasusuacalc_cli_id = ".$pen['cli_id']."
                                AND multasusuacalc_arch_id = ".$arch_id;

                        $res = $mdb2->query($sql);

                        if (PEAR::isError($res)) {
                            echo $sql;
                            die($res->getMessage());
                        }

                        $sql = "UPDATE errores_proc_multas SET 
                                errores_proc_recalculado = 1,
                                errores_fecha_recalculado = NOW()
                                WHERE err_proc_mult_cli_id = ".$pen['cli_id']."
                                AND archivos_importacion_arch_id = ".$arch_id;
                        
                        $res = $mdb2->query($sql);
                        $res = $mdb2->query("COMMIT");

                        if (PEAR::isError($res)) {
                            echo $sql;
                            die($res->getMessage());
                        }
                    }
                    catch(Exception $e){
                        $res = $mdb2->query("ROLLBACK");
                        die($e->getMessage());
                    }
                }

                unset($_SESSION['frecuencia'][$pen['cli_id']]);
                unset($_SESSION['duracion'][$$pen['cli_id']]);
            }
            unset($multas_calculadas);
            echo_debug('Comienzo a insertar un lote de '.CANTCLIENTES.' en un sql commit de '.COMMITSQL.' ');
            $lotes = array_chunk($multas_por_usuario_calculada,COMMITSQL);
            foreach($lotes as $lot){
                set_time_limit(30);
                try{
                    $res = $mdb2->query("BEGIN");
                    
                    $sql = "INSERT INTO multas_por_usuario_calculada (
                                        multasusuacalc_sem_id,
                                        multasusuacalc_cli_id,
                                        multasusuacalc_enerfacturada,
                                        multasusuacalc_enernosum,
                                        multasusuacalc_enernosum_formula,
                                        multasusuacalc_multa,
                                        multasusuacalc_multa_formula,
                                        multasusuacalc_arch_id,
                                        multasusuacalc_numero_corte,
                                        multasusuacalc_frecuencia,
                                        multasusuacalc_duracion,
                                        multasusuacalc_interrup_formula,
                                        multasusuacalc_enernosum_total,
                                        multasusuacalc_enernosum_total_formula) VALUES ".implode(',',$lot);

                    $res = $mdb2->query($sql);
                    $res = $mdb2->query("COMMIT");

                    if (PEAR::isError($res)) {
			echo $sql;
                        die($res->getMessage());
                    }
                }
                catch(Exception $e){
                    $res = $mdb2->query("ROLLBACK");
                    die($e->getMessage());
                }
            }
            if($j == 0)
                echo_debug('Nada para insertar');
            else
                echo_debug('Inserto en multas por usuario real '.$j.' registros en un commit de '.COMMITSQL.' ');
                
            unset($multas_por_usuario_calculada);

        }
        echo_debug('Finalizada la inserción de multas por usuario reales');
    }
    
    //accionesPostCalculoMultas($arch_id,$mdb2);
}
