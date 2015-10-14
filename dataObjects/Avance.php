<?php
/**
 * Table Definition for avance
 */
require_once 'DB/DataObject.php';

class DataObjects_Avance extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'avance';              // table name
    public $avance_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $avance_descripcion;              // varchar(200)  
    public $avance_fecha;                    // date(10)  not_null
    public $avance_porcentaje;               // float(12)  group_by
    public $avance_obra_civil_id;            // int(11)  not_null multiple_key group_by
    public $avance_estado_avance_id;         // int(11)  group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Avance',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
