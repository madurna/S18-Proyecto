<?php
/**
 * Table Definition for empleado
 */
require_once 'DB/DataObject.php';

class DataObjects_Empleado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'empleado';            // table name
    public $empleado_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $empleado_apellido;               // varchar(255)  not_null
    public $empleado_nombre;                 // varchar(255)  not_null
    public $empleado_tipo_doc_id;            // int(11)  not_null multiple_key group_by
    public $empleado_nro_doc;                // int(11)  not_null group_by
    public $empleado_direccion;              // varchar(255)  
    public $empleado_localidad_id;           // int(11)  not_null multiple_key group_by
    public $empleado_CP;                     // varchar(255)  
    public $empleado_CUIL;                   // varchar(255)  
    public $empleado_CBU;                    // varchar(255)  
    public $empleado_fecha_inicio;           // date(10)  
    public $empleado_telefono;               // varchar(255)  
    public $empleado_estado;                 // varchar(255)  
    public $empleado_fecha_nacimiento;       // date(10)  
    public $empleado_sector_id;              // int(11)  multiple_key group_by
    public $empleado_tarea_id;               // int(11)  multiple_key group_by
    public $empleado_capacitacion;           // varchar(45)  multiple_key
    public $empleado_sexo_id;                // int(11)  multiple_key group_by
    public $empleado_estado_civil_id;        // int(11)  multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
