<?php
/**
 * Table Definition for aplicacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Aplicacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'aplicacion';          // table name
    public $app_id;                          // int(11)  not_null primary_key auto_increment group_by
    public $app_nombre;                      // varchar(45)  not_null
    public $app_baja;                        // tinyint(4)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
	public $fb_linkDisplayFields = array('app_nombre');
    
    public $fb_fieldLabels = array (
    'app_nombre' => 'Nombre AplicaciÃ³n: ',
    'app_baja' => ''
    );

	var $fb_fieldsToRender = array(
		'app_id',
		'app_nombre'
	);

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> app_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> app_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion debido a que implica eliminar modulos
    		$aux =  HTML_QuickForm::createElement('select', 'app_baja', 'Estado: ', $estado, array('id' => 'app_baja'));    		
    		$this -> fb_preDefElements['app_baja'] = $aux;
    	}
	}
    
    /*
    public function find($f=false,$baja=0) {
    	$this->app_baja = $baja;
    	return parent::find($f);
    }
    */
    
    public function delete() {
    	$do_modulo=DB_DataObject::factory('modulo');
		$do_modulo->mod_app_id = $this->app_id;
		$do_modulo->find();
		if($do_modulo->N > 0) {
			while ($do_modulo->fetch()) {					
				$result = $do_modulo->delete();		
				if (!$result)
					break;
			}				
		}
		else {			
			$result = 1;
		}
		if ($result==1) {
			$this->app_baja = 1;
    		parent::update();		
			return true;
		}
		else {
			return false;
		}
    }
    
	// Esta función crea un vector con el nombre de las aplicaciones y
	// el ítem 'TODAS' al principio del arreglo.
	function get_aplicaciones_todas(){
		//$this -> orderby('rol_nombre ASC');
		$this ->find();
		$aplicaciones['Todas'] = 'TODAS';
		while($this->fetch()){
			$aplicaciones[$this->app_id] = $this-> app_nombre;
		}
	return $aplicaciones;
	}
	
	// Esta función crea un vector con el nombre de las aplicaciones y 
	// el nombre de la aplicaion cuyo id es pasado por parametro al principio del arreglo.
	function get_aplicaciones_inicializado($id_app){
		//$this -> orderby('rol_nombre ASC');
		$this -> app_id = $id_app;
		if ($this ->find(true)){
			$aplicaciones[$id_app] = $this -> app_nombre;
		}
		$do_aplicacion= DB_DataObject::factory('aplicacion'); 
		$do_aplicacion -> find();
		while($do_aplicacion ->fetch()){
			if ($do_aplicacion ->app_id != $id_app){
				$aplicaciones[$do_aplicacion->app_id] = $do_aplicacion-> app_nombre;
			}
		}
	return $aplicaciones;
	}
	
	// Esta función crea un vector con el nombre de las aplicaciones 
	function get_aplicaciones (){
		$this -> find();
		while($this ->fetch()){
			$aplicaciones[$this->app_id] = $this-> app_nombre;
		}
	return $aplicaciones;
	}
    
}
