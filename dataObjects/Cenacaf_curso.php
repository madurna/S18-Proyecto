<?php
/**
 * Table Definition for cenacaf_curso
 */
require_once 'DB/DataObject.php';

class DataObjects_Cenacaf_curso extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cenacaf_curso';       // table name
    public $cenacaf_curso_id;                // int(11)  not_null primary_key auto_increment group_by
    public $cenacaf_curso_nombre;            // varchar(45)  not_null
    public $cenacaf_curso_descripcion;       // blob(65535)  blob
    public $cenacaf_curso_baja;              // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cenacaf_curso',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
		
	public $fb_linkDisplayFields = array('cenacaf_curso_nombre');

	public $fb_fieldLabels = array (
		'cenacaf_curso_nombre' => 'Nombre del Curso: ',
		'cenacaf_curso_descripcion' => 'Descripci&oacute;n del Curso: ',
		'cenacaf_curso_baja' => 'Estado: '
    );

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> cenacaf_curso_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> cenacaf_curso_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'cenacaf_curso_baja', 'Estado: ', $estado, array('id' => 'cenacaf_curso_baja'));    		
    		$this -> fb_preDefElements['cenacaf_curso_baja'] = $aux;
    	}
	}

    function get_cursos(){
		$this -> orderby('cenacaf_curso_nombre ASC');
		$this ->find();
		while($this->fetch()){
			$cenacaf_curso[$this->cenacaf_curso_id] = $this-> cenacaf_curso_nombre;
		}
		return $cenacaf_curso;
    }
	
	   function get_cursos_todos(){
		$cenacaf_curso['Todos'] = 'Todos';
		$this -> orderby('cenacaf_curso_nombre ASC');
		$this ->find();
		while($this->fetch()){
			$cenacaf_curso[$this->cenacaf_curso_id] = $this-> cenacaf_curso_nombre;
		}
		return $cenacaf_curso;
    }
}
