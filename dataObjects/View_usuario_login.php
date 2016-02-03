<?php
/**
 * Table Definition for view_usuario_login
 */
require_once 'DB/DataObject.php';

class DataObjects_View_usuario_login extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'view_usuario_login';    // table name
    public $usrrol_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $usua_id;                         // int(11)  not_null primary_key auto_increment group_by
    public $usua_usrid;                      // varchar(50)  not_null
    public $usua_nombre;                     // varchar(100)  
    public $usua_pwd;                        // varchar(32)  not_null
    public $usua_email;                      // varchar(100)  not_null
    public $rol_nombre;                      // varchar(45)  not_null
    public $app_id;                          // int(11)  not_null primary_key auto_increment group_by
    public $app_nombre;                      // varchar(45)  not_null
    public $permiso_id;                      // int(11)  not_null primary_key auto_increment group_by
    public $tipoacc_id;                      // int(11)  not_null primary_key auto_increment group_by
    public $tipoacc_nombre;                  // varchar(45)  unique_key
    public $mod_id;                          // int(11)  not_null primary_key auto_increment group_by
    public $mod_nombre;                      // varchar(45)  not_null
    public $modpag_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $modpag_scriptname;               // varchar(60)  not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
