<?php
    ini_set("memory_limit","2048M");
	include('MDB2.php');
	require_once(INC_PATH.'/funciones/calcularEnergiaNoSuministradaEstimada.php');

    function calcularMultaEstimada($arch_id = 0)
    {
//        include('MDB2.php');
//        require_once(INC_PATH.'/funciones/calcularEnergiaNoSuministradaEstimada.php');

        //define('CANTCLIENTES',50000);
        
        //DB_DataObject::debugLevel(5);
        $config = PEAR::getStaticProperty("DB_DataObject",'options');
        $mdb2 =& MDB2::connect($config['database']);

        if (PEAR::isError($mdb2)) {
            die($mdb2->getMessage());
        }

        $row = null;
        $penaliza = array();

        //Datos para testeo
        $minimoMinutos = 3;
        $minimoHoras = 1;
        $sem_id = 9;
        $emp_id = 1;
        $tipo_distribuidora_id = 2;
        $zona_id = 2;
        $ct_id = 14590;

        $sql = "SELECT ai.arch_id, ai.arch_semestre, ai.arch_emp_id, e.emp_tdist_id, e.emp_zona_id FROM archivos_importacion ai
                INNER JOIN empresas e ON e.emp_id = ai.arch_emp_id
                WHERE arch_fecha_anulacion IS NULL
                AND arch_id = ".$arch_id;
        //$do->query($sql);

        $res = $mdb2->query($sql);

//        $arch_lineas_procesadas = 0;

        if($res->numRows() > 0){
            //while($do->fetch()){
            while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                $sem_id = $do['arch_semestre'];
                $emp_id = $do['arch_emp_id'];
                $zona_id = $do['emp_zona_id'];
                $tipo_distribuidora_id = $do['emp_tdist_id'];
//                $arch_lineas_procesadas = $do['arch_lineas_procesadas'];

            }

            //Me fijo la cantidad de ct
//            $sql = "SELECT COUNT(cortesxct_ct_id) AS cantidad FROM cortes_por_ct
//                    WHERE cortesxct_arch_id = ".$arch_id;

            $sql = "SELECT cortesxct_ct_id FROM cortes_por_ct
                    WHERE cortesxct_arch_id = ".$arch_id."
                    GROUP BY cortesxct_ct_id";
            $res = $mdb2->query($sql);

            //Recorro los cortes por ct para armar las multas
            $lista_ct = array();
            while($do_ct = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                set_time_limit(30);
                $lista_ct[] = $do_ct['cortesxct_ct_id'];

            }

//            var_dump($lista_ct);
//            exit;


//            $row = $res->fetchRow(MDB2_FETCHMODE_OBJECT);
//
//            $arch_lineas_procesadas = $row->cantidad;
//
//            if($arch_lineas_procesadas > 0 && $arch_lineas_procesadas < 1000)
//                $arch_lineas_procesadas = $row->cantidad + 1000;
//
//            $res->free();
//
//            $ini = 0;
//            $fin = 1000;

//            if($arch_lineas_procesadas > 0){
//                for($i= 1000; $i < $arch_lineas_procesadas; ($i = $i+1000)){
//                    $fin = $i;

                    //Busco los cortes por ct segun el archivo id
//                    $sql = "SELECT cortesxct_sem_id,emp_id,tdist_id,zona_id,cortesxct_ct_id
//                            FROM cortes_por_ct
//                            INNER JOIN semestres ON (semestres.sem_id=cortes_por_ct.cortesxct_sem_id)
//                            INNER JOIN tipo_distribuidora ON (tipo_distribuidora.tdist_id=semestres.sem_tdist_id)
//                            INNER JOIN empresas ON (empresas.emp_tdist_id=tipo_distribuidora.tdist_id)
//                            INNER JOIN zona ON (zona.zona_id=empresas.emp_zona_id)
//                            WHERE cortesxct_arch_id = ".$arch_id."
//                            LIMIT ".$ini.", ".$fin;
//
//
//                    $res = $mdb2->query($sql);
//
//                    $ini = $fin;

                    //Recorro los cortes por ct para armar las multas
//                    $lista_ct = array();
//                    while($do_ct = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
//                        set_time_limit(10);
//                        $lista_ct[$do_ct['cortesxct_ct_id']] = $do_ct['cortesxct_ct_id'];
//
//                    }

//                    var_dump($lista_ct);
//                    exit;

                    $multas_por_usuario_estimada = array();

                    foreach($lista_ct as $ct_id){

                        $penaliza = calcularEnergiaNoSuministradaEstimada($minimoMinutos,$minimoHoras,$sem_id,$emp_id,$tipo_distribuidora_id,$zona_id,$ct_id,$arch_id,$mdb2);

                        if(count($penaliza) > 0){

                            //Traigo el valor de las tarifas
                            $sql = "SELECT cens_valor, cens_tarifa_id FROM costo_energia_no_suministrada";
                            //$do->query($sql);
                            $res2 = $mdb2->query($sql);


                            $costos_energia_no_suministrada = array();

                            //Busco los cortes de energia no suministrada
                            while($do = $res2->fetchRow(MDB2_FETCHMODE_ASSOC)){
                                $costos_energia_no_suministrada[$do['cens_tarifa_id']] = $do['cens_valor'];
                            }

                            //Sumo las multas de ese usuario
                            $multa_total_calculada = 0;
                            $frecuencia = 0;
                            $duracion = 0;

                            foreach($penaliza as $key => $pen){
                                //Busco el valor de la multa segun
                                if(isset($costos_energia_no_suministrada[$pen['tarifa_id']]))
                                    $penaliza[$key]['costo_energia_no_suministrada'] = $costos_energia_no_suministrada[$pen['tarifa_id']];
                                else
                                    $penaliza[$key]['costo_energia_no_suministrada'] = 0;

                                $penaliza[$key]['multa_usuario'] = $pen['energia_no_suministrada'] * $costos_energia_no_suministrada[$pen['tarifa_id']];
                                //$penaliza[$key]['multa_usuario_formula'] = $pen['energia_no_suministrada']." * ".$costos_energia_no_suministrada[$pen['tarifa_id']];
                                $penaliza[$key]['multa_usuario_formula'] = '';
                                //$penaliza[$key]['multa_usuario'] = number_format(($pen['energia_no_suministrada'] * $costos_energia_no_suministrada[$pen['tarifa_id']]),2);
                                $multa_total_calculada+= $penaliza[$key]['multa_usuario'];

                                $frecuencia = $penaliza[$key]['frecuencia'];
                                $duracion = $penaliza[$key]['duracion'];
                            }
                           
                            
                            foreach($penaliza as $key => $pen){
                                //Guardo la info en multas de usuario
                                //$do = DB_DataObject::factory('multas_por_usuario_estimada');
                                //$row = $do->chequearMulta($pen['multa_usuario'], $pen['costo_energia_no_suministrada'], $pen['energia_no_suministrada'], $pen['cli_id'], $pen['sem_id']);
                                $sql = "SELECT COUNT(*) AS cantidad_multas, multasusuaest_id
                                        FROM multas_por_usuario_estimada mpue
                                        WHERE mpue.multasusuaest_multa = ".$pen['multa_usuario']."
                                        AND mpue.multasusuaest_enernosum_pen = ".$pen['costo_energia_no_suministrada']."
                                        AND mpue.multasusuaest_enernosum_tot = ".$pen['energia_no_suministrada']."
                                        AND mpue.multasusuaest_cli_id = ".$pen['cli_id']."
                                        AND mpue.multasusuaest_sem_id = ".$pen['sem_id'];

                                $row = $res->fetchRow(MDB2_FETCHMODE_OBJECT);

                                if($row->cantidad_multas > 0){
                                    $sql = "UPDATE multas_por_usuario_estimada
                                    SET multasusuaest_multa = ".$pen['multa_usuario']."
                                    WHERE multasusuaest_id = ".$row->multasusuaest_id;
                                    $res2 = $mdb2->query($sql);
                                    //$do->query($sql);

                                    //echo "SE ACTUALIZO LA TABLA MULTAS USUARIOS ESTIMADA CON EL VALOR TOTAL DE LA MULTA (".$pen['multa_usuario'].") DE ACUERDO AL CT SOLICITADO (".$ct_id.")<br />";

                                }
                                else{

                                    $multas_por_usuario_estimada[] = "(".$pen['multa_usuario'].",".floatval($pen['costo_energia_no_suministrada']).",".floatval($pen['energia_no_suministrada']).",".$pen['cli_id'].",".$pen['ct_id'].",".$pen['sem_id'].")";
        
                                }
                                //echo "SE CARGO LA TABLA MULTAS USUARIOS ESTIMADA CON EL VALOR TOTAL DE LA MULTA (".$pen['multa_usuario'].") DE ACUERDO AL CT SOLICITADO (".$ct_id.")<br />";
                            }
                        }

                $lotes = array_chunk($multas_por_usuario_estimada,3000);

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
                                    multasusuaest_sem_id) VALUES ".implode(',',$lot);

                        $res = $mdb2->query($sql);

                    }

                    $res = $mdb2->query("COMMIT");

                }
                catch(Exception $e){
                    $res = $mdb2->query("ROLLBACK");
                    die($e->getMessage());
                }

                    }




                //}
//            }
//            else{
//                die("No hay lineas cargadas para ese archivo.");
//            }
//        }
//        else{
//            die("No existe ese id de archivo.");
        }
    }

    echo "LLEGO OK ESTIMADA !!!";
