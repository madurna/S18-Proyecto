<?php
/**
 * Table Definition for gasto_agrupamiento_gasto
 */
require_once 'DB/DataObject.php';

class DataObjects_Gasto_agrupamiento_gasto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'gasto_agrupamiento_gasto';    // table name
    public $gag_id;                          // int(11)  not_null primary_key auto_increment group_by
    public $gag_gasto_id;                    // int(11)  not_null multiple_key group_by
    public $gag_gasto_agrupamiento_id;       // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Gasto_agrupamiento_gasto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
