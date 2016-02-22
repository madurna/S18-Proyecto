<?php
/**
 * Table Definition for herramienta
 */
require_once 'DB/DataObject.php';

class DataObjects_Herramienta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'herramienta';         // table name
    public $herramienta_id;                 // int(11) not_null primary_key auto_increment group_by
    public $herramienta_descripcion;        // varchar(200) not_null
    public $herramienta_nombre;             // varchar(45) not_null
    public $herramienta_estado_herramienta_id;   // int(11) not_null multiple_key group_by
    public $herramienta_obra_yeseria_id;    // int(11) multiple_key group_by
    public $herramienta_obra_civil_id;      // int(11) multiple_key group_by
    public $herramienta_fecha_compra;       // date(10) not_null
    public $herramienta_fecha_ultima_reparacion;   // date(10) not_null
    public $herramienta_codigo;             // varchar(30) not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
