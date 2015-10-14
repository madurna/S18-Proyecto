<?php
require_once(INC_PATH.'/funciones/function.generarCortesEstimadosCT.php');
/**
 * Devuelve la energía no suministrada a un cliente usuario o ct en el semenstre dado
 * @param <int> $minimoMinutos
 * @param <int> $minimoHoras
 * @param <int> $sem_id
 * @param <int> $emp_id
 * @param <int> $tipo_distribuidora_id
 * @param <int> $zona_id
 * @param <int> $cliente_id
 * @return <array> Energia no suministrada
 */
define('CANTCLIENTES',50000);
define('COMMITSQL',50000);
define('PROCESAR',1);
 
function cargarCortesEstimados( 
    $sem_id = 0,
    $tipo_distribuidora_id = 0,
    $arch_id = 0,
    $cts = null,
    $clientes = null,
    $mdb2 = null
)
{

    $semestre_a_calcular = 0;

    if(PROCESAR){
		echo_debug('Obteniendo Cadena electrica del semestre con id('.$sem_id.')');
        //Tengo que buscar el semestre actual y sino traer el anterior
        
	    $sql_mes = 'SELECT arch_emp_id
	                FROM archivos_importacion
	                WHERE arch_id = '.$arch_id.';';
	    $res_mes = $mdb2->query($sql_mes);
	
	    if (PEAR::isError($res_mes)) {
	        echo $sql_mes;
	        die($res_mes->getMessage());
	    }	
	
	    $mes = $res_mes->fetchRow(MDB2_FETCHMODE_ASSOC);
	    if ($mes) {
	        $emp_id = $mes['arch_emp_id'];
	    }
		
		$sql = "SELECT cadena_electrica.cadelect_sem_id
                FROM cadena_electrica INNER JOIN centros_de_transformacion ON cadelect_ct_id = ct_id
                WHERE 
                ct_emp_id = $emp_id AND
                cadena_electrica.cadelect_sem_id = ".$sem_id;

        $res_sem = $mdb2->query($sql);

        if (PEAR::isError($res_sem)) {
            echo $sql;
            die($res_sem->getMessage());
        }
	
        if($res_sem->numRows() == 0){
			echo_debug('Cadena no encontrada, obteniendo la ultima disponible');
            $sql = "SELECT sem_id
                    FROM semestres
                    INNER JOIN cadena_electrica ON (cadena_electrica.cadelect_sem_id=semestres.sem_id)
                    INNER JOIN centros_de_transformacion ON cadelect_ct_id = ct_id
                    WHERE (ct_emp_id = $emp_id)
                    GROUP BY sem_id
                    ORDER BY sem_nombre DESC
                    LIMIT 0,1";

            //$do_sem->query($sql);
            $res_sem = $mdb2->query($sql);
            //DB_DataObject::debugLevel(5);
            if (PEAR::isError($res_sem)) {
                echo $sql;
                die($res_sem->getMessage());
            }

            $do_sem = $res_sem->fetchRow(MDB2_FETCHMODE_ASSOC);
            $semestre_a_calcular = $do_sem['sem_id'];
        }
        else{
            $do_sem = $res_sem->fetchRow(MDB2_FETCHMODE_ASSOC);
            $semestre_a_calcular = $do_sem['cadelect_sem_id'];
        }
        
        if($semestre_a_calcular > 0){
        	
        	$res_sem_nom = $mdb2->query("SELECT sem_nombre
                FROM semestres
                WHERE sem_id = $semestre_a_calcular;");
    		$sem_nom = $res_sem_nom->fetchRow(MDB2_FETCHMODE_ASSOC);
    		$sem_nom = $sem_nom['sem_nombre'];
        	
	    	echo_debug('Generando Cortes estimados para la cadena del semestre nro '.$sem_nom);
            
	    	generarCortesEstimadosCT($arch_id, $semestre_a_calcular, $cts, $mdb2);
            //Para los usuarios que no tienen CT
            generarCortesEstimadosUsuariosSinCT($arch_id, $semestre_a_calcular, $clientes, $mdb2);
        }
	else
            echo_debug('Error al obtener el semestre');
    }

    return $semestre_a_calcular;
}
