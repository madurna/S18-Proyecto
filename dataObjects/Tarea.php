<?php
/**
 * Table Definition for tarea
 */
require_once 'DB/DataObject.php';

class DataObjects_Tarea extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tarea';               // table name
    public $tarea_id;                       // int(11) not_null primary_key auto_increment group_by
    public $tarea_descripcion;              // varchar(50)
    public $tarea_peso;                     // int(5) not_null group_by
    public $tarea_baja;                     // tinyint(1) not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    public $fb_linkDisplayFields = array('tarea_descripcion');

        var $fb_preDefOrder = array(
        'tarea_descripcion',
        'tarea_peso'
        );

        var $fb_fieldsToRender = array(
        'tarea_descripcion',
        'tarea_peso'
         ); 
    
    public $fb_fieldLabels = array (
        'tarea_descripcion' => 'Nombre: ',
        'tarea_peso' => 'Peso'
    );

    function preGenerateForm(&$fb) {

        //tipo documento
        $this -> tarea_descripcion = utf8_encode($this->tarea_descripcion);
        //
        
        if ($_GET['contenido']){
            $this -> tarea_id = $_GET['contenido'];
            if ($this -> find(true)){
                $estado_actual = $this -> tarea_baja;
            }
            if($estado_actual == '1'){
                $estado = array('1'=>'Baja','0'=>'Alta');
            }
            else{
                $estado = array('0'=>'Alta','1'=>'Baja');
            }
            $aux =  HTML_QuickForm::createElement('select', 'tarea_baja', 'Estado: ', $estado, array('id' => 'tarea_baja'));          
            $this -> fb_preDefElements['tarea_baja'] = $aux;
        }        
    }


}
