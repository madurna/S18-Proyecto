<?php
/**
 * Table Definition for estado_liquidacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Estado_liquidacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estado_liquidacion';    // table name
    public $estado_id;                       // int(11)  not_null primary_key group_by
    public $estado_nombre;                   // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estado_liquidacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
