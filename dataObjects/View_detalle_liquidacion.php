<?php
/**
 * Table Definition for view_detalle_liquidacion
 */
require_once 'DB/DataObject.php';

class DataObjects_View_detalle_liquidacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'view_detalle_liquidacion';    // table name
    public $detalle_liquidacion_id;          // int(11)  not_null primary_key auto_increment group_by
    public $liquidacion_id;                  // int(11)  not_null primary_key auto_increment group_by
    public $detalle_liquidacion_concepto_id;    // int(11)  not_null multiple_key group_by
    public $detalle_liquidacion_cantidad;    // decimal(22)  
    public $detalle_liquidacion_monto;       // decimal(22)  not_null
    public $liquidacion_mes;                 // int(11)  not_null group_by
    public $liquidacion_anio;                // int(11)  not_null group_by
    public $liquidacion_estado_id;           // int(11)  not_null multiple_key group_by
    public $empresa_id;                      // int(11)  not_null primary_key auto_increment group_by
    public $empresa_nombre;                  // varchar(200)  not_null
    public $maestro_concepto_id;             // int(11)  not_null primary_key auto_increment group_by
    public $maestro_concepto_nombre;         // varchar(250)  not_null
    public $maestro_concepto_vigencia;       // tinyint(1)  not_null group_by
    public $maestro_concepto_codigo;         // varchar(45)  not_null
    public $concepto_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $concepto_codigo;                 // varchar(45)  not_null
    public $concepto_nombre;                 // varchar(200)  not_null
    public $tipo_concepto_id;                // int(11)  not_null primary_key auto_increment group_by
    public $tipo_concepto_nombre;            // varchar(100)  
    public $maestro_concepto_empresa_id;     // int(11)  not_null multiple_key group_by
    public $empleado_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $empleado_legajo;                 // varchar(100)  not_null
    public $empleado_nombre;                 // varchar(200)  not_null
    public $empleado_apellido;               // varchar(200)  not_null
    public $empleado_tipo_documento_id;      // int(11)  not_null multiple_key group_by
    public $empleado_numero_documento;       // int(11)  not_null group_by
    public $empleado_domicilio_calle;        // varchar(200)  not_null
    public $empleado_domicilio_numero;       // varchar(11)  not_null
    public $empleado_domicilio_piso;         // varchar(11)  not_null
    public $empleado_domicilio_departamento;    // varchar(11)  not_null
    public $empleado_domicilio_localidad_id;    // int(11)  not_null multiple_key group_by
    public $empleado_empresa_id;             // int(11)  not_null multiple_key group_by
    public $empleado_sexo_id;                // int(11)  not_null multiple_key group_by
    public $empleado_nacimiento_localidad_id;    // int(11)  not_null multiple_key group_by
    public $empleado_fecha_nacimiento;       // date(10)  not_null
    public $empleado_fecha_ingreso;          // date(10)  not_null
    public $empleado_fecha_antiguedad;       // date(10)  not_null
    public $empleado_estado_civil_id;        // int(11)  not_null multiple_key group_by
    public $empleado_ubicacion_laboral_id;    // int(11)  not_null group_by
    public $empleado_puesto_id;              // int(11)  not_null group_by
    public $empleado_convenio_id;            // int(11)  not_null multiple_key group_by
    public $empleado_cuil;                   // varchar(13)  not_null
    public $empleado_afiliado;               // tinyint(1)  not_null group_by
    public $empleado_estudio_id;             // int(11)  not_null multiple_key group_by
    public $concepto_tipo_concepto_id;       // int(11)  not_null multiple_key group_by
    public $convenio_empresa_id;             // int(11)  not_null primary_key auto_increment group_by
    public $convenio_empresa_empresa_id;     // int(11)  not_null multiple_key group_by
    public $convenio_empresa_convenio_id;    // int(11)  not_null multiple_key group_by
    public $empleado_categoria_id;           // varchar(200)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_View_detalle_liquidacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
