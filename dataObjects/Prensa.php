<?php
/**
 * Table Definition for prensa
 */
require_once 'DB/DataObject.php';

class DataObjects_Prensa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'prensa';              // table name
    public $prensa_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $prensa_motor;                    // char(45)  
    public $prensa_plano;                    // char(45)  
    public $prensa_alto;                     // float(12)  group_by
    public $prensa_ancho;                    // float(12)  group_by
    public $prensa_bomba;                    // char(45)  
    public $prensa_cilindro;                 // char(45)  
    public $prensa_comando;                  // char(45)  
    public $prensa_fondo;                    // int(11)  group_by
    public $prensa_kilajeMax;                // int(11)  group_by
    public $id_planta;                       // int(11)  not_null group_by
    public $prensa_estado_id;                // int(11)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    var $fb_preDefOrder = array(
        'prensa_alto',
        'prensa_ancho',
        'prensa_motor',
        'prensa_bomba',
        'prensa_cilindro',
        'prensa_comando',
        'prensa_fondo',
        'prensa_kilajeMax',
        'prensa_plano'      
    );

    public $fb_fieldLabels = array (
        'prensa_alto' => 'Alto: ',
        'prensa_ancho' => 'Ancho: ',
        'prensa_motor' => 'Motor: ',
        'prensa_bomba' => 'Bomba: ',
        'prensa_cilindro' => 'Cilindro: ',
        'prensa_comando' => 'Comando: ',
        'prensa_fondo' => 'Fondo: ',
        'prensa_kilajeMax' => 'Kilaje M&aacute;ximo: ',
        'prensa_plano' => 'Plano: '
    );
}
