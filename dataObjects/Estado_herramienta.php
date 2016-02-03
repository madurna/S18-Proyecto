<?php
/**
 * Table Definition for estado_herramienta
 */
require_once 'DB/DataObject.php';

class DataObjects_Estado_herramienta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estado_herramienta';    // table name
    public $estado_herramienta_id;           // int(11)  not_null primary_key auto_increment group_by
    public $estado_herramienta_descripcion;    // varchar(200)  not_null
    public $estado_herramienta_nombre;       // varchar(45)  not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
