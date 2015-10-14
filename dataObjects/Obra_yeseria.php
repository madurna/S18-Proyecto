<?php
/**
 * Table Definition for obra_yeseria
 */
require_once 'DB/DataObject.php';

class DataObjects_Obra_yeseria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'obra_yeseria';        // table name
    public $obra_yeseria_id;                 // int(11)  not_null primary_key auto_increment group_by
    public $obra_yeseria_descripcion;        // varchar(200)  not_null
    public $obra_yeseria_domicilio;          // varchar(45)  not_null
    public $obra_yeseria_fecha_fin;          // date(10)  not_null
    public $obra_yeseria_fecha_inicio;       // date(10)  not_null
    public $obra_yeseria_monto;              // float(12)  not_null group_by
    public $obra_yeseria_estado_id;          // int(11)  not_null multiple_key group_by
    public $obra_yeseria_localidad_id;       // int(11)  multiple_key group_by
    public $obra_yeseria_cliente_id;         // int(11)  multiple_key group_by
    public $obra_yeseria_contrato_id;        // int(11)  group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Obra_yeseria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
