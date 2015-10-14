<?php
/**
 * Table Definition for concepto
 */
require_once 'DB/DataObject.php';

class DataObjects_Concepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'concepto';            // table name
    public $concepto_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $concepto_codigo;                 // varchar(45)  not_null
    public $concepto_nombre;                 // varchar(200)  not_null
    public $concepto_tipo_concepto_id;       // int(11)  not_null multiple_key group_by
    public $concepto_baja;                   // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Concepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	public $fb_fieldLabels = array (
		'concepto_codigo' => 'C&oacute;digo de Concepto: ',
		'concepto_nombre' => 'Nombre de Concepto: ',
		'concepto_tipo_concepto_id' => 'Tipo de Concepto: '
    );
	
    // Esta función crea un vector con el nombre de las horas extras y
    // el ítem 'TODAS' al principio del arreglo.
    function get_horas_extras_todas(){
        $this -> orderby('concepto_codigo ASC');
        $this -> whereAdd("concepto_nombre like '%extras%'");
        $this ->find();
        $horas_extras['Todas'] = 'TODAS';      
        while($this->fetch()){
            $horas_extras[$this->concepto_id] = $this-> concepto_nombre;
        }
    return $horas_extras;
    }

}
