<?php
/**
 * Table Definition for asiento_empresa
 */
require_once 'DB/DataObject.php';

class DataObjects_Asiento_empresa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'asiento_empresa';     // table name
    public $asiento_empresa_id;              // int(11)  not_null primary_key auto_increment group_by
    public $asiento_empresa_numero_cuenta;    // int(255)  not_null group_by
    public $asiento_empresa_empresa_id;      // int(11)  not_null multiple_key group_by
    public $asiento_empresa_baja;            // tinyint(4)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Asiento_empresa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
