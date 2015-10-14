<?php
/**
 * Table Definition for avance_hito
 */
require_once 'DB/DataObject.php';

class DataObjects_Avance_hito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'avance_hito';         // table name
    public $id;                              // int(11)  not_null primary_key auto_increment group_by
    public $descripcion;                     // varchar(200)  not_null
    public $fecha;                           // datetime(19)  not_null
    public $estado;                          // int(11)  not_null multiple_key group_by
    public $avance;                          // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Avance_hito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
