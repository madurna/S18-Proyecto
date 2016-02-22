<?php
/**
 * Table Definition for sexo
 */
require_once 'DB/DataObject.php';

class DataObjects_Sexo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'sexo';                // table name
    public $sexo_id;                        // int(11) not_null primary_key auto_increment group_by
    public $sexo_nombre;                    // varchar(200) not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_linkDisplayFields = array('sexo_nombre');
}
