<?php
function actualizarRegistros($ct_act) {

    $query = "";
    foreach($ct_act as $act) {
        $query .= "UPDATE cortes_por_usuario_estimado SET ".$act;
    }
    
    return $query;
    unset($query);
    exit;
}

function actualizarRegistrosUsuariosSinCT($cli) {
    $query = 'INSERT INTO cortes_por_usuario_estimado (
                cortesusuaest_sem_id,
                cortesusuaest_cli_id,
                cortesusuaest_ct_id,
                cortesusuaest_op_cierre,
                cortesusuaest_op_apertura,
                cortesusuaest_fecha_cierre,
                cortesusuaest_fecha_apertura,
                cortesusuaest_causa,
                cortesusuaest_arch_id,
		cortesusuaest_duracion) values ';

    $query .= implode(',',$cli);
    $query .= ';';
    
    return $query;
    unset($query);
    exit;
}
