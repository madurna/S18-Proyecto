<?php
/**
 * Table Definition for estado
 */
require_once 'DB/DataObject.php';

class DataObjects_Estado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estado';              // table name
    public $estado_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $estado_descripcion;              // varchar(200)  not_null
    public $estado_baja;                     // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    public $fb_linkDisplayFields = array('estado_descripcion');
}