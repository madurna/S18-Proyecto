<?php
ini_set("memory_limit","3072M");
//include('MDB2.php');
require_once(INC_PATH.'/funciones/function.cmcBuscarClientes.php');
require_once(INC_PATH.'/funciones/function.cmcBuscarParametros.php');
require_once(INC_PATH.'/funciones/function.rangoFechas.php');
require_once(INC_PATH.'/funciones/function.rangoFechasHabiles.php');
require_once(INC_PATH.'/funciones/function.diasAComputar.php');

function calcularMultasConexionPorCliente($cliente_id = 0)
{
	//echo 'inicio'.microtime().'<br/>';
    define('PROCESAR',1); 
    //En la tabla de conexiones - sistema   
    $cli_id = $cliente_id['record']['cli_id'];
    //Prueba en conexiones
    //$cli_id = $cliente_id;

    $mdb2 =& $_SESSION['MDB2_Conexiones'];
	
    if (PEAR::isError($mdb2)) {
        die($mdb2->getMessage());
    }
	//echo 'calculo'.microtime().'<br/>';
    
    if(PROCESAR){
        $multa_calculada = 0;
        // 1) Buscar los clientes que tengan una solicitud y que hayan pagado,
        //    con los datos de los parametros para realizar el calculo de multas
       
		//$datos_clientes = cmcBuscarClientes($cli_id,$mdb2);
        $datos_clientes = $cliente_id['record'];
		
		//echo 'cliente encontrado'.microtime().'<br/>';
    
        //Plazo estimado para cumplir con el reclamo
        $plazo_estimado = cmcBuscarParametros($datos_clientes['con_modred'],$datos_clientes['tarifa_nombre'], $datos_clientes['con_tipocon'],$mdb2);
        //Dias
        $rango_dias = rangoFechas(strtotime($datos_clientes['con_fecha_pago']),strtotime($datos_clientes['con_fecha_conexion']));
        
        //Dias habiles y no habiles
        $dias_habiles_no_habiles = rangoFechasHabiles($rango_dias);

        $dias = null;
        $meses = null;
        $anos = null;

        if(is_array($dias_habiles_no_habiles['habiles']['dias']))
            $dias = implode(',',$dias_habiles_no_habiles['habiles']['dias']);

        if(is_array($dias_habiles_no_habiles['habiles']['meses']))
            $meses = implode(',',$dias_habiles_no_habiles['habiles']['meses']);

        if(is_array($dias_habiles_no_habiles['habiles']['anos']))
            $anos = implode(',',$dias_habiles_no_habiles['habiles']['anos']);

        if(count($rango_dias) > 0){
			
/*			$fecha_inicio = '2010-08-31';
			$fecha_fin = '2010-09-23';
			$suc_id = null;
			$emp_id = 5;
			
			$cant_rango_dias_a_computar = diasAComputar($fecha_inicio,$fecha_fin,$suc_id,$emp_id);
			echo ($cant_rango_dias_a_computar);
			exit;
*/         
            //Busco si hay feriados
            $sql = "SELECT * FROM feriados_locales
                    WHERE ferloc_dia IN (".$dias.")
                    AND ferloc_mes IN (".$meses.")
                    AND (ferloc_ano IN (".$anos.") OR ferloc_ano IS NULL)";

            $sql .= " AND (";
            if($datos_clientes['cli_suc_id'] != null){
                $sql .= " ferloc_suc_id = ".$datos_clientes['cli_suc_id'];
            }
            else{
                $sql .= " ferloc_suc_id IS NULL";
            }

            $sql .= ") AND (";

            if($datos_clientes['cli_emp_id'] != null){
                $sql .= " ferloc_emp_id = ".$datos_clientes['cli_emp_id'];
            }
            else{
                $sql .= " ferloc_emp_id IS NULL";
            }

            $sql .= ")";
            
            $res = $mdb2->query($sql);

            if (PEAR::isError($res)) {
                echo $sql;
                die($res->getMessage());
            }

            
            //Saco los dias feriado que estan en la tabla
            if($res->numRows() > 0){
                //Saco estos dias de la lista
                while($fila = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                    $key = $fila['ferloc_mes'].$fila['ferloc_dia'];
                    unset($rango_dias[intval($key)]);
                }
            }

            if(isset($dias_habiles_no_habiles['no_habiles'])){
                //Saco los fines de semana
                foreach($dias_habiles_no_habiles['no_habiles'] as $key => $val){
                    unset($rango_dias[intval($key)]);
                }
            }
			$aux = ((count($rango_dias)) - $plazo_estimado);
            $dias_atraso = ($aux>0) ? $aux : 0;
			
            if (($dias_atraso > 0) & ($plazo_estimado > 0)){
                //Calcula multa
				$aux = ($datos_clientes['con_costocon'] / (2*$plazo_estimado)) * ($dias_atraso);
                $multa_calculada = ($aux > $datos_clientes['con_costocon']) ? $datos_clientes['con_costocon'] : $aux;
            }
        }
        
        //echo_debug('La multa de conexión por el cliente '.$cli_id.' para un atraso de '.$dias_atraso.' dias es: '.$multa_calculada);
        //echo microtime().'<br/>'.$multa_calculada;
		//exit;
		return $multa_calculada;
        // 5) Guardar los datos en alguna tabla, por ahora mostrar en esta tabla.
    }
}