<?php
/**
 * Table Definition for convenio_empresa
 */
require_once 'DB/DataObject.php';

class DataObjects_Convenio_empresa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'convenio_empresa';    // table name
    public $convenio_empresa_id;             // int(11)  not_null primary_key auto_increment group_by
    public $convenio_empresa_empresa_id;     // int(11)  not_null multiple_key group_by
    public $convenio_empresa_convenio_id;    // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Convenio_empresa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
