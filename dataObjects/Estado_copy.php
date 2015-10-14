<?php
/**
 * Table Definition for estado_copy
 */
require_once 'DB/DataObject.php';

class DataObjects_Estado_copy extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estado_copy';         // table name
    public $estado_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $estado_descripcion;              // varchar(255)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estado_copy',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
