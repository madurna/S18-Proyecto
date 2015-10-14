<?php
ini_set("memory_limit","3072M");
include('MDB2.php');
require_once(INC_PATH.'/funciones/calcularEnergiaNoSuministrada.php');

function calcularMultas($arch_id = 0)
{
    define('CANTCLIENTES',50000);

    //DB_DataObject::debugLevel(5);
    $config = PEAR::getStaticProperty("DB_DataObject",'options');
    $mdb2 =& MDB2::connect($config['database']);

    if (PEAR::isError($mdb2)) {
        die($mdb2->getMessage());
    }


    //Busco los datos de semestre, empresa, etc de acuerdo al arch_id
    $sql = "SELECT ai.arch_id, ai.arch_semestre, ai.arch_emp_id, e.emp_tdist_id, e.emp_zona_id FROM archivos_importacion ai
                    INNER JOIN empresas e ON e.emp_id = ai.arch_emp_id
                    WHERE arch_fecha_anulacion IS NULL
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
        //$arch_lineas_procesadas = $do['arch_lineas_procesadas'];
    }

    $res->free();

    //Vector con penalizaciones
    $penaliza = array();

    //Me fijo la cantidad de usuarios en cortes por usuario
    $sql = "SELECT cortesusua_cli_id FROM cortes_por_usuario
            WHERE cortesusua_arch_id = ".$arch_id."
            GROUP BY cortesusua_cli_id";

    $res = $mdb2->query($sql);

    $lista_clientes = array();
    while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
        set_time_limit(30);
        $lista_clientes[] = $do['cortesusua_cli_id'];
    }


    $cant_lotes_clientes = 0;

    $lotes_clientes = array_chunk($lista_clientes,CANTCLIENTES);
    $cant_lotes_clientes = count($lotes_clientes);

    for($i= 0; $i < $cant_lotes_clientes; $i++){
        $multas_por_usuario_calculada = array();

        //Calculo de multas
        $penaliza = calcularEnergiaNoSuministrada($minimoMinutos,$minimoHoras,$sem_id,$emp_id,$tipo_distribuidora_id,$zona_id,$cliente_id,$arch_id,$lotes_clientes[$i],$mdb2);

        //Traigo el valor de las tarifas
        $sql = "SELECT * FROM costo_energia_no_suministrada";
        $res = $mdb2->query($sql);

        $costos_energia_no_suministrada = array();


        while($do = $res->fetchRow(MDB2_FETCHMODE_OBJECT)){
            $costos_energia_no_suministrada[$do->cens_tarifa_id] = $do->cens_valor;
        }

        $res->free();

        //Sumo las multas de ese usuario
        $multa_total_calculada = 0;
        $frecuencia = 0;
        $duracion = 0;

        foreach($penaliza as $key => $pen){
            //Busco el valor de la multa segun
            $penaliza[$key]['multa_usuario'] = $pen['energia_no_suministrada'] * $costos_energia_no_suministrada[$pen['tarifa_id']];
            //$penaliza[$key]['multa_usuario_formula'] = $pen['energia_no_suministrada']." * ".$costos_energia_no_suministrada[$pen['tarifa_id']];
            $penaliza[$key]['multa_usuario_formula'] = '';

            $multa_total_calculada+= $penaliza[$key]['multa_usuario'];
            $frecuencia = $penaliza[$key]['frecuencia'];
            $duracion = $penaliza[$key]['duracion'];
            //if($penaliza[$key]['multa_usuario'] > 0 )
            $multas_por_usuario_calculada[] = "(".$sem_id.",".$penaliza[$key]['cli_id'].",1,".floatval($penaliza[$key]['energia_facturada']).",".floatval($penaliza[$key]['energia_no_suministrada']).",'".floatval($penaliza[$key]['energia_no_suministrada_formula'])."',".$penaliza[$key]['multa_usuario'].",'".$penaliza[$key]['multa_usuario_formula']."',".$arch_id.",".intval($penaliza[$key]['arch_linea']).",".intval($frecuencia).",".intval($duracion).")";
        }


        $lotes = array_chunk($multas_por_usuario_calculada,3000);
        foreach($lotes as $lot){
            set_time_limit(30);
            try{
                $res = $mdb2->query("BEGIN");
                $sql = "INSERT INTO multas_por_usuario_calculada (
                                    multasusuacalc_sem_id,
                                    multasusuacalc_cli_id,
                                    multasusuacalc_ct_id,
                                    multasusuacalc_enerfacturada,
                                    multasusuacalc_enernosum,
                                    multasusuacalc_enernosum_formula,
                                    multasusuacalc_multa,
                                    multasusuacalc_multa_formula,
                                    multasusuacalc_arch_id,
                                    multasusuacalc_arch_linea,
                                    multasusuacalc_frecuencia,
                                    multasusuacalc_duracion) VALUES ".implode(',',$lot);
                //echo "<br /><br />";
                $res = $mdb2->query($sql);
                $res = $mdb2->query("COMMIT");
            }
            catch(Exception $e){
                $res = $mdb2->query("ROLLBACK");
                die($e->getMessage());
            }
        }

    }
    echo "LLego OK !!!!!";
}
