<?php
/**
 * Table Definition for maestro_concepto
 */
require_once 'DB/DataObject.php';

class DataObjects_Maestro_concepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'maestro_concepto';    // table name
    public $maestro_concepto_id;             // int(11)  not_null primary_key auto_increment group_by
    public $maestro_concepto_codigo;         // varchar(45)  not_null
    public $maestro_concepto_nombre;         // varchar(250)  not_null
    public $maestro_concepto_concepto_id;    // int(11)  not_null multiple_key group_by
    public $maestro_concepto_empresa_id;     // int(11)  not_null multiple_key group_by
    public $maestro_concepto_vigencia;       // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Maestro_concepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
