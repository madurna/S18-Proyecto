<?php
/**
 * Table Definition for reparticion
 */
require_once 'DB/DataObject.php';

class DataObjects_Reparticion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'reparticion';         // table name
    public $reparticion_id;                  // int(11)  not_null primary_key auto_increment group_by
    public $reparticion_descripcion;         // varchar(254)  not_null
    public $reparticion_fecha_cobro;         // blob(-1)  not_null blob
    public $reparticion_baja;                // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Reparticion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
