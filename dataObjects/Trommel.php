<?php
/**
 * Table Definition for trommel
 */
require_once 'DB/DataObject.php';

class DataObjects_Trommel extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'trommel';             // table name
    public $trommel_id;                      // int(11)  not_null primary_key auto_increment group_by
    public $trommel_diametro;                // float(12)  group_by
    public $trommel_largo;                   // float(12)  group_by
    public $trommel_motor;                   // char(45)  
    public $trommel_plano;                   // char(45)  
    public $trommel_relacion_engranaje;      // float(12)  group_by
    public $id_planta;                       // int(11)  not_null group_by
    public $trommel_estado_id;               // int(11)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    var $fb_preDefOrder = array(
        'trommel_diametro',
        'trommel_largo',
        'trommel_motor',
        'trommel_relacion_engranaje',
        'trommel_plano'              
    );

    public $fb_fieldLabels = array (
        'trommel_diametro' => 'Di&aacute;metro: ',
        'trommel_largo' => 'Largo: ',
        'trommel_motor' => 'Motor: ',
        'trommel_relacion_engranaje' => 'Relaci&oacute;n Engranaje: ',
        'trommel_plano' => 'Plano: '
        
    );
}
