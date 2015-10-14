<?php
/**
 * Table Definition for provincia
 */
require_once 'DB/DataObject.php';

class DataObjects_Provincia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'provincia';           // table name
    public $provincia_id;                    // int(4)  not_null primary_key group_by
    public $provincia_nombre;                // varchar(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Provincia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_fieldLabels = array (
		'provincia_nombre' => 'Nombre de Provincia: ',
		'provincia_pais_id' => 'Pa&iacute;s: ',
		'provincia_baja' => 'Estado: '
    );
	
	public $fb_linkDisplayFields = array('provincia_nombre');

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> provincia_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> provincia_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'provincia_baja', 'Estado: ', $estado, array('id' => 'provincia_baja'));    		
    		$this -> fb_preDefElements['provincia_baja'] = $aux;
    	}
	}
	
	function get_provincias_todas(){
		$this -> orderby('provincia_nombre ASC');
		$this ->find();
		$provincia['Todas'] = 'Todas';
		while($this->fetch()){
			$provincia[$this->provincia_id] = utf8_encode($this-> provincia_nombre);
		}
		return $provincia;
	}
}
