<?php 
/**
 * Busca las multas declaradas que estan en la base para los clientes seleccionados
 * $lista_clientes = lista de clientes a buscar
 * $sem_id = id del semestre a buscar
 * */
function buscarMultasDeclaradas($lista_clientes = array(), $sem_id = 0, $mdb2 = null)
{
	//Busco
	$clientes = implode(",",$lista_clientes);
	$sql = "SELECT multasusua_cli_id, multasusua_enernosum_pen, multasusua_multa,
			IF(multasusuacalc_multa > 0,ABS((multasusua_multa-multasusuacalc_multa)/multasusuacalc_multa*100),NULL) as diferencia
			FROM multas_por_usuario
			INNER JOIN multas_por_usuario_calculada ON multasusuacalc_cli_id = multasusua_cli_id
		    WHERE multasusua_cli_id IN (".$clientes.")
			AND multasusua_sem_id = ".$sem_id;

    $res = $mdb2->query($sql);
	
    if (PEAR::isError($res)) {
		echo $sql;
		die($res->getMessage());
    }
    
    $multas_declaradas = array();
    while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$multas_declaradas[$do['multasusua_cli_id']]['multa_declarada'] = $do['multasusua_multa'];
		$multas_declaradas[$do['multasusua_cli_id']]['energia_no_suministrada_declarada'] = $do['multasusua_enernosum_pen'];
		$multas_declaradas[$do['multasusua_cli_id']]['diferencia'] = $do['diferencia'];
    }

	return $multas_declaradas;

}
