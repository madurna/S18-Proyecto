<?php
/**
 * Table Definition for modulo
 */
require_once 'DB/DataObject.php';

class DataObjects_Modulo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'modulo';              // table name
    public $mod_id;                          // int(11)  not_null primary_key auto_increment group_by
    public $mod_app_id;                      // int(11)  not_null multiple_key group_by
    public $mod_nombre;                      // varchar(45)  not_null
    public $mod_baja;                        // tinyint(4)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	public $fb_linkDisplayFields = array('mod_nombre');
    
	var $fb_fieldsToRender = array(
    	'mod_id',
     	'mod_app_id',
		'mod_nombre'
    ); 
	
    //Orden de los campos en el formulario
    var $fb_preDefOrder = array(
    	'mod_nombre',
    	'mod_app_id'
    ); 
    
    public $fb_fieldLabels = array (
    'mod_nombre' => 'Nombre Modulo: ',
    'mod_app_id' => 'Nombre Aplicaci&oacute;n:',
    );
    

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			$this -> mod_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> mod_baja;
			}
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			$aux =  HTML_QuickForm::createElement('select', 'mod_baja', 'Estado: ', $estado, array('id' => 'mod_baja'));    		
    		$this -> fb_preDefElements['mod_baja'] = $aux;
    	}
    	else{
    		if ($_GET['app'] != ''){			
				$aplicaciones = array();
				$do_app = DB_DataObject::factory('aplicacion');
				$aplicaciones = $do_app -> get_aplicaciones_inicializado($_GET['app']);   			
  
				$aux =  HTML_QuickForm::createElement('select', 'mod_app_id', 'Nombre Aplicaci&oacute;n: ', $aplicaciones, array('id' => 'mod_app_id'));
				$this -> fb_preDefElements['mod_app_id'] = $aux;
    		}
    	}
	}
    
    public function delete(){	
    	//DB_DataObject::debugLevel(5); 
		/*if ($this->mod_id) {
			$do_permiso=DB_DataObject::factory('permiso');
			$do_permiso-> permiso_mod_id = $this->mod_id;
			$do_permiso->find();
			if($do_permiso->N >0){
				while($do_permiso->fetch()){
					$result=$do_permiso->delete();
					if(!$result)
						break;
				}
			}
			else 
				$result = 1;
			
			if ($result==1) {
		*/
			$this-> mod_baja = '1';		
			$this -> update();
			return true;
			/*}
			else 
				return false;
		}
		else 
			return false;*/
	}
}
