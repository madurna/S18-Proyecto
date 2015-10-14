<?php
/**
 * Table Definition for empresa
 */
require_once 'DB/DataObject.php';

class DataObjects_Empresa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'empresa';             // table name
    public $empresa_id;                      // int(11)  not_null primary_key auto_increment group_by
    public $empresa_nombre;                  // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Empresa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	public $fb_linkDisplayFields = array('empresa_nombre');
	
	public $fb_fieldLabels = array (
		'empresa_nombre' => 'Nombre de Empresa: ',
		'empresa_baja' => 'Estado: '
    );

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> empresa_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> empresa_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'empresa_baja', 'Estado: ', $estado, array('id' => 'empresa_baja'));    		
    		$this -> fb_preDefElements['empresa_baja'] = $aux;
    	}
	}
	
	
 // Esta función crea un vector con el nombre de las empresa y
	// el ítem 'TODAS' al principio del arreglo.
	function get_empresa_todas(){
		$this -> orderby('empresa_nombre ASC');
		$this ->find();
		$empresa['Todas'] = 'TODAS';
		while($this->fetch()){
			$empresa[$this->empresa_id] = $this-> empresa_nombre;
		}
	return $empresa;
	}

	function get_empresas (){
		$this -> find();
		$empresas[0] = 'Seleccione una Empresa';
		while($this ->fetch()){
			$empresas[$this->empresa_id] = $this-> empresa_nombre;
		}
	return $empresas;
	}
	
	function get_empresas_nombres (){
		$this -> find();
		while($this ->fetch()){
			$empresas[$this->empresa_id] = $this-> empresa_nombre;
		}
	return $empresas;
	}

}
