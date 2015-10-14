<?php
/**
 * Table Definition for persona
 */
require_once 'DB/DataObject.php';

class DataObjects_Persona extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'persona';             // table name
    public $id;                              // int(11)  not_null primary_key auto_increment group_by
    public $apellido;                        // varchar(45)  not_null
    public $CBU;                             // int(11)  not_null group_by
    public $domicilio;                       // varchar(45)  not_null
    public $email;                           // varchar(45)  not_null
    public $nombre;                          // varchar(45)  not_null
    public $nroDocumento;                    // varchar(45)  not_null
    public $obra_social;                     // varchar(45)  not_null
    public $telefono;                        // varchar(45)  not_null
    public $tipo_documento;                  // int(11)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Persona',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
