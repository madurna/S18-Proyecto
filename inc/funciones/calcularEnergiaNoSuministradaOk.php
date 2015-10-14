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
function calcularEnergiaNoSuministrada( $minimoMinutos = 3,
    $minimoHoras = 1,
    $sem_id = 0,
    $emp_id = 0,
    $tipo_distribuidora_id = 0,
    $zona_id = 0,
    $cliente_id = 0,
    $arch_id = 0,
    $lotes_clientes = array(),
    $mdb2 = null
)
{

//    $config = PEAR::getStaticProperty("DB_DataObject",'options');
//    $mdb2 =& MDB2::connect($config['database']);

    //Necesito saber cuales son los cortes de usuario o CT
    $cortes = array();
    //DB_DataObject::debugLevel(5);
    $_SESSION['frecuencia'] = 0;

    //$do = DB_DataObject::factory('cortes_por_usuario');
//    $sql = "SELECT *,
//            TIMESTAMPDIFF(HOUR, cortesusua_fecha_cierre, cortesusua_fecha_apertura) AS cant_horas ,
//            TIMESTAMPDIFF(MINUTE, cortesusua_fecha_cierre, cortesusua_fecha_apertura) AS cant_minutos ,
//            MINUTE(TIME(cortesusua_fecha_apertura)) AS minuto_apertura ,
//            MINUTE(TIME(cortesusua_fecha_cierre)) AS minuto_cierre ,
//            HOUR(TIME(cortesusua_fecha_apertura)) AS hora_apertura ,
//            HOUR(TIME(cortesusua_fecha_cierre)) AS hora_cierre,
//            cortesusua_arch_linea
//            FROM cortes_por_usuario
//            INNER JOIN clientes ON (clientes.cli_id=cortes_por_usuario.cortesusua_cli_id)
//            INNER JOIN empresas ON (empresas.emp_id = clientes.cli_emp_id)
//            WHERE ( TIMESTAMPDIFF(MINUTE, cortesusua_fecha_cierre, cortesusua_fecha_apertura) >= ".$minimoMinutos." )
//            AND ( empresas.emp_id = ".$emp_id." )
//            AND ( cortes_por_usuario.cortesusua_sem_id = ".$sem_id." )
//            AND ( cortes_por_usuario.cortesusua_cli_id = ".$cliente_id." ) ";
    
    $sql = "SELECT cli_emp_id,cli_id,cortesusua_id,cortesusua_sem_id,cortesusua_ct_id,cli_tarifa_id,cortesusua_fecha_cierre,cortesusua_fecha_apertura,cortesusua_arch_linea,
            TIMESTAMPDIFF(HOUR, cortesusua_fecha_cierre, cortesusua_fecha_apertura) AS cant_horas ,
            TIMESTAMPDIFF(MINUTE, cortesusua_fecha_cierre, cortesusua_fecha_apertura) AS cant_minutos ,
            MINUTE(TIME(cortesusua_fecha_apertura)) AS minuto_apertura ,
            MINUTE(TIME(cortesusua_fecha_cierre)) AS minuto_cierre ,
            HOUR(TIME(cortesusua_fecha_apertura)) AS hora_apertura ,
            HOUR(TIME(cortesusua_fecha_cierre)) AS hora_cierre,
            cortesusua_arch_linea
            FROM cortes_por_usuario
            INNER JOIN clientes ON (clientes.cli_id=cortes_por_usuario.cortesusua_cli_id)
            WHERE ( TIMESTAMPDIFF(MINUTE, cortesusua_fecha_cierre, cortesusua_fecha_apertura) >= ".$minimoMinutos." )
            AND ( cortes_por_usuario.cortesusua_sem_id = ".$sem_id." )
            AND ( cortes_por_usuario.cortesusua_arch_id = ".$arch_id." )
            AND ( cortes_por_usuario.cortesusua_cli_id IN (".implode(',',$lotes_clientes)."))";
            
//            $do->query($sql);
            $rescxu = $mdb2->query($sql);

       
//    $do = DB_DataObject::factory('cortes_por_usuario');
//    $do_emp = DB_DataObject::factory('clientes');
//    $do->cortesusua_emp_id = $emp_id;
//    $do->cortesusua_sem_id = $sem_id;
//    $do->cortesusua_cli_id = $cliente_id;
//    $do->joinAdd($do_emp);
//    $do->selectAdd('TIMESTAMPDIFF(HOUR, cortesusua_fecha_cierre, cortesusua_fecha_apertura) AS cant_horas');
//    $do->selectAdd('TIMESTAMPDIFF(MINUTE, cortesusua_fecha_cierre, cortesusua_fecha_apertura) AS cant_minutos');
//    $do->selectAdd('MINUTE(TIME(cortesusua_fecha_apertura)) AS minuto_apertura');
//    $do->selectAdd('MINUTE(TIME(cortesusua_fecha_cierre)) AS minuto_cierre');
//    $do->selectAdd('HOUR(TIME(cortesusua_fecha_apertura)) AS hora_apertura');
//    $do->selectAdd('HOUR(TIME(cortesusua_fecha_cierre)) AS hora_cierre');
//    $do->whereAdd('TIMESTAMPDIFF(MINUTE, cortesusua_fecha_cierre, cortesusua_fecha_apertura) >= '.$minimoMinutos);
//    //$do->whereAdd('TIMESTAMPDIFF(HOUR, cortesusua_fecha_cierre, cortesusua_fecha_apertura) >= '.$minimoHoras);
//    $do->find();

    $tarifa_id = 0;
    //$do['cortesusua_id']
    $i = 0;
    //while($do->fetch()){
    while($do = $rescxu->fetchRow(MDB2_FETCHMODE_ASSOC)){
		set_time_limit(30);
        $tarifa_id = $do['cli_tarifa_id'];
        $cortes[$i]['emp_id'] = $do['cli_emp_id'];
        $cortes[$i]['sem_id'] = $do['cortesusua_sem_id'];
        $cortes[$i]['cli_id'] = $do['cli_id'];
        $cortes[$i]['ct_id'] = $do['cortesusua_ct_id'];
        $cortes[$i]['tarifa_id'] = $do['cli_tarifa_id'];
        $cortes[$i]['cant_horas'] = $do['cant_horas'];
        $cortes[$i]['cant_minutos'] = $do['cant_minutos'];
        $cortes[$i]['fecha_cierre'] = $do['cortesusua_fecha_cierre'];
        $cortes[$i]['fecha_apertura'] = $do['cortesusua_fecha_apertura'];
        $cortes[$i]['hora_cierre'] = $do['hora_cierre'];
        $cortes[$i]['hora_apertura'] = $do['hora_apertura'];
        $cortes[$i]['minuto_cierre'] = $do['minuto_cierre'];
        $cortes[$i]['minuto_apertura'] = $do['minuto_apertura'];
        $cortes[$i]['arch_linea'] = $do['cortesusua_arch_linea'];
        $i++;
    }
//    var_dump($cortes);
//    exit;
//
//        $res->free();

        //$do = DB_DataObject::factory('coeficientes_ki');
        $sql = "SELECT coefki_emp_id, coefki_tar_id, coefki_hora, coefki_valor, tarifa_niveltension, limsemcort_tipo_limite, limsemcort_valor
                FROM coeficientes_ki
                INNER JOIN tarifa ON (tarifa.tarifa_id=coeficientes_ki.coefki_tar_id)
                INNER JOIN limites_semestral_cortes ON (limites_semestral_cortes.limsemcort_niveltension=tarifa.tarifa_niveltension)
                WHERE ( coeficientes_ki.coefki_emp_id = ".$emp_id." )
                AND coeficientes_ki.coefki_tar_id = ".$tarifa_id;
        
        //$do->query($sql);
        $res = $mdb2->query($sql);


//    //Busco el coeficiente segun segun la empresa
//    $do = DB_DataObject::factory('coeficientes_ki');
//    $do->coefki_emp_id = $emp_id;
//    $do_tar = DB_DataObject::factory('tarifa');
//    $do_lim = DB_DataObject::factory('limites_semestral_cortes');
//    $do_tar->joinAdd($do_lim);
//    $do->joinAdd($do_tar);
    
    $coeficientes = array();
    
    //if(!$do->fetch()){
    if($res->numRows() == 0){
        //do{
            //DB_DataObject::debugLevel(5);
            //$do = DB_DataObject::factory('coeficientes_ki');
            $sql = "SELECT coefki_emp_id, coefki_tar_id, coefki_hora, coefki_valor, tarifa_niveltension, limsemcort_tipo_limite, limsemcort_valor
                    FROM coeficientes_ki
                    INNER JOIN tarifa ON (tarifa.tarifa_id=coeficientes_ki.coefki_tar_id)
                    INNER JOIN empresas ON (empresas.emp_id=coeficientes_ki.coefki_emp_id)
                    INNER JOIN limites_semestral_cortes ON (limites_semestral_cortes.limsemcort_niveltension = tarifa.tarifa_niveltension)
                    WHERE ( ( empresas.emp_tdist_id = ".$tipo_distribuidora_id." )
                    AND ( empresas.emp_zona_id = ".$zona_id." ) ) ";

            $res = $mdb2->query($sql);


//            //Busco los coeficientes de la tipo_distribuidora y esa zona
//            $do = DB_DataObject::factory('coeficientes_ki');
//            $do_tar = DB_DataObject::factory('tarifa');
//            $do->joinAdd($do_tar);
//            $do_lim = DB_DataObject::factory('limites_semestral_cortes');
//            $do_tar->joinAdd($do_lim);
//            $do_emp = DB_DataObject::factory('empresas');
//            $do_emp->emp_tdist_id = $tipo_distribuidora_id;
//            $do_emp->emp_zona_id = $zona_id;
//            $do->joinAdd($do_emp);
        //} while($do->find());
        //$do->query($sql);
        
    }

    //while($do->fetch()){
    while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
		set_time_limit(30);
        $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['emp_id'] = $do['coefki_emp_id'];
        $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['tarifa_id'] = $do['coefki_tar_id'];
        $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['hora'] = $do['coefki_hora'];
        $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['valor'] = $do['coefki_valor'];
        $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['nivel_tension'] = $do['tarifa_niveltension'];
        $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']][$do['limsemcort_tipo_limite']] = $do['limsemcort_valor'];
    }

    $res->free();

    //Si coeficientes no trae nada tengo un error
    $error_coef = null;
        $error_coef = null;
        if(count($coeficientes) == 0){
            $error_coef = "err-coef|";
        }

//      var_dump($coeficientes);
//      exit;
//
    
    $penaliza = array();
    $procesa = array();
    $interrupciones = array();
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
            $penaliza[$k]['duracion'] = 1;
        }
        else{
            $penaliza[$k]['tipo'] = 'F';
            if($_SESSION['frecuencia'] > $coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['F']){
                $procesa['frecuencia'] = 1;
                $penaliza[$k]['frecuencia'] = 1;
            }

        }

//        echo ($c['emp_id']);
//        echo ('<br />');
//        echo ($c['tarifa_id']);
//        echo ('<br />');
//        echo ($c['cant_horas']);
//        echo ('<br />');
   

        
        $penaliza[$k]['emp_id'] = $c['emp_id'];
        $penaliza[$k]['tarifa_id'] = $c['tarifa_id'];
        $penaliza[$k]['cli_id'] = $c['cli_id'];
        $penaliza[$k]['ct_id'] = $c['ct_id'];
        $penaliza[$k]['sem_id'] = $c['sem_id'];
        $penaliza[$k]['cant_horas'] = $c['cant_horas'];
        $penaliza[$k]['cant_minutos'] = $c['cant_minutos'];
        $penaliza[$k]['fecha_cierre'] = $c['fecha_cierre'];
        $penaliza[$k]['fecha_apertura'] = $c['fecha_apertura'];
        $penaliza[$k]['arch_linea'] = $c['arch_linea'];
        //$penaliza[$k]['valor'] = calcularValor($coeficientes,$c['fecha_cierre'],$c['fecha_apertura'],$c['cant_horas'],$c['cant_minutos']);
        //$penaliza[$k]['interrupcion'] = calcularInterrupcion($penaliza[$k]['tipo'], $procesa, $coeficientes,$c['hora_cierre'],$c['hora_apertura'],$c['emp_id'],$c['tarifa_id'],$c['cant_horas'],$c['cant_minutos'],$c['minuto_cierre'],$c['minuto_apertura']);
        $interrupciones = calcularInterrupcion($penaliza[$k]['tipo'], $procesa, $coeficientes,$c['hora_cierre'],$c['hora_apertura'],$c['emp_id'],$c['tarifa_id'],$c['cant_horas'],$c['cant_minutos'],$c['minuto_cierre'],$c['minuto_apertura']);
        $penaliza[$k]['energia_facturada'] = calcularEnergiaFacturada($c['cli_id'],$c['sem_id'],$mdb2);
        $penaliza[$k]['energia_no_suministrada'] = penalizar($interrupciones, $penaliza[$k]['energia_facturada'], 4380); ///4380
        //$penaliza[$k]['energia_no_suministrada_formula'] = $error_coef.penalizarToString($interrupciones, $penaliza[$k]['energia_facturada'], 4380); ///4380
        $penaliza[$k]['energia_no_suministrada_formula'] = '';
    }
    
    return $penaliza;

}
