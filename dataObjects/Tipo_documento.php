<?php
/**
 * Table Definition for tipo_documento
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipo_documento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipo_documento';      // table name
    public $tipo_documento_id;              // int(11) not_null primary_key auto_increment group_by
    public $tipo_documento_nombre;          // varchar(200) not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_linkDisplayFields = array('tipo_documento_nombre');
}
