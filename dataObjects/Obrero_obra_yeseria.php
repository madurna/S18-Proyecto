<?php
/**
 * Table Definition for obrero_obra_yeseria
 */
require_once 'DB/DataObject.php';

class DataObjects_Obrero_obra_yeseria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'obrero_obra_yeseria';    // table name
    public $obrero_obra_yeseria_id;         // int(11) not_null primary_key auto_increment group_by
    public $obrero_obra_yeseria_descripcion;   // varchar(200) not_null
    public $obrero_obra_yeseria_fecha;      // date(10) not_null
    public $obrero_obra_yeseria_obrero_id;   // int(11) not_null multiple_key group_by
    public $obrero_obra_yeseria_obra_yeseria_id;   // int(11) not_null multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
