<?php
function cmcBuscarClientes($cli_id = 0, $mdb2 = null)
{
    $sql = "SELECT *,
            TIMESTAMPDIFF(DAY, con_fecha_pago, con_fecha_conexion) AS cant_dias
            FROM conexiones c
            INNER JOIN clientes cl ON cl.cli_id = c.con_cli_id
            WHERE c.con_cli_id = ".$cli_id."
            AND (c.con_fecha_pago <> '0000-00-00 00:00:00' OR c.con_fecha_pago IS NOT NULL)";

    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo '<br />'.$sql.'<br />';
        die($res->getMessage());
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    return $row;
}
