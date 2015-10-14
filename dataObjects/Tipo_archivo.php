<?php
/**
 * Table Definition for tipo_archivo
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipo_archivo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipo_archivo';        // table name
    public $tipo_archivo_id;                 // int(11)  not_null primary_key auto_increment group_by
    public $tipo_archivo_nombre;             // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipo_archivo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	public $fb_fieldLabels = array (
		'tipo_archivo_nombre' => 'Nombre de Tipo de Archivo: ',
		'tipo_archivo_baja' => 'Estado: '
    );

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> tipo_archivo_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> tipo_archivo_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'tipo_archivo_baja', 'Estado: ', $estado, array('id' => 'tipo_archivo_baja'));    		
    		$this -> fb_preDefElements['tipo_archivo_baja'] = $aux;
    	}
	}
	
}
