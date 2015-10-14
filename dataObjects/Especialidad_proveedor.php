<?php
/**
 * Table Definition for especialidad_proveedor
 */
require_once 'DB/DataObject.php';

class DataObjects_Especialidad_proveedor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'especialidad_proveedor';    // table name
    public $especialidad_proveedor_id;       // int(11)  not_null primary_key auto_increment group_by
    public $especialidad_proveedor_descripcion;    // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Especialidad_proveedor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
