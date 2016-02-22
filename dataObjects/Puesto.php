<?php
/**
 * Table Definition for puesto
 */
require_once 'DB/DataObject.php';

class DataObjects_Puesto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'puesto';              // table name
    public $puesto_id;                      // int(11) not_null primary_key auto_increment group_by
    public $puesto_nombre;                  // varchar(200) not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_linkDisplayFields = array('puesto_nombre');

	public $fb_fieldLabels = array (
		'puesto_nombre' => 'Nombre de Puesto: ',
		'puesto_baja' => 'Estado: '
    );

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> puesto_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> puesto_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'puesto_baja', 'Estado: ', $estado, array('id' => 'puesto_baja'));    		
    		$this -> fb_preDefElements['puesto_baja'] = $aux;
    	}
	}

    function get_puesto_todos(){
    $this -> orderby('puesto_nombre ASC');
    $this ->find();
    $puesto['Todas'] = 'TODOS';
    while($this->fetch()){
        $puesto[$this->puesto_id] = $this-> puesto_nombre;
    }
    return $puesto;
    }

}
