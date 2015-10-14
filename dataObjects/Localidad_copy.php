<?php
/**
 * Table Definition for localidad_copy
 */
require_once 'DB/DataObject.php';

class DataObjects_Localidad_copy extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'localidad_copy';      // table name
    public $localidad_id;                    // int(11)  not_null primary_key auto_increment group_by
    public $localidad_nombre;                // varchar(200)  not_null
    public $localidad_codigo_postal;         // int(11)  not_null group_by
    public $localidad_provincia_id;          // int(11)  not_null multiple_key group_by
    public $localidad_baja;                  // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Localidad_copy',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
