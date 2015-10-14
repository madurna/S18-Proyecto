<?php
/**
 * Table Definition for view_estadistica_cantidad_empresa_convenio
 */
require_once 'DB/DataObject.php';

class DataObjects_View_estadistica_cantidad_empresa_convenio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'view_estadistica_cantidad_empresa_convenio';    // table name
    public $cantidad_empleados;              // bigint(21)  not_null group_by
    public $empleado_convenio_id;            // int(11)  not_null group_by
    public $empleado_empresa_id;             // int(11)  not_null group_by
    public $convenio_nombre;                 // varchar(200)  not_null
    public $convenio_id;                     // int(11)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_View_estadistica_cantidad_empresa_convenio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
