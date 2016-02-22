<?php
/**
 * Table Definition for proveedor
 */
require_once 'DB/DataObject.php';

class DataObjects_Proveedor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'proveedor';           // table name
    public $proveedor_id;                   // int(11) not_null primary_key auto_increment group_by
    public $proveedor_apellido;             // varchar(255) not_null
    public $proveedor_nombre;               // varchar(255) not_null
    public $proveedor_nro_doc;              // int(11) not_null group_by
    public $proveedor_direccion;            // varchar(255)
    public $proveedor_localidad_id;         // int(11) not_null multiple_key group_by
    public $proveedor_CP;                   // varchar(255)
    public $proveedor_CUIL;                 // varchar(255)
    public $proveedor_cuenta_bancaria;      // varchar(255)
    public $proveedor_CBU;                  // varchar(255)
    public $proveedor_fecha_inicio;         // date(10)
    public $proveedor_telefono;             // varchar(255)
    public $proveedor_tel_fijo_celular;     // varchar(255)
    public $proveedor_tel_laboral1;         // varchar(255)
    public $proveedor_tel_laboral2;         // varchar(255)
    public $proveedor_referido1;            // varchar(255)
    public $proveedor_referido2;            // varchar(255)
    public $proveedor_estado_id;            // varchar(255) not_null
    public $proveedor_fecha_nacimiento;     // date(10)
    public $proveedor_especialidad_proveedor_id;   // int(11) multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
