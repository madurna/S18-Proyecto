<?php
/**
 * Table Definition for sucursal
 */
require_once 'DB/DataObject.php';

class DataObjects_Sucursal extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'sucursal';            // table name
    public $sucursal_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $sucursal_nombre;                 // varchar(50)  not_null
    public $sucursal_baja;                   // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sucursal',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
