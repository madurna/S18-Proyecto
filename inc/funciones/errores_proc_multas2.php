<?php
/**
 * Procesar errores de multas
 * @param <intenger> $usuario_id
 * @param <integer> $error_id
 */
function errores_proc_multas($cliente_id = 0,$sem_id = 0,$error_code = null){

    //DB_DataObject::debugLevel(5);
    $do = DB_DataObject::factory('errores_proc_multas');
    $sql = "SELECT * FROM errores_proc_multas 
            WHERE err_proc_mult_codigo = '".$error_code."'
            AND err_proc_mult_cli_id = ".$cliente_id;
    $do->query($sql);

    if(!$do->fetch()){
        echo $sql = "INSERT INTO errores_proc_multas (
                err_proc_mult_sem_id,
                err_proc_mult_cli_id,
                err_proc_mult_codigo,
                err_proc_mult_fecha) VALUES (
                ".$sem_id.",
                ".$cliente_id.",
                '".$error_code."',
                NOW())";
                exit;
        $do->query($sql);
    }
}
