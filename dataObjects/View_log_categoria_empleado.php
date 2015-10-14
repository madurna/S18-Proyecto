<?php
/**
 * Table Definition for view_log_categoria_empleado
 */
require_once 'DB/DataObject.php';

class DataObjects_View_log_categoria_empleado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'view_log_categoria_empleado';    // table name
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
    public $empleado_nacionalidad_id;        // int(11)  not_null multiple_key group_by
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
    public $empleado_categoria_id;           // varchar(200)  
    public $log_categoria_empleado_id;       // int(11)  not_null primary_key auto_increment group_by
    public $log_categoria_empleado_categoria_anterior_id;    // varchar(200)  not_null
    public $log_categoria_empleado_anio;     // int(4)  not_null group_by
    public $log_categoria_empleado_mes;      // int(2)  not_null group_by
    public $log_categoria_empleado_empleado_id;    // int(11)  not_null group_by
    public $convenio_empresa_id;             // int(11)  not_null primary_key auto_increment group_by
    public $convenio_empresa_empresa_id;     // int(11)  not_null multiple_key group_by
    public $convenio_empresa_convenio_id;    // int(11)  not_null multiple_key group_by
    public $empleado_telefono;               // varchar(200)  
    public $empleado_celular;                // varchar(200)  
    public $empleado_mail;                   // varchar(200)  
    public $empleado_fuero_gremial;          // tinyint(1)  group_by
    public $empleado_baja;                   // tinyint(1)  group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_View_log_categoria_empleado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
