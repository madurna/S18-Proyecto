<?php
/**
 * Table Definition for categoria
 */
require_once 'DB/DataObject.php';

class DataObjects_Categoria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'categoria';           // table name
    public $categoria_id;                   // int(11) not_null primary_key auto_increment group_by
    public $categoria_descripcion;          // varchar(200) not_null
    public $categoria_nombre;               // varchar(45) not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
