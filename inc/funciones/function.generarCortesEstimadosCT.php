<?php
require_once(INC_PATH.'/funciones/function.insertarRegistros.php');
require_once(INC_PATH.'/funciones/function.actualizarRegistros.php');
function generarCortesEstimadosCT($arch_id = 0,$cadelect_sem = 0,$cts = null,$mdb2 = null) {

    echo_debug('Inicio de la generacion de usuarios estimados');

//    $config = PEAR::getStaticProperty("DB_DataObject",'options');
//    $mdb2 =& MDB2::connect($config['database']);
//
//    if (PEAR::isError($mdb2)) {
//        die($mdb2->getMessage());
//    }
    echo_debug('Obteniendo datos de importación');

    $sql_mes = 'SELECT arch_emp_id
                FROM archivos_importacion
                WHERE arch_id = '.$arch_id.';';
    $res_mes = $mdb2->query($sql_mes);

    if (PEAR::isError($res_mes)) {
        echo $sql_mes;
        die($res_mes->getMessage());
    }


    $mes = $res_mes->fetchRow(MDB2_FETCHMODE_ASSOC);
    if ($mes) {
        $emp = $mes['arch_emp_id'];
    }

    //$do = DB_DataObject::factory('archivos_importacion');
    echo_debug('Leyendo CT afectados');
    if($cts != null)
        echo_debug('Lista: '.$cts);

    $sql_ct = 'SELECT cortesxct_ct_id
               FROM cortes_por_ct
               WHERE cortesxct_arch_id = '.$arch_id.'
               AND cortesxct_ct_id IS NOT NULL';

    if($cts != null)
        $sql_ct .= " AND cortesxct_ct_id IN (".$cts.")";

    $sql_ct .= ' GROUP BY cortesxct_ct_id;';
    $res_ct = $mdb2->query($sql_ct);

    if (PEAR::isError($res_ct)) {
        echo $sql_ct;
        die($res_ct->getMessage());
    }

    $ct = array();

    while ($est = $res_ct->fetchRow(MDB2_FETCHMODE_ASSOC)) {
        $ct[$est['cortesxct_ct_id']] = $est['cortesxct_ct_id'];
    }

    echo_debug('Obteniendo cadena electrica');

    if(count($ct) > 0){
        $sql_cad = 'SELECT cadelect_cli_id, cadelect_ct_id
                    FROM cadena_electrica
                    WHERE cadelect_sem_id = '.$cadelect_sem.'
                    AND cadelect_cli_id IS NOT NULL
                    AND cadelect_ct_id IN ('.implode(',',$ct).');';

        $res_cad = $mdb2->query($sql_cad);
        if (PEAR::isError($res_cad)) {
            echo $sql_cad;
            die($res_cad->getMessage());
        }


        $j = 0;

        $cad = array();
        while ($est = $res_cad->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            $cad[$est['cadelect_ct_id']][] = $est['cadelect_cli_id'];
            $j++;
        }

        unset($ct);
        echo_debug('Generando usuarios (Estimados: '.$j.')');

    }

        //Busca todos los cts
        $sql_ct = 'SELECT
                   cortesxct_ct_id,
                   cortesxct_op_apertura,
                   cortesxct_op_cierre,
                   cortesxct_fecha_apertura,
                   cortesxct_fecha_cierre,
                   cortesxct_causa,
                   cortesxct_arch_id,
		   cortesxct_duracion  FROM cortes_por_ct
                   WHERE cortesxct_arch_id = '.$arch_id.';';
        $res_ct = $mdb2->query($sql_ct);

        if (PEAR::isError($res_ct)) {
            echo $sql_ct;
            die($res_ct->getMessage());
        }


        //$ct = array();
        $i = 0;
        while ($est = $res_ct->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            $clientes = ($cad[$est['cortesxct_ct_id']]) ? $cad[$est['cortesxct_ct_id']]: array();

            if(count($clientes) > 0){
                $inserta = 0;
                $lista_clientes_a_verificar = implode(',',$clientes);

                //Tengo que verificar que no exista el corte para ese ct
                //Si existe debe actualizar
                $sql_cor = "SELECT cortesusuaest_id, cortesusuaest_cli_id FROM cortes_por_usuario_estimado
                            WHERE cortesusuaest_cli_id IN (".$lista_clientes_a_verificar.")
                            AND cortesusuaest_sem_id = ".$cadelect_sem."
                            AND cortesusuaest_arch_id = ".$arch_id;
                
                $res_cor = $mdb2->query($sql_cor);

                if (PEAR::isError($res_cor)) {
                    echo $sql_cor;
                    die($res_cor->getMessage());
                }

                $clientes_a_actualizar = array();
                while ($ver = $res_cor->fetchRow(MDB2_FETCHMODE_ASSOC)) {
                    $clientes_a_actualizar[$ver['cortesusuaest_cli_id']][] = $ver['cortesusuaest_id'];
                }

//                var_dump($clientes_a_actualizar);
//                exit;

                //Recorro esta lista para actualizar en insertar los que no esten
            foreach ($clientes as $cli_id) {

                        if(isset($clientes_a_actualizar[$cli_id])){
                            //actualizo
                            $a = 0;
                            foreach($clientes_a_actualizar[$cli_id] as $act){
                                $ct_act = "UPDATE cortes_por_usuario_estimado SET
                                             cortesusuaest_op_cierre = '".$est['cortesxct_op_cierre']."',
                                             cortesusuaest_op_apertura = '".$est['cortesxct_op_apertura']."',
                                             cortesusuaest_fecha_apertura = '".$est['cortesxct_fecha_apertura']."',
                                             cortesusuaest_fecha_cierre = '".$est['cortesxct_fecha_cierre']."',
                                             cortesusuaest_causa = '".$est['cortesxct_causa']."',
                                             cortesusuaest_duracion = '".$est['cortesxct_duracion']."'
                                             WHERE cortesusuaest_id = ".$act."; ";
                                $res = $mdb2->query($ct_act);
                                if (PEAR::isError($res)) {
                                    echo $ct_act;
                                    die($res->getMessage());
                                }
                                $a++;
                            }                            
                        }
                        else{
                            //inserto
                            $ct[] = '(' .
                            $cadelect_sem . ',' .
                            $cli_id . ',' .
                            $est['cortesxct_ct_id'] . ',' .
                            '"' . $est['cortesxct_op_cierre'] . '"' . ',' .
                            '"' . $est['cortesxct_op_apertura'] . '"' . ',' .
                            '"' . $est['cortesxct_fecha_apertura'] . '"' . ',' .
                            '"' . $est['cortesxct_fecha_cierre'] . '"' . ',' .
                            '"' . $est['cortesxct_causa'] . '"' . ',' .
                            $est['cortesxct_arch_id'] . ',' .
                            '"' . $est['cortesxct_duracion'] . '")
                                ';
                    if (count($ct) == 100000) {
                        $i += count($ct);
                        echo_debug('Insertando 100000 registros en la BD');
                        $query = insertarRegistros($ct);
                        $res = $mdb2->query($query);

                        if (PEAR::isError($res)) {
                            echo $query;
                            die($res->getMessage());
                        }
                        echo_debug('Total insertados ' . $i);
                        $ct = array();
                    }
                        }

                    }

            }
            unset($cad[$est['cortesxct_ct_id']]);
            unset($clientes);
        }

    echo_debug('Actualización finalizada cantidad de usuarios estimados ' . $a);

    if (count($ct)) {
            $i += count($ct);
            $query = insertarRegistros($ct);
            $res = $mdb2->query($query);
            if (PEAR::isError($res)) {
                echo $query;
                die($res->getMessage());
            }
            $ct = array();
        }

    echo_debug('Generación finalizada cantidad de usuarios estimados '.$i);
    $mdb2->disconnect();
}

function generarCortesEstimadosUsuariosSinCT($arch_id = 0,$cadelect_sem = 0,$clientes = null,$mdb2 = null) {

    echo_debug('Inicio de la generacion de usuarios estimados sin CT');

//    $config = PEAR::getStaticProperty("DB_DataObject",'options');
//    $mdb2 =& MDB2::connect($config['database']);
//
//    if (PEAR::isError($mdb2)) {
//        die($mdb2->getMessage());
//    }
    echo_debug('Obteniendo datos de importación');

    $sql_mes = 'SELECT arch_emp_id
                FROM archivos_importacion
                WHERE arch_id = '.$arch_id.';';
    $res_mes = $mdb2->query($sql_mes);

    $mes = $res_mes->fetchRow(MDB2_FETCHMODE_ASSOC);
    if ($mes) {
        $emp = $mes['arch_emp_id'];
    }

    //$do = DB_DataObject::factory('archivos_importacion');
    echo_debug('Leyendo usuarios de CT afectados');
    if ($clientes != null)
        echo_debug('Lista de clientes sin CT: ' . $clientes);

    $sql_cli = 'SELECT cortesxct_cli_id
               FROM cortes_por_ct
               WHERE cortesxct_arch_id = '.$arch_id.'
               AND cortesxct_ct_id IS NULL';
   if ($clientes != null)
        $sql_cli .= " AND cortesxct_cli IN (" . $clientes . ")";

    $sql_cli .= ' GROUP BY cortesxct_cli_id;';
               
    $res_cli = $mdb2->query($sql_cli);

    if (PEAR::isError($res_cli)) {
        echo $sql_cli;
        die($res_cli->getMessage());
    }

    $cli = array();

    while ($est = $res_cli->fetchRow(MDB2_FETCHMODE_ASSOC)) {
        $cli[$est['cortesxct_cli_id']] = $est['cortesxct_cli_id'];
    }

    echo_debug('Obteniendo cadena electrica para esos usuarios sin CT');

    if(count($cli) > 0){
        $sql_cad = 'SELECT cadelect_cli_id
                    FROM cadena_electrica
                    WHERE cadelect_sem_id = '.$cadelect_sem.'
                    AND cadelect_ct_id IS NULL
                    AND cadelect_cli_id IN ('.implode(',',$cli).');';

        $res_cad = $mdb2->query($sql_cad);
        if (PEAR::isError($res_cad)) {
            die($res_cad->getMessage());
        }


        $j = 0;

        $cad = array();
        while ($est = $res_cad->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            $cad['sinCT'][] = $est['cadelect_cli_id'];
            $j++;
        }

        unset($cli);
        echo_debug('Generando usuarios sin CT (Estimados: '.$j.')');

    }

        $sql_cli = 'SELECT
                   cortesxct_cli_id,
                   cortesxct_op_apertura,
                   cortesxct_op_cierre,
                   cortesxct_fecha_apertura,
                   cortesxct_fecha_cierre,
                   cortesxct_causa,
                   cortesxct_arch_id,
		   cortesxct_duracion  FROM cortes_por_ct
                   WHERE cortesxct_arch_id = '.$arch_id.';';


        $res_cli = $mdb2->query($sql_cli);

        if (PEAR::isError($res_cli)) {

            die($res_cli->getMessage());
        }
        //$ct = array();
        $i = 0;
        while ($est = $res_cli->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            $clientes = ($cad['sinCT']) ? $cad['sinCT']: array();
            if(count($clientes) > 0){

                foreach ($clientes as $cli_id) {
                    $cli[] = '('.
                    $cadelect_sem.','.
                    $cli_id.',
                    NULL,'.
                    '"'.$est['cortesxct_op_cierre'].'"'.','.
                    '"'.$est['cortesxct_op_apertura'].'"'.','.
                    '"'.$est['cortesxct_fecha_apertura'].'"'.','.
                    '"'.$est['cortesxct_fecha_cierre'].'"'.','.
                    '"'.$est['cortesxct_causa'].'"'.','.
                    $est['cortesxct_arch_id'].','.
		    '"'.$est['cortesxct_duracion'].'")
                    ';
                    if (count($cli) == 100000) {
                        $i += count($cli);
                        echo_debug('Insertando 100000 registros en la BD para los usuarios sin CT');
                        $query = insertarRegistrosUsuariosSinCT($cli);
                        $res = $mdb2->query($query);

                        if (PEAR::isError($res)) {
                            die($res->getMessage());
                        }
                        echo_debug('Total insertados '.$i);
                        $ct = array();
                    }
                }
            }
            unset($cad['sinCT']);
            unset($clientes);
        }

        if (count($cli)) {
            $i += count($cli);
            $query = insertarRegistrosUsuariosSinCT($cli);
            $res = $mdb2->query($query);
            if (PEAR::isError($res)) {
                die($res->getMessage());
            }
            $cli = array();
        }

    echo_debug('Generación finalizada cantidad de usuarios estimados que no tienen CT '.$i);
    $mdb2->disconnect();
}

