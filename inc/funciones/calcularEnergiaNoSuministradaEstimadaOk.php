<?php
require_once('calcularInterrupcion.php');
require_once('calcularEnergiaFacturada.php');
require_once('penalizar.php');
/**
 * Devuelve la energía no suministrada a un cliente usuario o ct en el semenstre dado
 * @param <int> $minimoMinutos
 * @param <int> $minimoHoras
 * @param <int> $sem_id
 * @param <int> $emp_id
 * @param <int> $tipo_distribuidora_id
 * @param <int> $zona_id
 * @param <int> $cliente_id
 * @return <array> Energia no suministrada
 */
function calcularEnergiaNoSuministradaEstimada( $minimoMinutos = 3,
    $minimoHoras = 1,
    $sem_id = 0,
    $emp_id = 0,
    $tipo_distribuidora_id = 0,
    $zona_id = 0,
    $ct_id = 0,
    $arch_id = 0,
    $mdb2 = null
)
{

    $row = null;
    $penaliza = array();

    //Tengo que buscar el semestre actual y sino traer el anterior
    //El arch_id de cadena no es el mismo de cortes por usuario estimado
    $sql = "SELECT sem_id
            FROM semestres
            INNER JOIN cadena_electrica ON (cadena_electrica.cadelect_sem_id=semestres.sem_id)
            WHERE ( semestres.sem_tdist_id = ".$tipo_distribuidora_id." )
            GROUP BY sem_id
            ORDER BY sem_nombre DESC
            LIMIT 0,1";
    
    //$do_sem->query($sql);
    $res_sem = $mdb2->query($sql);
     //DB_DataObject::debugLevel(5);

    $semestre_a_calcular = 0;

    while($do_sem = $res_sem->fetchRow(MDB2_FETCHMODE_OBJECT)){
        $semestre_a_calcular = $do_sem->sem_id;
    }

    if($semestre_a_calcular > 0){
        //Necesito saber cuales son los cortes de usuario
        $cortes = array();
        //DB_DataObject::debugLevel(5);
        $_SESSION['frecuencia'] = 0;

        //$do = DB_DataObject::factory('cortes_por_ct');
        $sql = "SELECT cli_emp_id,cortesxct_ct_id, cortesxct_sem_id,cadelect_ct_id,cadelect_ct_id,cadelect_cli_id,cli_tarifa_id,
                       cortesxct_fecha_cierre,cortesxct_fecha_apertura,
                       cortesxct_op_cierre,cortesxct_op_apertura,cortesxct_causa,cli_id,
                       TIMESTAMPDIFF(HOUR, cortesxct_fecha_cierre, cortesxct_fecha_apertura) AS cant_horas,
                       TIMESTAMPDIFF(MINUTE, cortesxct_fecha_cierre, cortesxct_fecha_apertura) AS cant_minutos,
                       MINUTE(TIME(cortesxct_fecha_apertura)) AS minuto_apertura,
                       MINUTE(TIME(cortesxct_fecha_cierre)) AS minuto_cierre,
                       HOUR(TIME(cortesxct_fecha_apertura)) AS hora_apertura,
                       HOUR(TIME(cortesxct_fecha_cierre)) AS hora_cierre
                       FROM cortes_por_ct
                       INNER JOIN cadena_electrica ON (cadena_electrica.cadelect_ct_id=cortes_por_ct.cortesxct_ct_id)
                       INNER JOIN clientes ON (clientes.cli_id=cadena_electrica.cadelect_cli_id)
                       INNER JOIN empresas ON (empresas.emp_id = clientes.cli_emp_id)
                       WHERE ( TIMESTAMPDIFF(MINUTE, cortesxct_fecha_cierre, cortesxct_fecha_apertura) >= ".$minimoMinutos." )
                       AND ( cortes_por_ct.cortesxct_ct_id = ".$ct_id." )
                       AND ( empresas.emp_id =  ".$emp_id." )
                       AND ( cortes_por_ct.cortesxct_sem_id = ".$semestre_a_calcular." )
                       AND ( cortes_por_ct.cortesxct_arch_id = ".$arch_id.")";

        //$do->query($sql);
        $rescxct = $mdb2->query($sql);

        //if($do->fetch()){
            while($do = $rescxct->fetchRow(MDB2_FETCHMODE_OBJECT)){
                $cortes[$do->cli_id]['emp_id'] = $do->cli_emp_id;
                $cortes[$do->cli_id]['sem_id'] = $do->cortesxct_sem_id;
                $cortes[$do->cli_id]['ct_id'] = $do->cadelect_ct_id;
                $cortes[$do->cli_id]['cli_id'] = $do->cadelect_cli_id;
                $cortes[$do->cli_id]['tarifa_id'] = $do->cli_tarifa_id;
                $cortes[$do->cli_id]['cant_horas'] = $do->cant_horas;
                $cortes[$do->cli_id]['cant_minutos'] = $do->cant_minutos;
                $cortes[$do->cli_id]['fecha_cierre'] = $do->cortesxct_fecha_cierre;
                $cortes[$do->cli_id]['fecha_apertura'] = $do->cortesxct_fecha_apertura;
                $cortes[$do->cli_id]['hora_cierre'] = $do->hora_cierre;
                $cortes[$do->cli_id]['hora_apertura'] = $do->hora_apertura;
                $cortes[$do->cli_id]['minuto_cierre'] = $do->minuto_cierre;
                $cortes[$do->cli_id]['minuto_apertura'] = $do->minuto_apertura;
                $cortes[$do->cli_id]['op_cierre'] = $do->cortesxct_op_cierre;
                $cortes[$do->cli_id]['op_apertura'] = $do->cortesxct_op_apertura;
                $cortes[$do->cli_id]['causa'] = $do->cortesxct_causa;
            }

//            var_dump($cortes);
//            exit;

            //$do = DB_DataObject::factory('coeficientes_ki');
            $sql = "SELECT coefki_emp_id,coefki_tar_id,coefki_hora,coefki_emp_id,coefki_valor,tarifa_niveltension,limsemcort_valor,limsemcort_tipo_limite
                    FROM coeficientes_ki
                    INNER JOIN tarifa ON (tarifa.tarifa_id=coeficientes_ki.coefki_tar_id)
                    INNER JOIN limites_semestral_cortes ON (limites_semestral_cortes.limsemcort_niveltension=tarifa.tarifa_niveltension)
                    WHERE ( coeficientes_ki.coefki_emp_id = ".$emp_id." ) ";

            //$do->query($sql);
            $res = $mdb2->query($sql);

            $coeficientes = array();

            /**
             * Aca no esta trayendo bien los datos
             */

            //if(!$do->fetch()){
            if($res->numRows() == 0){
                    //DB_DataObject::debugLevel(5);
                    //$do = DB_DataObject::factory('coeficientes_ki');
                    $sql = "SELECT coefki_tar_id,coefki_emp_id,coefki_hora,coefki_emp_id,coefki_valor,tarifa_niveltension,limsemcort_valor,limsemcort_tipo_limite
                            FROM coeficientes_ki
                            INNER JOIN tarifa ON tarifa.tar_id = coeficientes_ki.coefki_tar_id
                            INNER JOIN limites_semestral_cortes ON limites_semestral_cortes.limsemcort_niveltension = tarifa.niveltension
                            INNER JOIN empresas ON empresas.emp_id ON coeficientes_ki.coefki.emp_id
                            WHERE empresas.emp_tdist_id = ".$tipo_distribuidora_id."
                            AND empresas.emp_zona_id = ".$zona_id;

                     //$do->query($sql);
                     $res = $mdb2->query($sql);
            }

            //Llenar la base con los cortes estimados.
            foreach($cortes as $c){
                $do_cor = DB_DataObject::factory('cortes_por_usuario_estimado');
                $cantidad = $do_cor->chequearCorte($c['fecha_cierre'],$c['fecha_apertura'],$c['hora_cierre'],$c['hora_apertura'],$c['cli_id'],$c['sem_id']);

                if($cantidad == 0){
                    //No esta asi que lo inserto
                    $sql = "INSERT INTO cortes_por_usuario_estimado (
                            cortesusuaest_sem_id ,
                            cortesusuaest_cli_id ,
                            cortesusuaest_op_cierre ,
                            cortesusuaest_op_apertura ,
                            cortesusuaest_fecha_cierre ,
                            cortesusuaest_fecha_apertura ,
                            cortesusuaest_causa ) VALUES (
                            ".$c['sem_id']." ,
                            ".$c['cli_id']." ,
                            '".$c['op_cierre']."' ,
                            '".$c['op_apertura']."' ,
                            '".$c['fecha_cierre']." ".$c['hora_cierre']."',
                            '".$c['fecha_apertura']." ".$c['hora_apertura']."',
                            '".$c['causa']."')";
                      //$do_cor->query($sql);
                      $res = $mdb2->query($sql);

                }
            }

            //while($do->fetch()){
            while($do = $res->fetchRow(MDB2_FETCHMODE_OBJECT)){
                $coeficientes[$do->coefki_emp_id][$do->coefki_tar_id][$do->coefki_hora]['emp_id'] = $do->coefki_emp_id;
                $coeficientes[$do->coefki_emp_id][$do->coefki_tar_id][$do->coefki_hora]['tarifa_id'] = $do->coefki_tar_id;
                $coeficientes[$do->coefki_emp_id][$do->coefki_tar_id][$do->coefki_hora]['hora'] = $do->coefki_hora;
                $coeficientes[$do->coefki_emp_id][$do->coefki_tar_id][$do->coefki_hora]['valor'] = $do->coefki_valor;
                $coeficientes[$do->coefki_emp_id][$do->coefki_tar_id][$do->coefki_hora]['nivel_tension'] = $do->tarifa_niveltension;
                $coeficientes[$do->coefki_emp_id][$do->coefki_tar_id][$do->coefki_hora][$do->limsemcort_tipo_limite] = $do->limsemcort_valor;
            }

            //Si coeficientes no trae nada tengo un error
            $error_coef = null;
            if(count($coeficientes) == 0){
                $error_coef = "err-coef|";
            }


            $procesa = array();
            $procesa['frecuencia'] = 0;
            $procesa['duracion'] = 0;

            //Busco a ver a quien le corresponde pagar

            foreach($cortes as $k => $c){
                $_SESSION['frecuencia']++;
                //Duracion
                if($c['cant_horas'] == 0)
                    $c['cant_horas'] = 1;

                 if($coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['D'] != null && (intval($c['cant_horas']) >= intval($coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['D']))){
                    $penaliza[$k]['tipo'] = 'D';
                    $penaliza[$k]['duracion'] = $coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['D'];
                    $procesa['duracion'] = 1;
                }
                else{
                    $penaliza[$k]['tipo'] = 'F';
                    if($_SESSION['frecuencia'] > $coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['F']){
                        $procesa['frecuencia'] = 1;
                    }

                }
                $penaliza[$k]['emp_id'] = $c['emp_id'];
                $penaliza[$k]['tarifa_id'] = $c['tarifa_id'];
                $penaliza[$k]['ct_id'] = $c['ct_id'];
                $penaliza[$k]['cli_id'] = $c['cli_id'];
                $penaliza[$k]['sem_id'] = $c['sem_id'];
                $penaliza[$k]['cant_horas'] = $c['cant_horas'];
                $penaliza[$k]['cant_minutos'] = $c['cant_minutos'];
                $penaliza[$k]['fecha_cierre'] = $c['fecha_cierre'];
                $penaliza[$k]['fecha_apertura'] = $c['fecha_apertura'];
                //$penaliza[$k]['valor'] = $coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['valor'];
                $interrupciones = calcularInterrupcion($penaliza[$k]['tipo'], $procesa, $coeficientes,$c['hora_cierre'],$c['hora_apertura'],$c['emp_id'],$c['tarifa_id'],$c['cant_horas'],$c['cant_minutos'],$c['minuto_cierre'],$c['minuto_apertura']);

                //$penaliza[$k]['interrupcion'] = calcularInterrupcion($penaliza[$k]['tipo'], $procesa, $coeficientes,$c['hora_cierre'],$c['hora_apertura'],$c['emp_id'],$c['tarifa_id'],$c['cant_horas'],$c['cant_minutos'],$c['minuto_cierre'],$c['minuto_apertura']);
                $penaliza[$k]['energia_facturada'] = calcularEnergiaFacturada($c['cli_id'],$c['sem_id'], $mdb2);
                //$penaliza[$k]['energia_no_suministrada'] = ($penaliza[$k]['interrupcion']* $penaliza[$k]['energia_facturada'])/4380;
                $penaliza[$k]['energia_no_suministrada'] = penalizar($interrupciones, $penaliza[$k]['energia_facturada'], 4380); ///4380
                //$penaliza[$k]['energia_no_suministrada_formula'] = $error_coef.penalizarToString($interrupciones, $penaliza[$k]['energia_facturada'], 4380); ///4380
                $penaliza[$k]['energia_no_suministrada_formula'] = '';
            }
        //}

        return $penaliza;
    }
    else{
        return array();
    }
}