<?php
ini_set('memory_limit','130M');

	function reg_log_comp($msg) {
		echo date('d/m/Y H:i:s - ',time()).$msg.'
';
	}
	
	function compararCortesEstimadosCT($arch_id) {
		define('LOTES_CT',10);
		require_once('MDB2.php');
		require_once('DB/DataObject.php');
		define('DATAFILE', '/var/www/ocebaCalidadTest/config/data.ini');
		require_once('/var/www/ocebaCalidadTest/config/data.config');
		require_once('/var/www/ocebaCalidadTest/dataObjects/Archivos_importacion_log.php');
		
		reg_log_comp('Inicio de la comparacion');
		
		$config = PEAR::getStaticProperty("DB_DataObject",'options');
		$mdb2 =& MDB2::connect($config['database']);

		if (PEAR::isError($mdb2)) {
			reg_log_comp('Error: '.$mdb2->getMessage());
			return false;
		}
		reg_log_comp('Consultando datos de importacion para el archivo '.$arch_id);
		$sql_mes = 'SELECT arch_semestre, arch_emp_id FROM archivos_importacion	WHERE arch_id = '.$arch_id.';';
		$res_mes = $mdb2->query($sql_mes);
		if ($mes = $res_mes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
			$emp = $mes['arch_emp_id'];
			$sem = $mes['arch_semestre'];
		}	
		$res_mes->free();
		

		 reg_log_comp('Comprobando cortes declarados para el semestre (id: '.$sem.')');
	       $sql_dec = 'SELECT count(*) as cantidad FROM cortes_por_usuario INNER JOIN clientes ON cli_id = cortesusua_cli_id

                        WHERE cortesusua_sem_id = '.$sem.'
                        AND cli_emp_id = '.$emp.';';
                $res_dec = $mdb2->query($sql_dec);
                if (PEAR::isError($res_dec)) {
                        reg_log_comp('Error: '.$res_est->getMessage());
                        return false;
                }
                $c = 0;
               $j = $res_dec->fetchRow(MDB2_FETCHMODE_ASSOC);
		if ($j['cantidad'] == 0) {
                        //DataObjects_Archivos_importacion_log::registrarError($arch_id,'-1','No se han encontrado cortes estimados registrados',0);
                        reg_log_comp('Error: '.'No se han encontrado cortes declarados registrados');
                        return false;
			exit;
                }
		reg_log_comp('Total de cortes encontrados: '.$j['cantidad']);

		reg_log_comp('Obteniendo cortes estimados para el semestre (id: '.$sem.')');		
		$sql_est = 'SELECT cortesusuaest_id,cortesusuaest_op_apertura, cortesusuaest_cli_id, cortesusuaest_duracion 
			FROM cortes_por_usuario_estimado INNER JOIN clientes ON cli_id = cortesusuaest_cli_id			
			WHERE cortesusuaest_sem_id = '.$sem.'
			AND cli_emp_id = '.$emp.'			
			order by cortesusuaest_op_apertura;';
		$res_est = $mdb2->query($sql_est);		
		if (PEAR::isError($res_est)) {
			reg_log_comp('Error en la obtencion de los cortes estimados: '.$res_est->getMessage());
			return false;
		}		
		$c = 0;
		$i = $res_est->numRows();
		if ($i == 0) {
			//DataObjects_Archivos_importacion_log::registrarError($arch_id,'-1','No se han encontrado cortes estimados registrados',0);
			reg_log_comp('Error: '.'No se han encontrado cortes estimados registrados');
			return false;
		}
		else {
			
			reg_log_comp('Total estimados obtenidos: '.$i);		
			$op_actual = false;
			$datos = array();
			$j = 0;
			$y = 0;
			reg_log_comp('Comienzo de comparacion');
			while ($est = $res_est->fetchRow(MDB2_FETCHMODE_ASSOC)) {				
				$y++;
				$cli = $est['cortesusuaest_cli_id'];
				$op = $est['cortesusuaest_op_apertura'];
				$datos[$op][$cli]['est'] = $est['cortesusuaest_id'];		
				$datos[$op][$cli]['est_dur'] = $est['cortesusuaest_duracion'];		
				if ($op_actual != $op) {
					$op_actual = $op;
					//echo '.';
					if (count($datos) == LOTES_CT) {						
						/*echo '
';*/
						reg_log_comp('Procesando '.$y.' clientes estimados');				
						$j += compararCortes($emp,$sem,&$datos,$mdb2);
						$y = 0;
						unset($datos);
						$datos = array();
						reg_log_comp('Siguiente Lote de comparacion');				
					}				
				}											
			}
			$res_est->free();
			if (count($datos)) {
//				echo '
//';
				reg_log_comp('Procesando '.$y.' clientes estimados');				
				$j += compararCortes($emp,$sem,&$datos,$mdb2);
				unset($datos);
				$datos = array();
//				reg_log_comp('Siguiente Lote de comparacion');		
			}
			reg_log_comp('Total obtenidos: '.$j);		
		}	
		reg_log_comp('Fin de comparacion');
		$mdb2->disconnect();
		exit;
	}
	
	function compararCortes($emp,$sem,&$datos,$mdb2) {
		reg_log_comp('Obteniendo cortes declarados para el semestre '.$sem);		
		$sql_dec = 'SELECT cortesusua_id, cortesusua_cli_id,cortesusua_op_apertura,cortesusua_duracion FROM cortes_por_usuario WHERE cortesusua_sem_id = '.$sem.' and cortesusua_op_apertura in ('.implode(',',array_keys($datos)).');';		
		$res_dec = $mdb2->query($sql_dec);
		if (PEAR::isError($res_dec)) {
			reg_log_comp('Error obteniendo cortes declarados para el lote: '.$res_dec->getMessage());
			return false;
		}		
		$i = $res_dec->numRows();
		
		// ($i > 0) {	
			reg_log_comp('Procesando '.$i.' registros de cortes declarados');		
			$cli_ids = array();	
			while ($est = $res_dec->fetchRow(MDB2_FETCHMODE_ASSOC)) {
				//echo '.';					
				$cli = $est['cortesusua_cli_id'];
				$op = $est['cortesusua_op_apertura'];
				
				$cli_ids[$cli] = $cli;				
		
				if (($datos[$op][$cli]['est']) and ((int)$datos[$op][$cli]['est_dur'] != (int)$est['cortesusua_duracion'])) {
					$datos[$op][$cli]['dec'] = $est['cortesusua_id'];
				}
				else {
					unset($datos[$op][$cli]);
				}					
			}
			if (count($cli_ids)) {
				reg_log_comp('Limpiando comparaciones anteriores del semestre');		
				$query = 'delete from cortes_comparacion where cortescomp_sem_id = '.$sem.' and  cortescomp_emp_id = '.$emp.' and  cortescomp_cli_id in ('.implode(',',$cli_ids).')';
				$res = $mdb2->query($query);					
				if (PEAR::isError($res)) {
					reg_log_comp('Error eliminando comparaciones antiguas: '.$res->getMessage());
					return false;
				}
			}
			
			/*echo '
';				*/	
			$j = insertarComparacion($emp,$sem,&$datos,$mdb2);
		/*
		else {
			reg_log_comp('Sin coincidencias');		
		}*/
		return $j;		
		exit;
	}
	
	function insertarComparacion($emp,$sem,&$datos,$mdb2) {
		reg_log_comp('Procesando lote');	
		foreach ($datos as $op => $clientesComp) {
			foreach ($clientesComp as $cli_id => $fila) {
				$cliente_dec = ($fila['dec']) ? $fila['dec'] : 'null';
				$lista[] = '('.$sem.','.$emp.','.$cli_id.','.$fila['est'].','.$cliente_dec.',"'.date('Y-m-d H:i:s',time()).'")';
			}
		}			
		$x = count($lista);
		reg_log_comp('Insertando '.$x.' filas de comparacion en la BD');			
		
		$query = 'INSERT INTO cortes_comparacion (
	cortescomp_sem_id,
	cortescomp_emp_id,
	cortescomp_cli_id,
	cortescomp_cortesusuaest_id,
	cortescomp_cortesusua_id,
	cortescomp_fecha) values '.implode(',
',$lista).';';	
		
		$res = $mdb2->query($query);					
		if (PEAR::isError($res)) {
			reg_log_comp('Error en la insercion de comparaciones: '.$res->getMessage());
			return false;
		}
		
		$res->free();
		unset($lista);
		unset($query);		
		return $x;		
	}	
	//generarCortesEstimadosCT(15,25);
	//compararCortesEstimadosCT(17);
?>
