<?php
/**
 * Arma el numero de la secuencia
 * @param <integer> $secuencia
 * @param <integer> $digitos
 */
function secuencia($secuencia = 0,$digitos = 5)
{
    return str_pad($secuencia,$digitos,'0',STR_PAD_LEFT);
/*
    $tamano_cadena = strlen($secuencia);
    $pad = $digitos - $tamano_cadena;

    return substr_replace(str_repeat('0',$pad),$secuencia,$pad);
*/
}
