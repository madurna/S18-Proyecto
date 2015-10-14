<?php
/**
 * Table Definition for categoria_convenio_empresa
 */
require_once 'DB/DataObject.php';

class DataObjects_Categoria_convenio_empresa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'categoria_convenio_empresa';    // table name
    public $categoria_id;                    // int(11)  not_null primary_key auto_increment group_by
    public $categoria_nombre;                // varchar(200)  not_null
    public $categoria_convenio_empresa_id;    // int(11)  not_null multiple_key group_by
    public $categoria_baja;                  // tinyint(1)  not_null group_by
    public $categoria_codigo;                // int(11)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Categoria_convenio_empresa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_linkDisplayFields = array('categoria_nombre');
	
	public $fb_fieldLabels = array (
		'categoria_nombre' => 'Nombre de Categor&iacute;a: ',
		'categoria_codigo' => 'C&oacute;digo de Categor&iacute;a: ',
		'categoria_convenio_empresa_id' => 'Empresa/Convenio: ',
		'categoria_baja' => 'Estado: '
    );
	
	//Orden de los campos en el formulario
    var $fb_preDefOrder = array(
    	'categoria_nombre',
    	'categoria_codigo',
    	'categoria_convenio_empresa_id',
    	'categoria_baja'
    );

	function preGenerateForm(&$fb) {	
		if ($_GET['accion']=='m'){
			
			$this -> categoria_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> categoria_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'categoria_baja', 'Estado: ', $estado, array('id' => 'categoria_baja'));    		
    		$this -> fb_preDefElements['categoria_baja'] = $aux;
		}
		else{
			$convenio_empresa = 0;
		}
		
		if (($_GET['accion']=='m') or ($_GET['accion']=='e')){
			$convenio_empresa = $this -> categoria_convenio_empresa_id; 
		}
		
		//obtengo las empresas y los convenios asociados a cada empresa
		$empresas = array();
		$empresas[0] = 'Seleccione Empresa';
		$convenios = array();
		$convenios[0][0] = 'Seleccione Convenio';
		$do_empresa = DB_DataObject::factory('empresa');
		$do_empresa -> orderBy('empresa_nombre ASC');
		$do_empresa -> find();
		while ($do_empresa -> fetch()){
			$empresas[$do_empresa -> empresa_id] = $do_empresa -> empresa_nombre;
			$convenios[$do_empresa -> empresa_id][0] = 'Seleccione Convenio';
			$do_convenio_empresa = DB_DataObject::factory('convenio_empresa');
			$do_convenio = DB_DataObject::factory('convenio');
			$do_convenio_empresa  -> joinAdd($do_convenio);
			$do_convenio_empresa -> convenio_empresa_empresa_id = $do_empresa -> empresa_id;
			$do_convenio_empresa -> find();
			while ($do_convenio_empresa -> fetch()){
				$convenios[$do_empresa -> empresa_id][$do_convenio_empresa -> convenio_empresa_id] = $do_convenio_empresa -> convenio_nombre;
				if ($do_convenio_empresa -> convenio_empresa_id == $convenio_empresa){
					$indice1 = $do_empresa -> empresa_id;
					$indice2 = $do_convenio_empresa -> convenio_empresa_id;
					$nombre = $do_empresa -> empresa_nombre.' - '.$do_convenio_empresa -> convenio_nombre;
				}
			}
		}
		
		if ($_GET['accion'] == 'e'){
			$aux =  HTML_QuickForm::createElement('text', 'categoria_convenio_empresa_i', 'Empresa/Convenio', array('value' => $nombre));
		}
		else{
			//hierselect de empresa/convenio
			$aux =  HTML_QuickForm::createElement('hierselect', 'categoria_convenio_empresa_i', 'Empresa/Convenio');
			$aux -> setOptions(array($empresas, $convenios));
			$aux -> setValue(array($indice1,$indice2));
		}
		$this -> fb_preDefElements['categoria_convenio_empresa_id'] = $aux;
		//
	}
}