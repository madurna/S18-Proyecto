<?php
/**
 * Table Definition for categoria_arhf
 */
require_once 'DB/DataObject.php';

class DataObjects_Categoria_arhf extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'categoria_arhf';      // table name
    public $categoria_arhf_id;               // int(11)  not_null primary_key auto_increment group_by
    public $categoria_arhf_nombre;           // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Categoria_arhf',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
