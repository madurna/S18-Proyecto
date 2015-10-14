<?php
/**
 * Table Definition for especialidad_obrero
 */
require_once 'DB/DataObject.php';

class DataObjects_Especialidad_obrero extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'especialidad_obrero';    // table name
    public $especialidad_obrero_id;          // int(11)  not_null primary_key auto_increment group_by
    public $especialidad_obrero_descripcion;    // varchar(200)  not_null
    public $especialidad_obrero_nombre;      // varchar(45)  not_null
    public $especialidad_obrero_sueldo_basico;    // float(12)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Especialidad_obrero',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
