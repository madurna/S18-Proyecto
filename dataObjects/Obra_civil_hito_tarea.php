<?php
/**
 * Table Definition for obra_civil_hito_tarea
 */
require_once 'DB/DataObject.php';

class DataObjects_Obra_civil_hito_tarea extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'obra_civil_hito_tarea';    // table name
    public $obra_civil_hito_tarea_id;       // int(11) not_null primary_key auto_increment group_by
    public $obra_civil_hito_tarea_obra_civil_hito_id;   // int(11) not_null multiple_key group_by
    public $obra_civil_hito_tarea_tarea_id;   // int(11) not_null multiple_key group_by
    public $obra_civil_hito_tarea_estado;   // tinyint(1) not_null group_by
    public $obra_civil_hito_tarea_fecha_finalizacion;   // date(10)

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
