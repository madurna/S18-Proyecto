<?php
/**
 * Table Definition for pais
 */
require_once 'DB/DataObject.php';

class DataObjects_Pais extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'pais';                // table name
    public $pais_id;                         // int(11)  not_null primary_key auto_increment group_by
    public $pais_nombre;                     // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pais',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_fieldLabels = array (
		'pais_nombre' => 'Nombre de Pa&iacute;s: ',
		'pais_baja' => 'Estado: '
    );

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> pais_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> pais_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'pais_baja', 'Estado: ', $estado, array('id' => 'pais_baja'));    		
    		$this -> fb_preDefElements['pais_baja'] = $aux;
    	}
	}

	public $fb_linkDisplayFields = array('pais_nombre');

	// Esta función crea un vector con el nombre de los paises y
	// el ítem 'Todos' al principio del arreglo.
	function get_pais_todos(){
		$this -> orderby('pais_nombre ASC');
		$this ->find();
		$pais['Todos'] = 'Todos';
		while($this->fetch()){
			$pais[$this->pais_id] = $this-> pais_nombre;
		}
		return $pais;
	}	
	
}
