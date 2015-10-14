<?php
/**
 * Calcula la cantidad de dias quitando los feriados y fines de semana
 * locales a la empresa o nacionales.
 * Parametros
 * datetime $fecha_inicio
 * datetime $fecha_fin
 * integer $suc_id
 * integer $emp_id 
 * */
function diasAComputar($fecha_inicio = null, $fecha_fin = null, $suc_id = null, $emp_id = null)
{
		//Armo un vector con las fechas de inicio y fin
		$fechaIni = strtotime($fecha_inicio);
		$fechaFin = strtotime($fecha_fin);
				
		$rango_dias = array();
		for($i=$fechaIni; $i<=$fechaFin; $i+=86400){
			$rango_dias[intval(date("md", $i))] = date("Y-m-d", $i);
		}
		
		//Busco los dias habiles y no habiles
		$dias_habiles_no_habiles = array();

		foreach($rango_dias as $dia){
			$fecha = explode("-",$dia);
			$date = date('D', mktime(0,0,0,$fecha[1],$fecha[2],$fecha[0]));
			
			if($date == 'Sat' || $date == 'Sun'){
				$dias_habiles_no_habiles['no_habiles'][intval($fecha[1].$fecha[2])] = $dia;
			}
			else{
				$dias_habiles_no_habiles['habiles']['dias'][intval($fecha[2])] = intval($fecha[2]);
				$dias_habiles_no_habiles['habiles']['meses'][intval($fecha[1])] = intval($fecha[1]);
				$dias_habiles_no_habiles['habiles']['anos'][intval($fecha[0])] = intval($fecha[0]);
			}
		}

		//Separo los dias, meses y años para consultar los feriados
	    if(is_array($dias_habiles_no_habiles['habiles']['dias']))
            $dias = implode(',',$dias_habiles_no_habiles['habiles']['dias']);

        if(is_array($dias_habiles_no_habiles['habiles']['meses']))
            $meses = implode(',',$dias_habiles_no_habiles['habiles']['meses']);

        if(is_array($dias_habiles_no_habiles['habiles']['anos']))
            $anos = implode(',',$dias_habiles_no_habiles['habiles']['anos']);
            
        //Busco si hay feriados
        //DB_DataObject::debugLevel(3);
        $do = DB_DataObject::factory('feriados_locales');
        $sql = "SELECT * FROM feriados_locales
                 WHERE ferloc_dia IN (".$dias.")
                 AND ferloc_mes IN (".$meses.")
                 AND (ferloc_ano IN (".$anos.") OR ferloc_ano IS NULL)";

         $sql .= " AND (";
         if($suc_id != null){
            $sql .= " ferloc_suc_id = ".$suc_id;
         }
         else{
			$sql .= " ferloc_suc_id IS NULL";
         }

         $sql .= ") AND (";

         if($emp_id != null){
			$sql .= " ferloc_emp_id = ".$emp_id;
         }
         else{
			$sql .= " ferloc_emp_id IS NULL";
         }

         $sql .= ")";
            
		 $do->query($sql);
		 
         //Saco los dias feriado que estan en la tabla
		 while($do->fetch()){
			$key = $do->ferloc_mes.$do->ferloc_dia;
            unset($rango_dias[intval($key)]);
		 }

		 if(isset($dias_habiles_no_habiles['no_habiles'])){
			//Saco los fines de semana
            foreach($dias_habiles_no_habiles['no_habiles'] as $key => $val){
				unset($rango_dias[intval($key)]);
            }
         }

		//Retorno la cantidad de dias
        return count($rango_dias);
}
