<?php
/**
 * Table Definition for asiento_descripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Asiento_descripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'asiento_descripcion';    // table name
    public $asiento_descripcion_id;          // int(11)  not_null primary_key auto_increment group_by
    public $asiento_descripcion_nombre;      // varchar(255)  not_null
    public $asiento_baja;                    // tinyint(4)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Asiento_descripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
