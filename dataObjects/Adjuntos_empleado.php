<?php
/**
 * Table Definition for adjuntos_empleado
 */
require_once 'DB/DataObject.php';

class DataObjects_Adjuntos_empleado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'adjuntos_empleado';    // table name
    public $adjuntos_empleado_id;            // int(11)  not_null primary_key auto_increment group_by
    public $adjuntos_empleado_tipo_adjunto_id;    // int(11)  group_by
    public $adjuntos_empleado_empleado_id;    // int(11)  multiple_key group_by
    public $adjuntos_empleado_direccion;     // varchar(300)  
    public $adjuntos_empleado_descripcion;    // varchar(300)  
    public $adjuntos_empleado_nombre;        // varchar(300)  

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
