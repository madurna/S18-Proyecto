<?php
/**
 * Table Definition for categoria_convenio_empresa_vigencia
 */
require_once 'DB/DataObject.php';

class DataObjects_Categoria_convenio_empresa_vigencia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'categoria_convenio_empresa_vigencia';    // table name
    public $cat_conv_emp_vig_id;             // int(11)  not_null primary_key auto_increment group_by
    public $cat_conv_emp_vig_categoria_id;    // int(11)  not_null multiple_key group_by
    public $cat_conv_emp_vig_conv_emp_vig_id;    // int(11)  not_null multiple_key group_by
    public $cat_conv_emp_vig_sueldo_basico;    // decimal(13)  not_null
    public $cat_conv_emp_vig_ticket;         // decimal(13)  not_null
    public $cat_conv_emp_vig_productividad;    // decimal(13)  
    public $cat_conv_emp_vig_fallo_caja;     // decimal(13)  
    public $cat_conv_emp_vig_funcion_recaudac;    // decimal(13)  
    public $cat_conv_emp_vig_acta_300812;    // decimal(13)  
    public $cat_conv_emp_vig_viatico_guarda;    // decimal(13)  
    public $cat_conv_emp_vig_snr_julio;      // decimal(13)  
    public $cat_conv_emp_vig_snr_noviembre;    // decimal(13)  
    public $cat_conv_emp_vig_resp_jerarquica;    // decimal(13)  
    public $cat_conv_emp_vig_resp_operativa;    // decimal(13)  
    public $cat_conv_emp_vig_s_no_remun;     // decimal(13)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Categoria_convenio_empresa_vigencia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
