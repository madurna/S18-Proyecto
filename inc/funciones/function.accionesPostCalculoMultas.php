<?php
function accionesPostCalculoMultas($arch_id = 0, $mdb2 = null)
{
    //Recorro las multas para mostrar info
    echo_debug("Procesando tareas post calculo de multas ");
    $datos = array();
    //Total de multas
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_calculada";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Total de clientes con multas calculadas: ".$row['cantidad']."");
    $datos['errprocmult_cantmultascalc'] = $row['cantidad'];

    //Multas distinto de cero
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_calculada
           WHERE multasusuacalc_multa <> 0";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Clientes con multas calculadas distintas de cero: ".$row['cantidad']."");
    $datos['errprocmult_cmultascalcnocero'] = $row['cantidad'];

    //Multas en cero
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_calculada
           WHERE multasusuacalc_multa = 0";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Clientes con multas calculadas en cero: ".$row['cantidad']."");
    $datos['errprocmult_cmultascalccero'] = $row['cantidad'];

    //Clientes con energia no suministrada en cero
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_calculada
           WHERE multasusuacalc_enernosum = 0";
    $res = $mdb2->query($sql);

    if (PEAR::isError($res)) {
        echo_debug($res->getMessage());
		return false;
    }

    $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
    echo_debug("Clientes con energia no suministrada en cero: ".$row['cantidad']."");
    $datos['errprocmult_cenernosumcalccero'] = $row['cantidad'];

    //Clientes con energia no suministrada distinto de cero
    $sql ="SELECT COUNT(*) AS cantidad FROM multas_por_usuario_calculada
           WHERE multasusuacalc_enernosum <> 0";
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
           FROM multas_por_usuario_calculada
           WHERE multasusuacalc_enernosum <> 0
           AND multasusuacalc_multa = 0";
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
           FROM multas_por_usuario_calculada
           WHERE multasusuacalc_enernosum = 0
           AND multasusuacalc_multa <> 0";
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
        $sql ="SELECT * FROM multas_por_usuario_calculada
           WHERE multasusuacalc_enernosum = 0
           AND multasusuacalc_multa <> 0 LIMIT 100";
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
                    echo "<td>".$row['multasusuacalc_cli_id']."</td>";
                    echo "<td>".$row['multasusuacalc_sem_id']."</td>";
                    echo "<td>".$row['multasusuacalc_enerfacturada']."</td>";
                    echo "<td>".$row['multasusuacalc_enernosum']."</td>";
                    echo "<td>".$row['multasusuacalc_enernosum_formula']."</td>";
                    echo "<td>".$row['multasusuacalc_multa']."</td>";
                    echo "<td>".$row['multasusuacalc_multa_formula']."</td>";
                    echo "<td>".$row['multasusuacalc_numero_corte']."</td>";
                    echo "<td>".$row['multasusuacalc_frecuencia']."</td>";
                    echo "<td>".$row['multasusuacalc_duracion']."</td>";
                    echo "<td>".$row['multasusuacalc_interrup_formula']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo str_repeat("x",120);
            echo str_repeat("-",120);
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
            echo str_repeat("-",120);
            while($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                echo str_repeat("-",120);
                echo "|".$row['multasusuacalc_cli_id']."|";
                echo "|".$row['multasusuacalc_sem_id']."|";
                echo "|".$row['multasusuacalc_enerfacturada']."|";
                echo "|".$row['multasusuacalc_enernosum']."|";
                echo "|".$row['multasusuacalc_enernosum_formula']."|";
                echo "|".$row['multasusuacalc_multa']."|";
                echo "|".$row['multasusuacalc_multa_formula']."|";
                echo "|".$row['multasusuacalc_numero_corte']."|";
                echo "|".$row['multasusuacalc_frecuencia']."|";
                echo "|".$row['multasusuacalc_duracion']."|";
                echo "|".$row['multasusuacalc_interrup_formula']."|";
                echo str_repeat("-",120);
            }
            echo str_repeat("x",120);
        }
    }
	return true;
}   