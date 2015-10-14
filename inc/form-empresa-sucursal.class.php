<?php
	require_once '../inc/pear.inc';
	class form_empresa_sucursal {
		
		private $_name_emp;
		private $_name_suc;
		
		function form_empresa_sucursal($name_emp='emp_id',$name_suc='suc_id') {
			$this->_name_emp = $name_emp;
			$this->_name_suc = $name_suc;
		}
		function get_form_empresa_sucursal(HTML_QuickForm &$form,$todasEmp = 1, $todasSuc = 1) {			
			$obj = DB_DataObject::factory('empresas');
			$empresas = $obj->getEmpresasNombre($todasEmp);	
			$sel = $form->addElement('select',$this->_name_emp,'Por empresa distribuidora: ',$empresas,array('id'=>'empresa','onChange'=>'updateSuc('.$todasSuc.');'));
			$form->addElement('html','
				<script>
					function updateSuc(todas) { 
						$("#sucursal").html("<option>Cargando...</option>");				
						$("#sucursal").attr("disabled","disabled");           
						jQuery.ajax({
							type: "GET",
							url: "../sucursales/get_sucursal.php",
							data: "empresa="+$("#empresa").val()+"&aSuc="+todas,
							success: function(a) {
								$("#sucursal").html(a);					
								$("#sucursal").attr("disabled","");    					
								 $("#sucursal").trigger("suc_ok");			
							}
						});
						return true;
					}
					$(document).ready(function(){updateSuc('.$todasSuc.');});
				</script>');	
			$sel_suc = $form->addElement('select',$this->_name_suc,'Por sucursal: ',null,array('id'=>'sucursal'));
			$do_suc = DB_DataObject::factory('sucursales');
			$empresa_select = $form->getSubmitValue($this->_name_emp);
			if($empresa_select != '0')
				$do_suc->suc_emp_id = $empresa_select;	
			if ($do_suc->find()) {
				$sel_suc->addOption("Todas","");
				$sel_suc->loadDbResult($do_suc->getDatabaseResult(),'suc_nombre','suc_id');
			}
			else {
				$sel_suc->addOption("Sin sucursal","");
			}			
		}
	}
?>