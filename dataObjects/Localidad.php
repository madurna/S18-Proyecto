<?php
/**
 * Table Definition for localidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Localidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'localidad';           // table name
    public $localidad_id;                    // int(11)  not_null primary_key group_by
    public $localidad_nombre;                // varchar(255)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Localidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_linkDisplayFields = array('localidad_nombre');
	
	public $fb_fieldLabels = array (
		'localidad_nombre' => 'Nombre de Localidad: ',
		'localidad_codigo_postal' => 'C&oacute;digo Postal: ',
		'localidad_provincia_id' => 'Provincia: ',
		'localidad_baja' => 'Estado: '
    );

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> localidad_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> localidad_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'localidad_baja', 'Estado: ', $estado, array('id' => 'localidad_baja'));    		
    		$this -> fb_preDefElements['localidad_baja'] = $aux;
    	}
	}
	
	
	// Esta función crea un vector con el nombre de las localidades y
	// el ítem 'TODAS' al principio del arreglo.
	function get_localidades_todas(){
		$this -> orderBy('localidad_nombre ASC');
		//$this -> groupBy('localidad_nombre');
		$this ->find();
		$localidad['Todas'] = 'TODAS';
		while($this->fetch()){
			if($this-> localidad_nombre)
				$localidad[$this->localidad_id] = $this-> localidad_nombre;
		}
	return $localidad;
	}
}
