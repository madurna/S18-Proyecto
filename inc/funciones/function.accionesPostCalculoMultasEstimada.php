<?php
function accionesPostCalculoMultasEstimada($arch_id = 0, $mdb2 = null)
{
    //Recorro las multas para mostrar info
    echo_debug("Procesando tareas post calculo de multas estimadas");
    $datos = array();
    //Total de multas
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_estimada";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Total de clientes con multas estimadas: ".$row['cantidad']."");
    $datos['errprocmult_cantmultasest'] = $row['cantidad'];

    //Multas distinto de cero
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_estimada
           WHERE multasusuaest_multa <> 0";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Clientes con multas estimadas distintas de cero: ".$row['cantidad']."");
    $datos['errprocmult_cmultasestnocero'] = $row['cantidad'];

    //Multas en cero
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_estimada
           WHERE multasusuaest_multa = 0";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Clientes con multas estimadas en cero: ".$row['cantidad']."");
    $datos['errprocmult_cmultasestcero'] = $row['cantidad'];

    //Clientes con energia no suministrada en cero
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_estimada
           WHERE multasusuaest_enernosum = 0";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Clientes con energia no suministrada en cero: ".$row['cantidad']."");
    $datos['errprocmult_cenernosumcalccero'] = $row['cantidad'];

    //Clientes con energia no suministrada distinto de cero
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_estimada
           WHERE multasusuaest_enernosum <> 0";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Clientes con energia no suministrada distinto de cero: ".$row['cantidad']."");
    $datos['errprocmult_cenernosumcalcnocero'] = $row['cantidad'];

    //Clientes con energia no suministrada distinto de cero
    $sql ="SELECT COUNT(*) AS cantidad
           FROM multas_por_usuario_estimada
           WHERE multasusuaest_enernosum <> 0
           AND multasusuaest_multa = 0";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Clientes con energia no suministrada distinto de cero y multa en cero: ".$row['cantidad']."");
    $datos['errprocmult_cenernosumnoceromultacero'] = $row['cantidad'];

    //Clientes con energia no suministrada distinto de cero
    $sql ="SELECT COUNT(*) AS cantidad
           FROM multas_por_usuario_estimada
           WHERE multasusuaest_enernosum = 0
           AND multasusuaest_multa <> 0";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Clientes con energia no suministrada en cero y multa distinto de cero: ".$row['cantidad']."");
    $datos['errprocmult_cenernosumceromultanocero'] = $row['cantidad'];

    if($row['cantidad']){
        echo_debug("Mostrando los : ".$row['cantidad']." registros");
        $sql ="SELECT * FROM multas_por_usuario_estimada
           WHERE multasusuaest_enernosum = 0
           AND multasusuaest_multa <> 0 LIMIT 100";
        $res = $mdb2->query($sql);

        if (PEAR::isError($res)) {
            echo_debug($res->getMessage());
			return false;
        }

        if(!PORCONSOLA){
            echo "<table border='1' cellspacing='1' cellpading='1'>";
            echo "<tr>";
                echo "<th>cli_id</th>";
                echo "<th>sem_id</th>";
                echo "<th>enerfacturada</th>";
                echo "<th>enernosum</th>";
                echo "<th>enernosum_formula</th>";
                echo "<th>multa</th>";
                echo "<th>multa_formula</th>";
                echo "<th>cant_cortes</th>";
                echo "<th>frecuencia</th>";
                echo "<th>duracion</th>";
                echo "<th>interrupcion_formula</th>";
            echo "</tr>";
            while($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                echo "<tr>";
                    echo "<td>".$row['multasusuaest_cli_id']."</td>";
                    echo "<td>".$row['multasusuaest_sem_id']."</td>";
                    echo "<td>".$row['multasusuaest_enerfacturada']."</td>";
                    echo "<td>".$row['multasusuaest_enernosum']."</td>";
                    echo "<td>".$row['multasusuaest_enernosum_formula']."</td>";
                    echo "<td>".$row['multasusuaest_multa']."</td>";
                    echo "<td>".$row['multasusuaest_multa_formula']."</td>";
                    echo "<td>".$row['multasusuaest_numero_corte']."</td>";
                    echo "<td>".$row['multasusuaest_frecuencia']."</td>";
                    echo "<td>".$row['multasusuaest_duracion']."</td>";
                    echo "<td>".$row['multasusuaest_interrup_formula']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo str_repeat("x",100);
            echo str_repeat("-",100);
            echo "|cli_id|";
            echo "|sem_id|";
            echo "|enerfacturada|";
            echo "|enernosum|";
            echo "|enernosum_formula|";
            echo "|multa|";
            echo "|multa_formula|";
            echo "|cant_cortes|";
            echo "|frecuencia|";
            echo "|duracion|";
            echo "|interrupcion_formula|";
            echo str_repeat("-",100);
            while($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                echo str_repeat("-",100);
                echo "|".$row['multasusuaest_cli_id']."|";
                echo "|".$row['multasusuaest_sem_id']."|";
                echo "|".$row['multasusuaest_enerfacturada']."|";
                echo "|".$row['multasusuaest_enernosum']."|";
                echo "|".$row['multasusuaest_enernosum_formula']."|";
                echo "|".$row['multasusuaest_multa']."|";
                echo "|".$row['multasusuaest_multa_formula']."|";
                echo "|".$row['multasusuaest_numero_corte']."|";
                echo "|".$row['multasusuaest_frecuencia']."|";
                echo "|".$row['multasusuaest_duracion']."|";
                echo "|".$row['multasusuaest_interrup_formula']."|";
                echo str_repeat("-",100);
            }
            echo str_repeat("x",100);
        }
    }
	return true;
}   