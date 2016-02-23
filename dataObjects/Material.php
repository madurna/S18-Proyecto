<?php
/**
 * Table Definition for material
 */
require_once 'DB/DataObject.php';

class DataObjects_Material extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'material';            // table name
    public $material_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $material_nombre;                 // varchar(45)  not_null
    public $material_descripcion;            // varchar(200)  not_null
    public $material_codigo;                 // int(11)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
