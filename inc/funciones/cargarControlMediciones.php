<?php
/**
 * Carga la tabla de control de mediciones
 */
//require_once("../../config/web.config");
require_once(INC_PATH.'/funciones/cantidadSemanas.php');
require_once(CFG_PATH.'/data.config');
function cargarControlMedicionesCliente($arch_id = null) {
    //DB_DataObject::debugLevel(5);
    //Busco las mediciones
    $do = DB_DataObject::factory('mediciones_clientes');
    $sql = "SELECT * FROM mediciones_clientes mc
            INNER JOIN archivos_importacion ai ON ai.arch_id = mc.medcli_arch_id
            WHERE mc.medcli_resultado <> 2
            AND mc.medcli_arch_id = ".$arch_id."
            ORDER BY medcli_fecha_inst, medcli_sortcli_id";
    $do->query($sql);
    

    while($do->fetch()){
        try{
            $do_cm = DB_DataObject::factory('control_penalizacion_cliente');
            $sql = "SELECT cpcl_id, cpcl_fecha_desde, cpcl_credito FROM control_penalizacion_cliente
                    WHERE cpcl_sortcli_id = ".$do->medcli_sortcli_id." and cpcl_fecha_hasta is null
                    ORDER BY cpcl_id DESC
                    LIMIT 1";
            $do_cm->query($sql);
            $do_cm->fetch();
            
            if($do_cm->cpcl_id){
                $semanas = cantidadSemanas($do_cm->cpcl_fecha_desde,$do->medcli_fecha_inst);
                 $creditoTotal = $semanas * $do_cm->cpcl_credito;
                 
                 $sql = "UPDATE control_penalizacion_cliente SET
                 cpcl_fecha_hasta = '".$do->medcli_fecha_inst."',
                 cpcl_credito_total = ".$creditoTotal.",
                 cpcl_hasta_medcli_id = ".$do->medcli_id."
                 WHERE cpcl_id = ".$do_cm->cpcl_id;
                 
                  $do_cm->query($sql);
            
                 //Inserto el nuevo
                 if($do->medcli_penalizado == 1){
                     $do_cm1 = DB_DataObject::factory('control_penalizacion_cliente');
                     $do_cm1->cpcl_sortcli_id = $do->medcli_sortcli_id;
                     $do_cm1->cpcl_fecha_desde = $do->medcli_fecha_inst;
                     $do_cm1->cpcl_fecha_hasta = 'null';
                     $do_cm1->cpcl_credito = $do->medcli_credito;
                     $do_cm1->cpcl_desde_medcli_id = $do->medcli_id;
                     $do_cm1->insert();
                 }
                 
            }
            else{
                if($do->medcli_penalizado == 1){
                    //Inserto
                    $do_cm = DB_DataObject::factory('control_penalizacion_cliente');
                    $do_cm->cpcl_sortcli_id = $do->medcli_sortcli_id;
                    $do_cm->cpcl_fecha_desde = $do->medcli_fecha_inst;
                    $do_cm->cpcl_fecha_hasta = 'null';
                    $do_cm->cpcl_credito = $do->medcli_credito;
                    $do_cm->cpcl_desde_medcli_id = $do->medcli_id;
                    $do_cm->insert();
                }
            }
        }
        catch(Exception $e){            
            die($e->getMessage());
        }
    }
}
function cargarControlMedicionesCT($arch_id = null) {
    //DB_DataObject::debugLevel(5);
    //Busco las mediciones
    $do = DB_DataObject::factory('mediciones_ct');
    $sql = "SELECT * FROM mediciones_ct mc
            INNER JOIN archivos_importacion ai ON ai.arch_id = mc.medct_arch_id
            WHERE mc.medct_resultado <> 2
            AND mc.medct_arch_id = ".$arch_id."
            ORDER BY medct_fecha_inst, medct_sortct_id";
    $do->query($sql);    

    while($do->fetch()){
        try{
            $do_cm = DB_DataObject::factory('control_penalizacion_ct');
            $sql = "SELECT cpct_id, cpct_fecha_desde, cpct_credito FROM control_penalizacion_ct
                    WHERE cpct_sortct_id = ".$do->medct_sortct_id." and cpct_fecha_hasta is null
                    ORDER BY cpct_id DESC
                    LIMIT 1";
            $do_cm->query($sql);
            $do_cm->fetch();
            
            if($do_cm->cpct_id){
                $semanas = cantidadSemanas($do_cm->cpct_fecha_desde,$do->medct_fecha_inst);
                 $creditoTotal = $semanas * $do_cm->cpct_credito;
                 
                 $sql = "UPDATE control_penalizacion_ct SET
                 cpct_fecha_hasta = '".$do->medct_fecha_inst."',
                 cpct_credito_total = ".$creditoTotal.",
                 cpct_hasta_medct_id = ".$do->medct_id."
                 WHERE cpct_id = ".$do_cm->cpct_id;
                 
                  $do_cm->query($sql);
            
                 //Inserto el nuevo
                 if($do->medct_resultado == 1){
                     $do_cm1 = DB_DataObject::factory('control_penalizacion_ct');
                     $do_cm1->cpct_sortct_id = $do->medct_sortct_id;
                     $do_cm1->cpct_fecha_desde = $do->medct_fecha_inst;
                     $do_cm1->cpct_fecha_hasta = 'null';
                     $do_cm1->cpct_credito = $do->medct_credito;
                     $do_cm1->cpct_desde_medct_id = $do->medct_id;
                     $do_cm1->insert();
                 }
                 
            }
            else{
                if($do->medct_resultado == 1){
                    //Inserto
                    $do_cm = DB_DataObject::factory('control_penalizacion_ct');
                    $do_cm->cpct_sortct_id = $do->medct_sortct_id;
                    $do_cm->cpct_fecha_desde = $do->medct_fecha_inst;
                    $do_cm->cpct_fecha_hasta = 'null';
                    $do_cm->cpct_credito = $do->medct_credito;
                    $do_cm->cpct_desde_medct_id = $do->medct_id;
                    $do_cm->insert();
                }
            }
        }
        catch(Exception $e){            
            die($e->getMessage());
        }
    }
}

if(isset($_GET['ejecutar'])) cargarControlMedicionesCliente($_GET['arch_id']);
if(isset($_GET['ejecutarCT'])) cargarControlMedicionesCT($_GET['arch_id']);