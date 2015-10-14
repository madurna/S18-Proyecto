<?php
/**
 * Table Definition for adicional_general_convenio_empresa_vigencia
 */
require_once 'DB/DataObject.php';

class DataObjects_Adicional_general_convenio_empresa_vigencia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'adicional_general_convenio_empresa_vigencia';    // table name
    public $adicional_general_conv_emp_vig_id;    // int(11)  not_null primary_key auto_increment group_by
    public $adicional_general_conv_emp_vig_nombre;    // varchar(200)  not_null
    public $adicional_general_conv_emp_vig_conv_emp_vig_id;    // int(11)  not_null multiple_key group_by
    public $adicional_general_conv_emp_vig_monto;    // decimal(13)  not_null
    public $adicional_general_conv_emp_vig_baja;    // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Adicional_general_convenio_empresa_vigencia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
