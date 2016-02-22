<?php
/**
 * Table Definition for hito
 */
require_once 'DB/DataObject.php';

class DataObjects_Hito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'hito';                // table name
    public $hito_id;                        // int(11) not_null primary_key auto_increment group_by
    public $hito_nombre;                    // varchar(45) not_null
    public $hito_plazo_estimado_dias;       // int(11) not_null group_by
    public $hito_estado;                    // tinyint(1) not_null multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
 public $fb_linkDisplayFields = array('hito_nombre');

        var $fb_preDefOrder = array(
        'hito_nombre',
        'hito_plazo_estimado_dias',
        'hito_peso'
        );

        var $fb_fieldsToRender = array(
        'hito_nombre',
        'hito_plazo_estimado_dias',
        'hito_peso'
         ); 
    
    public $fb_fieldLabels = array (
        'hito_nombre' => 'Nombre: ',
        'hito_plazo_estimado_dias' => 'Plazo estimado (dias) : ',
        'hito_peso' => 'Peso'
    );

    function preGenerateForm(&$fb) {

        //tipo documento
        $this -> hito_nombre = utf8_encode($this->hito_nombre);
        //
        
        if ($_GET['contenido']){
            $this -> hito_id = $_GET['contenido'];
            if ($this -> find(true)){
                $estado_actual = $this -> hito_estado;
            }
            if($estado_actual == '1'){
                $estado = array('1'=>'Baja','0'=>'Alta');
            }
            else{
                $estado = array('0'=>'Alta','1'=>'Baja');
            }
            $aux =  HTML_QuickForm::createElement('select', 'hito_estado', 'Estado: ', $estado, array('id' => 'hito_estado'));          
            $this -> fb_preDefElements['hito_estado'] = $aux;
        }        
    }


}
