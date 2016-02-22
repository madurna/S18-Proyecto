<?php
/**
 * Table Definition for modulo_paginas
 */
require_once 'DB/DataObject.php';

class DataObjects_Modulo_paginas extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'modulo_paginas';      // table name
    public $modpag_id;                      // int(11) not_null primary_key auto_increment group_by
    public $modpag_mod_id;                  // int(11) not_null multiple_key group_by
    public $modpag_scriptname;              // varchar(60) not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
	public $fb_fieldLabels = array(
		'modpag_mod_id' => 'M&oacute;dulo: ',
		'modpag_scriptname' => 'P&aacute;gina: '
	);
}
