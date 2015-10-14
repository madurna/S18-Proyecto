<?php
/**
 * Table Definition for adjuntos_comercializador
 */
require_once 'DB/DataObject.php';

class DataObjects_Adjuntos_comercializador extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'adjuntos_comercializador';    // table name
    public $adjuntos_comercializador_id;     // int(11)  not_null primary_key auto_increment group_by
    public $adjuntos_comercializador_tipo_adjunto_id;    // int(11)  not_null group_by
    public $adjuntos_comercializador_comercializador_id;    // int(11)  not_null group_by
    public $adjuntos_comercializador_direccion;    // varchar(300)  not_null
    public $adjuntos_comercializador_descripcion;    // varchar(300)  not_null
    public $adjuntos_comercializador_nombre;    // varchar(300)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Adjuntos_comercializador',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
