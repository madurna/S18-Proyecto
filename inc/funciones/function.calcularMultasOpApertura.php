<?php
/**
 * Calculo la multa para los clientes penalizados
 * 
 * $penaliza = Clientes penalizados
 * $mdb2 = null
 * */

function calcularMultasOpApertura($penaliza, $mdb2 = null)
{
	
            //Traigo el valor de las tarifas
            $sql = "SELECT * FROM costo_energia_no_suministrada";
            $res = $mdb2->query($sql);

            $costos_energia_no_suministrada = array();


            while($do = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
                $costos_energia_no_suministrada[$do['cens_tarifa_id']] = $do['cens_valor'];
            }

            $res->free();

            //Sumo las multas de ese usuario
            $multas_calculadas = array();

            foreach($penaliza as $key => $pen){
				
                //Busco el valor de la multa segun
                if($pen['energia_no_suministrada'] != 0){
                    $penaliza[$key]['multa_usuario'] = $pen['energia_no_suministrada'];
                    $penaliza[$key]['multa_usuario_formula'] = $pen['energia_no_suministrada'];
                }
                else{
                    $penaliza[$key]['multa_usuario'] = 0;
                    $penaliza[$key]['multa_usuario_formula'] = 0;
                }

                //$penaliza[$key]['energia_no_suministrada_total'] = $penaliza[$key]['interrupcion'] * ($penaliza[$key]['energia_facturada']/4380);

                $multas_calculadas[$pen['cli_id']]['tarifa_id'] = $penaliza[$key]['tarifa_id'];
                
                $multas_calculadas[$pen['cli_id']]['duracion'] = $penaliza[$key]['duracion'];
                $multas_calculadas[$pen['cli_id']]['frecuencia'] = $penaliza[$key]['frecuencia'];
                $multas_calculadas[$pen['cli_id']]['emp_nombre'] = $penaliza[$key]['emp_nombre'];
                $multas_calculadas[$pen['cli_id']]['suc_nombre'] = $penaliza[$key]['suc_nombre'];
                $multas_calculadas[$pen['cli_id']]['cod_suministro'] = $penaliza[$key]['cod_suministro'];
                $multas_calculadas[$pen['cli_id']]['cli_nombre'] = $penaliza[$key]['cli_nombre'];
                $multas_calculadas[$pen['cli_id']]['suc_id'] = $penaliza[$key]['suc_id'];
                $multas_calculadas[$pen['cli_id']]['emp_id'] = $penaliza[$key]['emp_id'];
                
                $multas_calculadas[$pen['cli_id']]['cli_id'] = $penaliza[$key]['cli_id'];
                $multas_calculadas[$pen['cli_id']]['op_apertura'] = $penaliza[$key]['op_apertura'];
                //$multas_calculadas[$pen['cli_id']]['arch_id'] = $arch_id;
                //$multas_calculadas[$pen['cli_id']]['arch_linea'] = $penaliza[$key]['arch_linea'];
                
                $multas_calculadas[$pen['cli_id']]['frecuencia'] = $penaliza[$key]['frecuencia'];;

                if($_SESSION['duracion'][$pen['cli_id']] > 0)
                    $multas_calculadas[$pen['cli_id']]['duracion'] = 1;
                    
                $multas_calculadas[$pen['cli_id']]['numero_corte'] = $penaliza[$key]['numero_corte'];
                $multas_calculadas[$pen['cli_id']]['sem_id'] = $penaliza[$key]['sem_id'];
                $multas_calculadas[$pen['cli_id']]['energia_facturada'] = $penaliza[$key]['energia_facturada'];
                $multas_calculadas[$pen['cli_id']]['energia_no_suministrada'] += $penaliza[$key]['energia_no_suministrada'];
                $multas_calculadas[$pen['cli_id']]['multa_calculada'] += round($penaliza[$key]['multa_usuario'],REDONDEOFORM);
                $multas_calculadas[$pen['cli_id']]['multa_calculada_formula'][] = round($penaliza[$key]['multa_usuario_formula'],REDONDEOFORM);
                $multas_calculadas[$pen['cli_id']]['interrupcion_formula'][] = $penaliza[$key]['interrupcion_formula'];
                
                $multas_calculadas[$pen['cli_id']]['energia_no_suministrada_total'] += $penaliza[$key]['energia_no_suministrada_total'];

                if($penaliza[$key]['energia_no_suministrada_total_formula'] != null)                    
                    $multas_calculadas[$pen['cli_id']]['energia_no_suministrada_total_formula'][] = $penaliza[$key]['energia_no_suministrada_total_formula'];
            
                if($penaliza[$key]['energia_no_suministrada_formula'] != null)
                    $multas_calculadas[$pen['cli_id']]['energia_no_suministrada_formula'][] = $penaliza[$key]['energia_no_suministrada_formula'];                    
                
            }

            unset($penaliza);
            $penaliza = array();
            $multa_usuario_formula = null;
            $interrupcion_formula = null;

            //Recorro penaliza para acumular las multas
            $key = 0;
            foreach($multas_calculadas as $key => $pen){
                //$total_energ_no_sum = array_sum($pen['multa_calculada_formula']);
                $multa_usuario_formula = '('.implode('+',$pen['multa_calculada_formula']).") * ".$costos_energia_no_suministrada[$pen['tarifa_id']];
                //$multa_usuario_formula = '('.round($total_energ_no_sum,4).") * ".$costos_energia_no_suministrada[$pen['tarifa_id']];
                $interrupcion_formula = '('.implode(')+(',$pen['interrupcion_formula']).')';

                if($pen['energia_no_suministrada_total_formula'] != '')
                    $energia_no_suministrada_total_formula = '('.implode('+',$pen['energia_no_suministrada_total_formula']).') * '.round($pen['energia_facturada']).'/4380';
                else
                    $energia_no_suministrada_total_formula = '';
                    
                if($pen['energia_no_suministrada_formula'] != '')
                    $energia_no_suministrada_formula = '('.implode('+',$pen['energia_no_suministrada_formula']).') * '.round($pen['energia_facturada']).'/4380';
                else
                    $energia_no_suministrada_formula = '';
                    
                //Para el insert en la base
                $multas_por_usuario_calculada[$key]['emp_id'] = $pen['emp_id'];
                $multas_por_usuario_calculada[$key]['emp_nombre'] = $pen['emp_nombre'];
                $multas_por_usuario_calculada[$key]['op_apertura'] = $pen['op_apertura'];
                $multas_por_usuario_calculada[$key]['suc_nombre'] = $pen['suc_nombre'];
                $multas_por_usuario_calculada[$key]['cod_suministro'] = $pen['cod_suministro'];
                $multas_por_usuario_calculada[$key]['cli_nombre'] = $pen['cli_nombre'];
                $multas_por_usuario_calculada[$key]['sem_id'] = $pen['sem_id'];
                $multas_por_usuario_calculada[$key]['suc_id'] = $pen['suc_id'];
                $multas_por_usuario_calculada[$key]['cli_id'] = $pen['cli_id'];
                $multas_por_usuario_calculada[$key]['energia_facturada'] = round($pen['energia_facturada'],REDONDEOENFAC);
                $multas_por_usuario_calculada[$key]['energia_no_suministrada'] = round($pen['energia_no_suministrada'],REDONDEOENS);
                $multas_por_usuario_calculada[$key]['energia_no_suministrada_formula'] = str_replace('.',',',$energia_no_suministrada_formula);
                $multas_por_usuario_calculada[$key]['multa_calculada'] = round($pen['multa_calculada'] * $costos_energia_no_suministrada[$pen['tarifa_id']],REDONDEOMULTA);
                $multas_por_usuario_calculada[$key]['multa_calculada_formula'] = str_replace('.',',',$multa_usuario_formula);
                $multas_por_usuario_calculada[$key]['numero_corte'] = $pen['numero_corte'];
                $multas_por_usuario_calculada[$key]['frecuencia'] = intval($pen['frecuencia']);
                $multas_por_usuario_calculada[$key]['duracion'] = intval($pen['duracion']);
                $multas_por_usuario_calculada[$key]['interrupcion_formula'] = str_replace('.',',',$interrupcion_formula);
                $multas_por_usuario_calculada[$key]['energia_no_suministrada_total'] = round($pen['energia_no_suministrada_total'],REDONDEOENS);
                $multas_por_usuario_calculada[$key]['energia_no_suministrada_total_formula'] = str_replace('.',',',$energia_no_suministrada_formula);
				$key++;
                unset($_SESSION['frecuencia'][$pen['cli_id']]);
                unset($_SESSION['duracion'][$$pen['cli_id']]);
            }

			return $multas_por_usuario_calculada;
}
