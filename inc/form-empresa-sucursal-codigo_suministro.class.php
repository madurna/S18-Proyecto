<?php
require_once('../config/web.config');
require_once(CFG_PATH.'/data.config');
// PEAR
require_once(INC_PATH.'/pear.inc');
require_once(INC_PATH.'/rules.php');
require_once 'HTML/QuickForm.php';
require_once('HTML/QuickForm/hierselect.php');

class form_empresa_sucursal_codigo_suministro 
{	
	public $form;
	function form_empresa_sucursal_codigo_suministro($id='form',$metodo='get',$action = null) {
		$form = new HTML_QuickForm($id,$metodo,$action);
		$this->form = $form;
	}
	
 	public function get_form_empresa_sucursal_cod_sum($link=null)  // el valor de $link es $_GET['cont']
    {														
        $form = $this->form;
		$aux = $this->armo_form_empresa_sucursal_cod_sum($form);
		//print_r($aux); exit;
        //$form->addElement($aux);	  
			
		return $form;
    }
	
	function armarFormEmp($name='data',$label='Empresa Distribuidora: ',$atributtes=null) {
		$sel =& New HTML_QuickForm_hierselect($name, $label, null);	
		$empresa = array();
		//$semestre = array();
		$empresa[''] = 'Seleccione una empresa';
		//$semestre['']['']='-';
		// para que muestre el "seleccione una empresa" 
		/*if ($_GET['data']['0']=='') 
			$sel->setValue();*/
		$do_empresas = DB_DataObject::factory('empresas');
		//$do_tipo_distribuidora = DB_DataObject::factory('tipo_distribuidora');
		//$do_empresas->joinAdd($do_tipo_distribuidora);
		$do_empresas->orderBy('emp_activa desc,emp_nombre');
		$do_empresas->find();
		while ($do_empresas->fetch())
		{
			$empresa[$do_empresas->emp_id] = $do_empresas->getSalidaForm();
		  	//$do_semestres = DB_DataObject::factory('semestres');
		  	//$do_semestres->getArraySemestresForm($do_empresas->emp_tdist_id);
            //$do_semestres->whereAdd("sem_baja = 0");
		  	//$semestre[$do_empresas->emp_id] = $do_semestres->getArraySemestresForm($do_empresas->emp_tdist_id);

		  }	  			
		$sel->setOptions(array($empresa));
		return $sel;
	}
    
	function armo_form_empresa_sucursal_cod_sum($form)
	{
	//prefiltro
	$empresas = array();
	
	$sel = $form->addElement($this->armarFormEmp());    
	$form->addRule('data','Debe seleccionar una empresa', 'required', null, 'client');
		
	$sel_suc =& $form->addElement('select','suc','Sucursal: ',null,array('id'=>'suc'));				
	$data = $_GET['data'];
	if ($data[0]) {		
		require_once('../sucursales/sucursales2.inc.php');			
		$do_suc = DB_DataObject::factory('sucursales');
		$do_suc->suc_emp_id = $data[0];
		if ($do_suc->find()) {
			//if ($aSuc)
				//$sel_suc->addOption("Todas","");
			$sel_suc->loadDbResult($do_suc->getDatabaseResult(),'suc_nombre','suc_id');
		}
		else {
			$sel_suc->addOption("Sin sucursal","");
		}
	}
	else {
			$sel_suc->addOption("-","");
	}
	if ($_GET['suc']) {
		$sel_suc->setSelected($_GET['suc']);
	}
	$todasSuc ='0';
	if ($aSuc)
		$todasSuc ='1';
		
	$selectsHS = $sel->getElements();
   	$selectsHS[0]->updateAttributes(array('id' => 'empresa','onchange' => ' updateSuc();'));
   		//$selectsHS[1]->updateAttributes(array('id' => 'sem'));
    $form->addElement('html','
    	<script>
        function updateSuc() { 
			if ($("#empresa").val()) {
				$("#suc").html("<option>Cargando...</option>");
				$("#suc").attr("disabled","disabled");           
				jQuery.ajax({
					type: "GET",
					url: "../sucursales/get_sucursal.php",
					data: "empresa="+$("#empresa").val()+"&aSuc="+'.$todasSuc.',
					success: function(a) {
						$("#suc").html(a);					
						$("#suc").attr("disabled","");    					
					}
				});
			}
			else {
				$("#suc").html("-");
			}
        }
    </script>');	
	
	//$form = new HTML_QuickForm('form','get',$_SERVER['REQUEST_URI']);
    //$form->addElement('select','empresa','Empresa: ',$empresas,array('id'=>'empresa'));
	$form->addElement('text', 'codigo_suministro', 'C&oacute;digo Suministro: ',array('id' => 'codigo_suministro','onchange' => ' updateCliente($("#codigo_suministro").val());'));
	$form->addElement('html','<tr><td colspan=2 id="cli"></td></tr>');
	/*
	$form->addElement('html','
    	<script>
    	$(document).ready(function() {
    		$( "#codigo_suministro" ).autocomplete({
			source: function(req, add){  
  
                //pass request to server  
                $.getJSON("../datos/autocomplete_clientes.php?dist="+$("#empresa").val(), req, function(data) {  
  
                    //create array for response objects  
                    var suggestions = [];  
  
                    //process response  
                    $.each(data, function(i, val){  
	                    suggestions.push(val); 
	                });  
 
                //pass array to callback  
                add(suggestions);  
            });
            },			
			minLength: 4,
			select: function( event, ui ) {
				updateCliente(ui.item.value);
			}
			});
    	});    	
        function updateCliente(valor) {       
        	if ($("#codigo_suministro").val()) {
				$("#cli").html("Cargando...");
				$("#cli").attr("disabled","disabled");
				jQuery.ajax({
					type: "GET",
					url: "../datos/get_clientes_emp.php",
					data: "codigo_suministro="+valor+"&dist="+$("#empresa").val(),
					success: function(a) {
						$("#cli").html(a);
						$("#cli").attr("disabled","");
					}
				});
			}
			else {
				$("#cli").html("-");
			}
        }
    </script>');*/
	
	return $form;
	}
}
