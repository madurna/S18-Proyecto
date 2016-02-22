<?php
/**
 * Table Definition for cinta_transportadora
 */
require_once 'DB/DataObject.php';

class DataObjects_Cinta_transportadora extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cinta_transportadora';    // table name
    public $cinta_transportadora_id;         // int(11)  not_null primary_key auto_increment group_by
    public $cinta_transportadora_largo;      // float(12)  group_by
    public $cinta_transportadora_motor;      // char(45)  
    public $cinta_transportadora_ancho;      // float(12)  group_by
    public $cinta_transportadora_material;    // char(45)  
    public $cinta_transportadora_tipo_cinta;    // char(45)  
    public $id_planta;                       // int(11)  not_null group_by
    public $cinta_transportadora_estado_id;    // int(11)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    var $fb_preDefOrder = array(
        'cinta_transportadora_motor',
        'cinta_transportadora_largo',
        'cinta_transportadora_ancho',
        'cinta_transportadora_material',
        'cinta_transportadora_tipo_cinta'       
    );

    public $fb_fieldLabels = array (
        'cinta_transportadora_largo' => 'Largo: ',
        'cinta_transportadora_ancho' => 'Ancho: ',
        'cinta_transportadora_motor' => 'Motor: ',
        'cinta_transportadora_material' => 'Material: ',
        'cinta_transportadora_tipo_cinta' => 'Tipo de Cinta: '
    );
}
