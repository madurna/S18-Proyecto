<?php
require_once('calcularInterrupcion.php');
require_once('calcularEnergiaFacturada.php');
require_once('penalizar.php');
/**
 * Me da los clientes que penalizan segun las operaciones de apertura seleccionadas
 * 
 * $op_apertura = array()
 * $minimoMinutos = Cantidad minima de minutos a tomar en cuenta
 * $mdb2 = null
 * */

function clientesQuePenalizan($op_apertura = array(), $minimoMinutos = 3, $suc_id = 0,$mdb2 = null)
{
	//Armo la lista de clientes
	$sql = "SELECT cortesusua_cli_id
			FROM cortes_por_usuario 
			WHERE cortesusua_op_apertura IN (".$op_apertura.") 
			AND ( TIMESTAMPDIFF(MINUTE, cortesusua_fecha_apertura, cortesusua_fecha_cierre) >= ".$minimoMinutos." ) 
			ORDER BY cortes_por_usuario.cortesusua_fecha_apertura ASC";
	
	$res = $mdb2->query($sql);
	
	$lista_clientes = array();
	while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$lista_clientes[$do['cortesusua_cli_id']] = $do['cortesusua_cli_id'];
	}
	
	
	$clientes = implode(",",$lista_clientes);
	
	$sql = "SELECT cortesusua_cli_id, cortesusua_sem_id, cortesusua_arch_id, cli_emp_id, emp_nombre, emp_tdist_id, emp_zona_id, cli_id, cli_suc_id, 
			cli_cod_suministro, cli_tarifa_id, cortesusua_fecha_cierre,cortesusua_fecha_apertura, cli_titular, cortesusua_op_apertura,
	        TIMESTAMPDIFF(HOUR, cortesusua_fecha_apertura, cortesusua_fecha_cierre) AS cant_horas,
            TIMESTAMPDIFF(MINUTE, cortesusua_fecha_apertura, cortesusua_fecha_cierre) AS cant_minutos,
            SECOND(TIME(cortesusua_fecha_apertura)) AS segundo_apertura ,
            SECOND(TIME(cortesusua_fecha_cierre)) AS segundo_cierre ,
            MINUTE(TIME(cortesusua_fecha_apertura)) AS minuto_apertura ,
            MINUTE(TIME(cortesusua_fecha_cierre)) AS minuto_cierre ,
            HOUR(TIME(cortesusua_fecha_apertura)) AS hora_apertura ,
            HOUR(TIME(cortesusua_fecha_cierre)) AS hora_cierre
			FROM cortes_por_usuario
			INNER JOIN clientes ON cortesusua_cli_id = cli_id
			INNER JOIN empresas ON cli_emp_id = emp_id";
			if($suc_id != 0)
				$sql .= "INNER JOIN sucursales ON emp_id = suc_emp_id";
				
			$sql .= " WHERE cortesusua_op_apertura NOT IN (".$op_apertura.") 
			AND cortesusua_cli_id IN (".$clientes.")
			AND ( TIMESTAMPDIFF(MINUTE, cortesusua_fecha_apertura, cortesusua_fecha_cierre) >= ".$minimoMinutos." ) 
			ORDER BY cortes_por_usuario.cortesusua_fecha_apertura ASC";
	$rescxu = $mdb2->query($sql);
	
    $tarifas = array();
    $i = 0;
    $penaliza = array();
    $suc = array();
    
    if($rescxu->numRows() > 0){
    
        //while($do->fetch()){
        while($do = $rescxu->fetchRow(MDB2_FETCHMODE_ASSOC)){
            set_time_limit(30);
            $emp_id = $do['cli_emp_id'];
            $cortes[$i]['op_apertura'] = $do['cortesusua_op_apertura'];
            $tarifas[$do['cli_tarifa_id']] = $do['cli_tarifa_id'];
            $suc[$do['cli_suc_id']] = $do['cli_suc_id'];
            $cortes[$i]['emp_nombre'] = $do['emp_nombre'];
            $cortes[$i]['emp_id'] = $do['cli_emp_id'];
            $cortes[$i]['cod_suministro'] = $do['cli_cod_suministro'];
            $cortes[$i]['suc_id'] = $do['cli_suc_id']; //Agregado por HERNAN
            $cortes[$i]['suc_nombre'] = $do['suc_nombre']; 
            $cortes[$i]['cli_nombre'] = $do['cli_titular']; 
            $cortes[$i]['sem_id'] = $do['cortesusua_sem_id'];
            $cortes[$i]['cli_id'] = $do['cli_id'];
           // $cortes[$i]['ct_id'] = $do['cortesusua_ct_id'];
            $cortes[$i]['tarifa_id'] = $do['cli_tarifa_id'];
            $cortes[$i]['cant_horas'] = $do['cant_horas'];
            $cortes[$i]['cant_minutos'] = $do['cant_minutos'];
            $cortes[$i]['fecha_cierre'] = $do['cortesusua_fecha_cierre'];
            $cortes[$i]['fecha_apertura'] = $do['cortesusua_fecha_apertura'];
            $cortes[$i]['hora_cierre'] = $do['hora_cierre'];
            $cortes[$i]['hora_apertura'] = $do['hora_apertura'];
            $cortes[$i]['minuto_cierre'] = $do['minuto_cierre'];
            $cortes[$i]['minuto_apertura'] = $do['minuto_apertura'];
            $cortes[$i]['segundo_cierre'] = $do['segundo_cierre'];
            $cortes[$i]['segundo_apertura'] = $do['segundo_apertura'];
            //$cortes[$i]['arch_linea'] = $do['cortesusua_arch_linea'];
            $_SESSION['frecuencia'][$do['cli_id']] = 0;
            $_SESSION['duracion'][$do['cli_id']] = 0;
            $penaliza[$i]['duracion'] = 0;
            $penaliza[$i]['frecuencia'] = 0;
            $i++;
        }
 
            $sql = "SELECT coefki_emp_id, coefki_tar_id, coefki_hora, coefki_valor, tarifa_niveltension
                    FROM coeficientes_ki
                    INNER JOIN tarifa ON (tarifa.tarifa_id=coeficientes_ki.coefki_tar_id)
                    WHERE ( coeficientes_ki.coefki_emp_id = ".$emp_id." )
                    AND coeficientes_ki.coefki_tar_id IN (".implode(',',$tarifas).")";

        //AND coeficientes_ki.coefki_tar_id = ".$tarifa_id
            $res = $mdb2->query($sql);

        if (PEAR::isError($res)) {
			echo $sql;
            die($res->getMessage());
        }

    //    //Busco el coeficiente segun segun la empresa
          $coeficientes = array();

        //if(!$do->fetch()){
        if($res->numRows() == 0){

                $sql = "SELECT coefki_emp_id, coefki_tar_id, coefki_hora, coefki_valor, tarifa_niveltension
                        FROM coeficientes_ki
                        INNER JOIN tarifa ON (tarifa.tarifa_id=coeficientes_ki.coefki_tar_id)
                        INNER JOIN empresas ON (empresas.emp_id=coeficientes_ki.coefki_emp_id)
                        WHERE ( ( empresas.emp_tdist_id = ".$tipo_distribuidora_id." )
                        AND ( empresas.emp_zona_id = ".$zona_id." ) ) ";

                $res = $mdb2->query($sql);

        }

        //while($do->fetch()){
        
        while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
            set_time_limit(30);
            $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['emp_id'] = $do['coefki_emp_id'];
            $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['tarifa_id'] = $do['coefki_tar_id'];
            $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['hora'] = $do['coefki_hora'];
            $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['valor'] = $do['coefki_valor'];
            $coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']]['nivel_tension'] = $do['tarifa_niveltension'];
            //$coeficientes[$do['coefki_emp_id']][$do['coefki_tar_id']][$do['coefki_hora']][$do['limsemcort_tipo_limite']] = $do['limsemcort_valor'];
        }
        $res->free();

        //Ahora busco los limites
        $sql = "SELECT * FROM limites_semestral_cortes lm
                INNER JOIN sucursales s ON s.suc_tipo = lm.limsemcort_tipo_distribucion
                INNER JOIN tarifa t ON t.tarifa_niveltension = lm.limsemcort_niveltension
                WHERE s.suc_emp_id = ".$emp_id."
                AND s.suc_id IN  (".implode(',',$suc).")
                AND t.tarifa_id IN (".implode(',',$tarifas).")";

        $res = $mdb2->query($sql);

        $limites = array();

        if($res->numRows() == 0){
            //Busco los de la empresa al no haber de la sucursal
            $sql = "SELECT * FROM limites_semestral_cortes lm
                INNER JOIN sucursales s ON s.suc_tipo = lm.limsemcort_tipo_distribucion
                INNER JOIN tarifa t ON t.tarifa_niveltension = lm.limsemcort_niveltension
                WHERE s.suc_emp_id = ".$emp_id."
                AND t.tarifa_id IN (".implode(',',$tarifas).")";

            $res = $mdb2->query($sql);

        }

        while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
            if($do['suc_id'] == null)
                $do['suc_id'] = 0;

            $limites[$do['suc_emp_id']][$do['suc_id']][$do['limsemcort_tipo_limite']] = $do['limsemcort_valor']; //Modificado por HERNAN
        }

        //Si coeficientes no trae nada tengo un error
        $error_coef = null;
            $error_coef = null;
            if(count($coeficientes) == 0){
                $error_coef = "EC|";
            }

//          var_dump($coeficientes);
//          var_dump($limites);
//          exit;
    
        $procesa = array();
        $interrupciones = array();

        //Busco a ver a quien le corresponde pagar7
        //var_dump($cortes);
        
        foreach($cortes as $k => $c){
            $_SESSION['frecuencia'][$c['cli_id']]++;

            //Duracion
    //        if($c['cant_horas'] == 0)
    //            $c['cant_horas'] = 0;

             //if($coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['D'] != null && (intval($c['cant_horas']) >= intval($coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['D']))){
             //HERNAN
             
             if($limites[$c['emp_id']][$c['suc_id']]['D'] != null && ($c['cant_minutos']/60 > intval($limites[$c['emp_id']][$c['suc_id']]['D']))){
                $penaliza[$k]['tipo'] = 'D';
                //$penaliza[$k]['duracion'] = $coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['D'];
                $procesa['duracion'][$c['cli_id']] = 1;
                $penaliza[$k]['duracion'] = 1;
                $_SESSION['duracion'][$c['cli_id']]++;
                $_SESSION['frecuencia'][$c['cli_id']]--;
            }
            else{
                $penaliza[$k]['tipo'] = 'F';
                //if($_SESSION['frecuencia'][$c['cli_id']] > $coeficientes[$c['emp_id']][$c['tarifa_id']][$c['cant_horas']]['F']){
                //HERNAN
            if($_SESSION['frecuencia'][$c['cli_id']] > $limites[$c['emp_id']][$c['suc_id']]['F']){
                    $procesa['frecuencia'][$c['cli_id']] = 1;
                    $penaliza[$k]['frecuencia'] = 1;
                }
            }

            $penaliza[$k]['emp_id'] = $c['emp_id'];
            $penaliza[$k]['op_apertura'] = $c['op_apertura'];
            $penaliza[$k]['frecuencia'] = $_SESSION['frecuencia'][$c['cli_id']];
            $penaliza[$k]['duracion'] = $_SESSION['duracion'][$c['cli_id']];
            $penaliza[$k]['emp_nombre'] = $c['emp_nombre'];
            $penaliza[$k]['cli_nombre'] = $c['cli_nombre'];
            $penaliza[$k]['suc_nombre'] = $c['suc_nombre'];
            $penaliza[$k]['suc_id'] = $c['suc_id'];
            $penaliza[$k]['cod_suministro'] = $c['cod_suministro'];
            $penaliza[$k]['numero_corte'] = $_SESSION['frecuencia'][$c['cli_id']] + $_SESSION['duracion'][$c['cli_id']];			
            $penaliza[$k]['tarifa_id'] = $c['tarifa_id'];
            $penaliza[$k]['cli_id'] = $c['cli_id'];
            $penaliza[$k]['limites'] = $limites[$c['emp_id']][$c['suc_id']];
            $penaliza[$k]['suc_id'] = $c['suc_id'];
            //$penaliza[$k]['ct_id'] = 'NULL';
            $penaliza[$k]['sem_id'] = $c['sem_id'];
            $penaliza[$k]['cant_horas'] = $c['cant_horas'];
            $penaliza[$k]['cant_minutos'] = $c['cant_minutos'];
            $penaliza[$k]['fecha_cierre'] = $c['fecha_cierre'];
            $penaliza[$k]['fecha_apertura'] = $c['fecha_apertura'];
            //$penaliza[$k]['arch_linea'] = $c['arch_linea'];
            //$penaliza[$k]['valor'] = calcularValor($coeficientes,$c['fecha_cierre'],$c['fecha_apertura'],$c['cant_horas'],$c['cant_minutos']);
            //$penaliza[$k]['interrupcion'] = calcularInterrupcion($penaliza[$k]['tipo'], $procesa, $coeficientes,$c['hora_cierre'],$c['hora_apertura'],$c['emp_id'],$c['tarifa_id'],$c['cant_horas'],$c['cant_minutos'],$c['minuto_cierre'],$c['minuto_apertura']);
            $interrupciones = calcularInterrupcion($penaliza[$k]['tipo'], $procesa, $c['cli_id'],$coeficientes,$c['hora_cierre']+1,$c['hora_apertura']+1,$c['emp_id'],$c['tarifa_id'],$c['cant_horas'],$c['cant_minutos'],$c['minuto_cierre'],$c['minuto_apertura'],$c['segundo_cierre'],$c['segundo_apertura']);

            $penaliza[$k]['interrupcion_formula'] = calcularInterrupcionToString($penaliza[$k]['tipo'], $procesa, $c['cli_id'],$coeficientes,$c['hora_cierre']+1,$c['hora_apertura']+1,$c['emp_id'],$c['tarifa_id'],$c['cant_horas'],$c['cant_minutos'],$c['minuto_cierre'],$c['minuto_apertura'],$c['segundo_cierre'],$c['segundo_apertura']);
            $penaliza[$k]['energia_facturada'] = calcularEnergiaFacturada($c['cli_id'],$c['sem_id'],$mdb2);
            $penaliza[$k]['energia_no_suministrada_total'] = penalizar($interrupciones, $penaliza[$k]['energia_facturada'], 4380) * ($penaliza[$k]['energia_facturada']/4380); ///4380
            
            if($procesa['frecuencia'][$c['cli_id']] == 1 || $procesa['duracion'][$c['cli_id']] == 1){
                $penaliza[$k]['energia_no_suministrada'] = penalizar($interrupciones, $penaliza[$k]['energia_facturada'], 4380) * ($penaliza[$k]['energia_facturada']/4380); ///4380
            }
            else{
                $penaliza[$k]['energia_no_suministrada'] = 0;
            }
                        
            if(is_array($interrupciones)){
                $penaliza[$k]['interrupcion'] = array_sum($interrupciones);
                $penaliza[$k]['energia_no_suministrada_total_formula'] = $error_coef.penalizarToString($interrupciones, $penaliza[$k]['energia_facturada'], 4380); ///4380
               
            }
            else {
                $penaliza[$k]['interrupcion'] = 0;
                //$penaliza[$k]['energia_no_suministrada_total_formula'] = $error_coef.noPenalizarToString($interrupciones, $penaliza[$k]['energia_facturada'], 4380); ///4380
                $penaliza[$k]['energia_no_suministrada_total_formula'] = '';
            }
            
            if(is_array($interrupciones) && ($procesa['frecuencia'][$cliente_id] == 1 || $procesa['duracion'][$cliente_id] == 1)){
                $penaliza[$k]['interrupcion'] = array_sum($interrupciones);
                $penaliza[$k]['energia_no_suministrada_formula'] = $error_coef.penalizarToString($interrupciones, $penaliza[$k]['energia_facturada'], 4380); ///4380                
            }
            else {
                $penaliza[$k]['interrupcion'] = 0;
                //$penaliza[$k]['energia_no_suministrada_formula_no_proc'] = $error_coef.noPenalizarToString($interrupciones, $penaliza[$k]['energia_facturada'], 4380); ///4380
                $penaliza[$k]['energia_no_suministrada_formula'] = '';
            }


            //Seteo para que no acumule por duracion
            $procesa['duracion'][$c['cli_id']] = 0;
        }
    }
        
    return $penaliza;

}
