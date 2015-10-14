<?php
/**
 * Table Definition for maestro_asiento_concepto
 */
require_once 'DB/DataObject.php';

class DataObjects_Maestro_asiento_concepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'maestro_asiento_concepto';    // table name
    public $maestro_asiento_concepto_id;     // int(11)  not_null primary_key auto_increment group_by
    public $maestro_asiento_concepto_maestro_concepto_id;    // int(11)  not_null multiple_key group_by
    public $maestro_asiento_concepto_asiento_empresa_descipcion_id;    // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Maestro_asiento_concepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
