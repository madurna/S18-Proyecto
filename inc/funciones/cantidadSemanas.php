<?php
function cantidadSemanas($fechaDesde = null, $fechaHasta = null)
{
    
 	return ceil((strtotime($fechaHasta) - strtotime($fechaDesde)) / (60 * 60 * 24 * 7)); 
	
	//return date("W",strtotime($fechaHasta))-date("W",strtotime($fechaDesde));
}