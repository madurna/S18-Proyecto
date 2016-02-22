<?php
/**
 * Table Definition for presupuesto
 */
require_once 'DB/DataObject.php';

class DataObjects_Presupuesto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'presupuesto';         // table name
    public $presupuesto_id;                 // int(11) not_null primary_key auto_increment group_by
    public $presupuesto_descripcion;        // varchar(200) not_null
    public $presupuesto_dias_validez;       // int(11) not_null group_by
    public $presupuesto_fecha;              // datetime(19) not_null
    public $presupuesto_monto;              // float(12) not_null group_by
    public $presupuesto_path;               // varchar(45) not_null
    public $presupuesto_obrero_id;          // int(11) multiple_key group_by
    public $presupuesto_obra_yeseria_id;    // int(11) not_null multiple_key group_by
    public $presupuesto_cliente_id;         // int(11) not_null multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
