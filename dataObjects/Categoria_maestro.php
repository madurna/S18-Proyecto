<?php
/**
 * Table Definition for categoria_maestro
 */
require_once 'DB/DataObject.php';

class DataObjects_Categoria_maestro extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'categoria_maestro';    // table name
    public $categoria_maestro_id;            // int(11)  not_null primary_key auto_increment group_by
    public $categoria_maestro_categoria_arhf_id;    // int(11)  not_null multiple_key group_by
    public $categoria_maestro_categoria_id;    // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Categoria_maestro',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
