<?php
/**
 * Me da los valores confirmados
 * @param <array> $session
 */
function confirmados($session = array())
{
    $sorteos = array();
    foreach($session as $key => $val){
        if($val == 1){
            $sorteos[$key] = $val;

        }
    }

    return $sorteos;

}