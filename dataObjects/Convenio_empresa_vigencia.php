<?php
/**
 * Table Definition for convenio_empresa_vigencia
 */
require_once 'DB/DataObject.php';

class DataObjects_Convenio_empresa_vigencia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'convenio_empresa_vigencia';    // table name
    public $conv_emp_vigencia_id;            // int(11)  not_null primary_key auto_increment group_by
    public $conv_emp_vigencia_conv_emp_id;    // int(11)  not_null multiple_key group_by
    public $conv_emp_vigencia_fecha_desde;    // date(10)  not_null
    public $conv_emp_vigencia_fecha_hasta;    // date(10)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Convenio_empresa_vigencia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
