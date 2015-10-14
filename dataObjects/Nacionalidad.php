<?php
/**
 * Table Definition for nacionalidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Nacionalidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'nacionalidad';        // table name
    public $nacionalidad_id;                 // int(11)  not_null primary_key group_by
    public $nacionalidad_nombre;             // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Nacionalidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_linkDisplayFields = array('nacionalidad_nombre');
}
