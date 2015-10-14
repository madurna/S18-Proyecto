<?php 
/**
 * Filtro en el vector de multas el dato que me pide
 * 
 * $dato = Lo que quiero filtrar
 * $filtro = Que debo filtrar
 * $multas = Vector de multas
 * */
function filtrarMultasOpAp($dato = 0, $filtro = 'cod_suministro', $multas = array())
{
	switch($filtro){
		case 'cod_suministro': {			
					$multas_aux = $multas[$dato];
					unset($multas);
					$multas[$dato] = $multas_aux;
					unset($multas_aux);
					break;
				}
		case 'diferencia': {
					foreach($multas as $m){
						if(($m['diferencia'])*100 > $dato){
							$multas_aux[$m['cli_id']] = $m;
						}
					}
					
					$multas = $multas_aux;
					unset($multas_aux);
					break;
				}
		case 'multa': {
					foreach($multas as $m){						 
						if($m['multa_calculada'] > $dato){
							$multas_aux[$m['cli_id']] = $m;
						}
					}
					
					$multas = $multas_aux;
					unset($multas_aux);
					break;
				}
	}
	
	return $multas;
}
