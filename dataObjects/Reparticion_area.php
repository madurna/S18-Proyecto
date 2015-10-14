<?php
/**
 * Table Definition for reparticion_area
 */
require_once 'DB/DataObject.php';

class DataObjects_Reparticion_area extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'reparticion_area';    // table name
    public $reparticion_area_id;             // int(11)  not_null primary_key auto_increment group_by
    public $reparticion_area_nombre;         // varchar(100)  
    public $reparticion_area_reparticion_id;    // int(11)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Reparticion_area',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
