<?php
	function reg_log($msg) {
		echo date('d/m/Y H:i:s - ',time()).$msg.'
';
	}
	
	function generarCortesEstimadosCT($arch_id,$cadelect_sem) {
		require_once('MDB2.php');
		require_once('DB/DataObject.php');
		define('DATAFILE', 'C:\xampp\htdocs\ocebaCalidad\config/data.ini');
		require_once('C:\xampp\htdocs\ocebaCalidad\config/data.config');
		require_once('C:\xampp\htdocs\ocebaCalidad\dataObjects/Archivos_importacion_log.php');
		
		reg_log('Inicio de la generacion de usuarios estimados');
		
		$config = PEAR::getStaticProperty("DB_DataObject",'options');
		$mdb2 =& MDB2::connect($config['database']);

		if (PEAR::isError($mdb2)) {
			die($mdb2->getMessage());
		}
		reg_log('Obteniendo datos de importación');
		$sql_mes = 'SELECT arch_emp_id FROM archivos_importacion WHERE arch_id = '.$arch_id.';';
		$res_mes = $mdb2->query($sql_mes);
		if ($mes = $res_mes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
			$emp = $mes['arch_emp_id'];
		}		
		
		//$do = DB_DataObject::factory('archivos_importacion');
		reg_log('Leyendo CT afectados');		
		$sql_ct = 'SELECT cortesxct_ct_id FROM cortes_por_ct WHERE cortesxct_arch_id = '.$arch_id.' group by cortesxct_ct_id;';		
		
		$res_ct = $mdb2->query($sql_ct);		
		if (PEAR::isError($res_ct)) {
			die($res_ct->getMessage());
		}
		while ($est = $res_ct->fetchRow(MDB2_FETCHMODE_ASSOC)) {
			$ct[$est['cortesxct_ct_id']] = $est['cortesxct_ct_id'];			
		}
		
		reg_log('Obteniendo cadena electrica');
		
		$sql_cad = 'SELECT cadelect_cli_id, cadelect_ct_id FROM cadena_electrica WHERE cadelect_sem_id = '.$cadelect_sem.' and cadelect_ct_id in ('.implode(',',$ct).');';	
		
		$res_cad = $mdb2->query($sql_cad);
		if (PEAR::isError($res_cad)) {
			die($res_cad->getMessage());
		}
		$j = 0;
		while ($est = $res_cad->fetchRow(MDB2_FETCHMODE_ASSOC)) {
			$cad[$est['cadelect_ct_id']][] = $est['cadelect_cli_id'];
			$j++;
		}	
		unset($ct);
		
		reg_log('Generando usuarios (Estimados: '.$j.')');
				
		$sql_ct = 'SELECT 
		cortesxct_ct_id,
		cortesxct_op_apertura,
		cortesxct_op_cierre,
		cortesxct_fecha_apertura,
		cortesxct_fecha_cierre,
		cortesxct_causa,		
		cortesxct_arch_id FROM cortes_por_ct WHERE cortesxct_arch_id = '.$arch_id.';';		
		
		$res_ct = $mdb2->query($sql_ct);		
		if (PEAR::isError($res_ct)) {
			die($res_ct->getMessage());
		}
		$ct = array();
		$i = 0;
		while ($est = $res_ct->fetchRow(MDB2_FETCHMODE_ASSOC)) {
			$clientes = ($cad[$est['cortesxct_ct_id']]) ? $cad[$est['cortesxct_ct_id']]: array();
			foreach ($clientes as $cli_id) {
				$ct[] = '('.
					$cadelect_sem.','.
					$cli_id.','.
					$est['cortesxct_ct_id'].','.
					$est['cortesxct_op_cierre'].','.
					$est['cortesxct_op_apertura'].','.
					'"'.$est['cortesxct_fecha_cierre'].'"'.','.
					'"'.$est['cortesxct_fecha_apertura'].'"'.','.
					'"'.$est['cortesxct_causa'].'"'.','.
					$est['cortesxct_arch_id'].')
					';
				if (count($ct) == 100000) {
					$i += count($ct);
					reg_log('Insertando 100000 registros en la BD');				
					$query = insertarRegistros($ct);					
					$res = $mdb2->query($query);
					
					if (PEAR::isError($res)) {
						die($res->getMessage());
					}
					reg_log('Total insertados '.$i);	
					$ct = array();
				}
			}
			unset($cad[$est['cortesxct_ct_id']]);
			unset($clientes);
		}
		if (count($ct)) {
			$i += count($ct);
			$query = insertarRegistros($ct);					
			$res = $mdb2->query($query);
			if (PEAR::isError($res)) {
				die($res->getMessage());
			}
			$ct = array();
		}
		reg_log('Generación finalizada cantidad de usuarios estimados '.$i);	
		$mdb2->disconnect();
	}
	function insertarRegistros($ct) {
		$query = 'INSERT INTO cortes_por_usuario_estimado (
	cortesusuaest_sem_id,
	cortesusuaest_cli_id,
	cortesusuaest_ct_id,
	cortesusuaest_op_cierre,
	cortesusuaest_op_apertura,
	cortesusuaest_fecha_cierre,
	cortesusuaest_fecha_apertura,
	cortesusuaest_causa,
	cortesusuaest_arch_id) values ';
		
		$query .= implode(',',$ct);		
		$query .= ';';		
		return $query;
		unset($query);
		exit;
	}
?>