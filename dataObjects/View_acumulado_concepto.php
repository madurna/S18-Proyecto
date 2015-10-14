<?php
/**
 * Table Definition for view_acumulado_concepto
 */
require_once 'DB/DataObject.php';

class DataObjects_View_acumulado_concepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'view_acumulado_concepto';    // table name
    public $detalle_liquidacion_id;          // int(11)  not_null primary_key auto_increment group_by
    public $detalle_liquidacion_concepto_id;    // int(11)  not_null multiple_key group_by
    public $detalle_liquidacion_cantidad;    // decimal(22)  
    public $detalle_liquidacion_monto;       // decimal(22)  not_null
    public $liquidacion_mes;                 // int(11)  not_null group_by
    public $liquidacion_id;                  // int(11)  not_null primary_key auto_increment group_by
    public $liquidacion_anio;                // int(11)  not_null group_by
    public $liquidacion_estado_id;           // int(11)  not_null multiple_key group_by
    public $empresa_id;                      // int(11)  not_null primary_key auto_increment group_by
    public $empresa_nombre;                  // varchar(200)  not_null
    public $maestro_concepto_id;             // int(11)  not_null primary_key auto_increment group_by
    public $maestro_concepto_codigo;         // varchar(45)  not_null
    public $maestro_concepto_nombre;         // varchar(250)  not_null
    public $maestro_concepto_vigencia;       // tinyint(1)  not_null group_by
    public $concepto_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $concepto_codigo;                 // varchar(45)  not_null
    public $concepto_nombre;                 // varchar(200)  not_null
    public $maestro_concepto_empresa_id;     // int(11)  not_null multiple_key group_by
    public $concepto_tipo_concepto_id;       // int(11)  not_null multiple_key group_by
    public $liquidacion_empresa_id;          // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_View_acumulado_concepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
