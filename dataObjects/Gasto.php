<?php
/**
 * Table Definition for gasto
 */
require_once 'DB/DataObject.php';

class DataObjects_Gasto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'gasto';               // table name
    public $gasto_id;                        // int(11)  not_null primary_key auto_increment group_by
    public $gasto_cuenta;                    // varchar(45)  not_null
    public $gasto_descripcion;               // varchar(45)  not_null
    public $gasto_gasto_agrupamiento_id;     // int(11)  not_null multiple_key group_by
    public $gasto_baja;                      // tinyint(1)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Gasto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_fieldLabels = array (
		'gasto_cuenta' => 'N&uacute;mero de Cuenta: ',
		'gasto_descripcion' => 'Descripci&oacute;n del Gasto: ',
		'gasto_baja' => 'Estado: '
    );

	function postGenerateForm(&$frm,&$fb) {	
	
		if ($_GET['accion']=='m'){
			
			$this -> gasto_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> gasto_baja;
			}
			
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta');
			}
			//armo asi el select de baja porque no dejamos cambiar el estado desde la modificacion
    		$aux =  HTML_QuickForm::createElement('select', 'gasto_baja', 'Estado: ', $estado, array('id' => 'gasto_baja'));    		
    		$this -> fb_preDefElements['gasto_baja'] = $aux;
    	}
	}
}
