<?php
require_once('../config/web.config');
require_once(CFG_PATH.'/data.config');
// PEAR
require_once(INC_PATH.'/pear.inc');
require_once(INC_PATH.'/rules.php');
require_once 'HTML/QuickForm.php';
require_once('HTML/QuickForm/hierselect.php');

class form_empresa_codigo_suministro 
{	
	public $form;
	function form_empresa_codigo_suministro($id='form',$metodo='get',$action = null) {
		$form = new HTML_QuickForm($id,$metodo,$action);
		$this->form = $form;
	}
	
 	public function get_form_empresa_cod_sum($link=null)  // el valor de $link es $_GET['cont']
    {														
        $form = $this->form;
        $form->addElement($this->armo_form_empresa_cod_sum($form));	  
		return $form;
    }
	
	function armo_form_empresa_cod_sum($form)
	{
	//prefiltro
	$empresas = array();
	$obj = DB_DataObject::factory('empresas');
	$empresas = $obj->getEmpresas2($id_empresa);
	
	//$form = new HTML_QuickForm('form','get',$_SERVER['REQUEST_URI']);
    $form->addElement('select','empresa','Empresa: ',$empresas,array('id'=>'empresa'));
	$form->addElement('text', 'codigo_suministro', 'C&oacute;digo Suministro: ',array('id' => 'codigo_suministro','onchange' => ' updateCliente($("#codigo_suministro").val());'));
	$form->addElement('html','<tr><td colspan=2 id="cli"></td></tr>');
	
	$form->addElement('html','
    	<script>
    	$(document).ready(function() {
    		$( "#codigo_suministro" ).autocomplete({
			source: "../datos/autocomplete_clientes.php?dist="+$("#empresa").val(),			
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
					url: "../datos/get_clientes.php",
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
    </script>');
	return $form;
	}
}
