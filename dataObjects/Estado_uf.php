<?php
/**
 * Table Definition for estado_uf
 */
require_once 'DB/DataObject.php';

class DataObjects_Estado_uf extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estado_uf';           // table name
    public $estado_uf_id;                   // int(11) not_null primary_key group_by
    public $estado_uf_descripcion;          // varchar(50) not_null
    public $estado_uf_baja;                 // tinyint(4) not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    public $fb_linkDisplayFields = array('estado_uf_descripcion');
}
