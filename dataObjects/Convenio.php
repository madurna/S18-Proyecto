<?php
/**
 * Table Definition for convenio
 */
require_once 'DB/DataObject.php';

class DataObjects_Convenio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'convenio';            // table name
    public $convenio_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $convenio_nombre;                 // varchar(200)  not_null
    public $convenio_baja;                   // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Convenio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	public $fb_fieldLabels = array (
		'convenio_nombre' => 'Nombre de Convenio: ',
		'convenio_baja' => 'Estado: '
    );

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> convenio_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> convenio_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'convenio_baja', 'Estado: ', $estado, array('id' => 'convenio_baja'));    		
    		$this -> fb_preDefElements['convenio_baja'] = $aux;
    	}
	}
	
    // Esta función crea un vector con el nombre de las convenio y
    // el ítem 'TODAS' al principio del arreglo.
    function get_convenio_todos(){
        $this -> orderby('convenio_nombre ASC');
        $this ->find();
        $convenio['Todas'] = 'TODOS';
        while($this->fetch()){
            $convenio[$this->convenio_id] = $this-> convenio_nombre;
        }
    return $convenio;
    }

}
