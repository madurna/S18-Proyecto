<?php
/**
 * Table Definition for licencia
 */
require_once 'DB/DataObject.php';

class DataObjects_Licencia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'licencia';            // table name
    public $licencia_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $licencia_fecha_comienzo;         // datetime(19)  not_null
    public $licencia_fecha_fin;              // datetime(19)  not_null
    public $licencia_nota;                   // varchar(200)  not_null
    public $licencia_path_certificado;       // varchar(45)  not_null
    public $licencia_tipo_licencia;          // int(11)  not_null group_by
    public $licencia_obrero_id;              // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Licencia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
