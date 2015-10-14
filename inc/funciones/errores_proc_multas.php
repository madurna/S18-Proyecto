<?php
/**
 * Procesar errores de multas
 * @param <intenger> $usuario_id
 * @param <integer> $error_id
 */
function errores_proc_multas($cliente_id = 0,$sem_id = 0,$error_code = null, $arch_id = 0,$mdb2 = null){

    //Verifico si ya existe el registro
    $sql = "SELECT * FROM errores_proc_multas
            WHERE err_proc_mult_codigo = '".$error_code."'
            AND err_proc_mult_cli_id = ".$cliente_id."
            AND archivos_importacion_arch_id = ".$arch_id;

    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo $sql;
        die($res->getMessage());
    }

    
    if($res->numRows() == 0){
        //No existe lo inserto
        echo_debug('Error para el cliente '.$cliente_id.'. No está en la cadena electrica');
        $sql = "INSERT INTO errores_proc_multas (
                err_proc_mult_sem_id,
                err_proc_mult_cli_id,
                err_proc_mult_codigo,
                err_proc_mult_fecha,
                archivos_importacion_arch_id,
                errores_proc_recalculado,
                errores_fecha_recalculado) VALUES (
                ".$sem_id.",
                ".$cliente_id.",
                '".$error_code."',
                NOW(),
                ".$arch_id.",
                0,
                '0000-00-00 00:00:00')";
        $res = $mdb2->query($sql);

        if (PEAR::isError($res)) {
            echo $sql;
            die($res->getMessage());
        }
    }
    else{
        //Si existe actualizo el error recalculado
        echo_debug('Actualizo el recálculo para el cliente '.$cliente_id.' ');
        $sql = "UPDATE errores_proc_multas SET
                errores_proc_recalculado = 0
                WHERE err_proc_mult_codigo = '".$error_code."'
                AND err_proc_mult_cli_id = ".$cliente_id."
                AND archivos_importacion_arch_id = ".$arch_id;

        $res = $mdb2->query($sql);

        if (PEAR::isError($res)) {
            echo $sql;
            die($res->getMessage());
        }
    }
}
