<?php
/**
 * Table Definition for tipo_concepto
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipo_concepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipo_concepto';       // table name
    public $tipo_concepto_id;                // int(11)  not_null primary_key auto_increment group_by
    public $tipo_concepto_nombre;            // varchar(100)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipo_concepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	public $fb_fieldLabels = array (
		'tipo_concepto_nombre' => 'Nombre de Tipo de Concepto: ',
		'tipo_concepto_baja' => 'Estado: '
    );

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> tipo_concepto_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> tipo_concepto_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'tipo_concepto_baja', 'Estado: ', $estado, array('id' => 'tipo_concepto_baja'));    		
    		$this -> fb_preDefElements['tipo_concepto_baja'] = $aux;
		}
	}
	
	// Esta función crea un vector con el nombre de las tipo de concepto y
	// el ítem 'TODAS' al principio del arreglo.
	function get_tipo_concepto_todas(){
		$this -> orderby('tipo_concepto_nombre ASC');
		$this ->find();
		$tipo_concepto['Todas'] = 'TODOS';
		while($this->fetch()){
			$tipo_concepto[$this->tipo_concepto_id] = $this-> tipo_concepto_nombre;
		}
		return $tipo_concepto;
	}

	// Esta función crea un vector con el nombre de los tipo de concepto
	function get_tipo_concepto(){
		$this -> orderby('tipo_concepto_nombre ASC');
		$this ->find();
		while($this->fetch()){
			$tipo_concepto[$this->tipo_concepto_id] = $this-> tipo_concepto_nombre;
		}
		return $tipo_concepto;
	}
}
