<?php
/**
 * Table Definition for cenacaf_docente
 */
require_once 'DB/DataObject.php';

class DataObjects_Cenacaf_docente extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cenacaf_docente';     // table name
    public $cenacaf_docente_id;              // int(11)  not_null primary_key auto_increment group_by
    public $cenacaf_docente_nombre;          // varchar(45)  not_null
    public $cenacaf_docente_apellido;        // varchar(45)  not_null
    public $cenacaf_docente_tipo_documento_id;    // int(11)  not_null multiple_key group_by
    public $cenacaf_docente_numero_documento;    // varchar(11)  not_null
    public $cenacaf_docente_legajo;          // varchar(100)  
    public $cenacaf_docente_linea_id;        // int(11)  not_null multiple_key group_by
    public $cenacaf_docente_empresa;         // varchar(45)  
    public $cenacaf_docente_base;            // varchar(45)  
    public $cenacaf_docente_puesto;          // varchar(45)  
    public $cenacaf_docente_baja;            // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cenacaf_docente',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	public $fb_linkDisplayFields = array('cenacaf_docente_apellido','cenacaf_docente_nombre');
		
	public $fb_fieldLabels = array (
		'cenacaf_docente_nombre' => 'Nombre del Docente: ',
		'cenacaf_docente_apellido' => 'Apellido del Docente',
		'cenacaf_docente_tipo_documento_id' => 'Tipo de Documento: ',
		'cenacaf_docente_numero_documento' => 'N&uacute;mero de Documento: ',
		'cenacaf_docente_legajo' => 'Legajo: ',
		'cenacaf_docente_linea_id' => 'L&iacute;nea: ',
		'cenacaf_docente_empresa' => 'Empresa: ',
		'cenacaf_docente_base' => 'Base: ',
		'cenacaf_docente_puesto' => 'Puesto: '
    );
	
		function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> cenacaf_docente_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> cenacaf_docente_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'cenacaf_docente_baja', 'Estado: ', $estado, array('id' => 'cenacaf_docente_baja'));    		
    		$this -> fb_preDefElements['cenacaf_docente_baja'] = $aux;
    	}
	}
}