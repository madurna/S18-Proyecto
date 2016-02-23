<?php
/**
 * Table Definition for obra_civil_hito
 */
require_once 'DB/DataObject.php';

class DataObjects_Obra_civil_hito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'obra_civil_hito';     // table name
    public $obra_civil_hito_id;              // int(11)  not_null primary_key auto_increment group_by
    public $obra_civil_hito_peso;            // int(5)  not_null group_by
    public $obra_civil_hito_obra_civil_id;    // int(11)  not_null multiple_key group_by
    public $obra_civil_hito_hito_id;         // int(11)  not_null multiple_key group_by
    public $obra_civil_hito_estado;          // tinyint(4)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
