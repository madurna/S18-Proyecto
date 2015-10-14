<?php
/**
 * Table Definition for view_estadistica_ranking_neto_bruto
 */
require_once 'DB/DataObject.php';

class DataObjects_View_estadistica_ranking_neto_bruto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'view_estadistica_ranking_neto_bruto';    // table name
    public $empresa_nombre;                  // varchar(200)  not_null
    public $liquidacion_id;                  // int(11)  not_null group_by
    public $liquidacion_empresa_id;          // int(11)  not_null group_by
    public $liquidacion_mes;                 // int(11)  not_null group_by
    public $liquidacion_anio;                // int(11)  not_null group_by
    public $detalle_liquidacion_minimo;      // decimal(22)  
    public $detalle_liquidacion_maximo;      // decimal(22)  
    public $detalle_liquidacion_concepto_id;    // int(11)  not_null group_by
    public $empresa_id;                      // int(11)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_View_estadistica_ranking_neto_bruto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
