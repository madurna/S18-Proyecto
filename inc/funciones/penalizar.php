<?php
function penalizar($interrupciones = array(),$energia_facturada = 0, $div = 1)
{
    
    
    $penaliza = array();

    if(is_array($interrupciones)){
        foreach($interrupciones as $int){
            set_time_limit(30);
            //$penaliza[] = ($int * $energia_facturada)/$div;
            $penaliza[] = round($int,REDONDEOPEN);
        }
		
        //Sum (duracion interrupcion en horas * coeficientes ki) * (energia facturada/4380)
         
        return array_sum($penaliza);
    }
    else {
        return 0;
    }
}

function penalizarToString($interrupciones = array(),$energia_facturada = 0, $div = 1)
{

	
    $penaliza = array();

    if(is_array($interrupciones)){

        foreach($interrupciones as $int){
            set_time_limit(30);
            $penaliza[] = round($int,REDONDEOPEN);
        }
    }
        return "(". implode(' + ',$penaliza).")";
}

function noPenalizarToString($interrupciones = array(),$energia_facturada = 0, $div = 1)
{

    if(!is_array($interrupciones)){
        return "(". $interrupciones .")";
    }
}

