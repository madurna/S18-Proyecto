<?php
/**
 * Devuelve dias de la semana en un lapso de tiempo.
 *
 * @param string    $email         Email address to validate
 * @param boolean   $domainCheck   Check if the domain exists
 */

function getDateLapsus($days, $fdate, $ldate = NULL)
{
		
        $startdate = strtotime($fdate);

        if ($ldate == NULL)
               $enddate = strtotime($fdate) + 60 * 60 * 24 * 60;
		//60 dias; a diferencia de los 2 meses de calendario de la otra forma
        $enddate = strtotime($ldate);
        $dias_esp = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');

        while ($startdate < $enddate) {
                if(in_array(date("w", $startdate), $days)) {
                        $dias[date("Y-m-d",$startdate)] = $dias_esp[date("w",$startdate)]." ".date("d-m-Y",$startdate);
                }
                $startdate += 60 * 60 * 24;
        }

        return $dias;

}
?>