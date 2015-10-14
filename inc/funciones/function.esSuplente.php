<?php
/**
 * Me dice si es suplente o no
 * @param <integer> $key
 * @param <array> $usuarios
 */
function esSuplente($key = 0,$usuarios = array())
{
    if(in_array($key,$usuarios)){
        return 1;
    }
    else{
        return 0;
    }
}