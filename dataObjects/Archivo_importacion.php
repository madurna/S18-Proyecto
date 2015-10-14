<?php
/**
 * Table Definition for archivo_importacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Archivo_importacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'archivo_importacion';    // table name
    public $archivo_imp_id;                  // int(11)  not_null primary_key auto_increment group_by
    public $archivo_imp_fecha;               // date(10)  not_null
    public $archivo_imp_tipo_archivo_id;     // int(11)  not_null multiple_key group_by
    public $archivo_imp_usuario_id;          // int(11)  not_null multiple_key group_by
    public $archivo_imp_nombre;              // varchar(200)  not_null
    public $archivo_imp_ruta;                // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Archivo_importacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
