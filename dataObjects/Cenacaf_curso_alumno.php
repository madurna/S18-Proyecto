<?php
/**
 * Table Definition for cenacaf_curso_alumno
 */
require_once 'DB/DataObject.php';

class DataObjects_Cenacaf_curso_alumno extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cenacaf_curso_alumno';    // table name
    public $cenacaf_curso_alumno_id;         // int(11)  not_null primary_key auto_increment group_by
    public $cenacaf_curso_alumno_fecha;      // date(10)  not_null
    public $cenacaf_curso_alumno_curso_id;    // int(11)  not_null multiple_key group_by
    public $cenacaf_curso_alumno_alumno_id;    // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cenacaf_curso_alumno',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
