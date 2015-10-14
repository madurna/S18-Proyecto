<?php
/**
 * Table Definition for comercializador
 */
require_once 'DB/DataObject.php';

class DataObjects_Comercializador extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'comercializador';     // table name
    public $comercializador_id;              // int(11)  not_null primary_key auto_increment group_by
    public $comercializador_tipo_dni;        // int(11)  not_null group_by
    public $comercializador_dni;             // int(8)  not_null group_by
    public $comercializador_nombre;          // varchar(50)  not_null
    public $comercializador_apellido;        // varchar(50)  not_null
    public $comercializador_localidad;       // int(11)  group_by
    public $comercializador_provincia;       // int(11)  group_by
    public $comercializador_direccion;       // varchar(255)  not_null
    public $comercializador_celular;         // varchar(50)  not_null
    public $comercializador_telefono_privado;    // varchar(50)  not_null
    public $comercializador_telefono_laboral;    // varchar(50)  
    public $comercializador_fecha_inicio;    // date(10)  not_null
    public $comercializador_porcentaje;      // float(5)  group_by
    public $comercializador_email;           // varchar(100)  
    public $comercializador_convenio;        // int(1)  group_by
    public $comercializador_datos_cuenta;    // varchar(255)  
    public $comercializador_baja;            // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Comercializador',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
