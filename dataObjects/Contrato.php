<?php
/**
 * Table Definition for contrato
 */
require_once 'DB/DataObject.php';

class DataObjects_Contrato extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'contrato';            // table name
    public $contrato_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $contrato_bibliorato;             // int(11)  not_null group_by
    public $contrato_caja_numero;            // int(11)  not_null group_by
    public $contrato_cliente_id;             // int(11)  not_null multiple_key group_by
    public $contrato_fecha;                  // date(10)  not_null
    public $contrato_monto;                  // double(20)  not_null group_by
    public $contrato_path;                   // varchar(300)  
    public $contrato_descripcion;            // varchar(300)  
    public $contrato_tipo_adjunto_id;        // int(11)  group_by
    public $contrato_adjunto_nombre;         // varchar(300)  

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
