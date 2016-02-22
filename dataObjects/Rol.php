<?php
/**
 * Table Definition for rol
 */
require_once 'DB/DataObject.php';

class DataObjects_Rol extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'rol';                 // table name
    public $rol_id;                         // int(11) not_null primary_key auto_increment group_by
    public $rol_nombre;                     // varchar(45) not_null
    public $rol_baja;                       // tinyint(4) not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
	public $fb_linkDisplayFields = array('rol_nombre');
    
    public $fb_fieldLabels = array (
    'rol_nombre' => 'Nombre Rol: '
    );
    
   	var $fb_fieldsToRender = array(
		'rol_id',
		'rol_nombre'
	);
    
	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> rol_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> rol_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			
    		$aux =  HTML_QuickForm::createElement('select', 'rol_baja', 'Estado: ', $estado, array('id' => 'rol_baja'));    		
    		$this -> fb_preDefElements['rol_baja'] = $aux;
    	}
	}

    public function delete()
    {
    	$do_usuario_rol=DB_DataObject::factory('usuario_rol');
		$do_usuario_rol-> usrrol_rol_id = $this->rol_id;
		$do_usuario_rol->find();
		
		$result = 1;		
		if($do_usuario_rol->N >0){
			while($do_usuario_rol->fetch()){
				$result=$do_usuario_rol->delete();
				if(!$result)
					break;
			}
		}
				
		if ($result !=1) {					
			return false;
		}
		/*
		$result2 = 1;
		$do_permiso=DB_DataObject::factory('permiso');
		$do_permiso->permiso_rol_id = $this->rol_id;
		$do_permiso->find();    	
		if($do_permiso->N >0){
			while($do_permiso->fetch()){
				$result2=$do_permiso->delete();
				if(!$result2)
					break;
			}
		}			
		
		if ($result2==1) {					
			return parent::delete();
		}
		else {			
			return false;
		}*/
		$this -> rol_baja = '1';
		$this -> update();
		return true;
    }
    
	// Esta función crea un vector con el nombre de los roles y
	// el ítem 'TODOS' al principio del arreglo.
	function get_roles_todos(){
		//$this -> orderby('rol_nombre ASC');
		$this ->find();
		$roles['Todos'] = 'TODOS';
		while($this->fetch()){
			$roles[$this->rol_id] = $this-> rol_nombre;
		}
	return $roles;
	}
	
	// Esta función crea un vector con el nombre de los roles y
	// el nombre del rol cuyo id es pasado por parametro al principio del arreglo.
	function get_roles_inicializado($id_rol){
		//$this -> orderby('rol_nombre ASC');
		$this -> rol_id = $id_rol;
		if ($this ->find(true)){
			$roles[$id_rol] = $this -> rol_nombre;
		}
		$do_rol= DB_DataObject::factory('rol'); 
		$do_rol -> find();
		while($do_rol ->fetch()){
			if ($do_rol ->rol_id != $id_rol){
				$roles[$do_rol->rol_id] = $do_rol-> rol_nombre;
			}
		}
	return $roles;
	}
	
	// Esta función crea un vector con el nombre de los roles
	function get_roles(){
		$this -> find();
		while($this ->fetch()){
			$roles[$this->rol_id] = $this-> rol_nombre;
		}
	return $roles;
	}
    
}
