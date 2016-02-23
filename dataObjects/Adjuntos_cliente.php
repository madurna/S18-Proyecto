<?php
/**
 * Table Definition for adjuntos_cliente
 */
require_once 'DB/DataObject.php';

class DataObjects_Adjuntos_cliente extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'adjuntos_cliente';    // table name
    public $adjuntos_cliente_id;             // int(11)  not_null primary_key auto_increment group_by
    public $adjuntos_cliente_tipo_adjunto_id;    // int(11)  not_null group_by
    public $adjuntos_cliente_cliente_id;     // int(11)  not_null multiple_key group_by
    public $adjuntos_cliente_direccion;      // varchar(300)  not_null
    public $adjuntos_cliente_descripcion;    // varchar(300)  not_null
    public $adjuntos_cliente_nombre;         // varchar(300)  not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
