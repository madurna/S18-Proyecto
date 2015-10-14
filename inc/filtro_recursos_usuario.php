<?php 
$form = new HTML_QuickForm('form','get',$_SERVER['REQUEST_URI']);
$form->addElement('hidden','filtro','si');
$form->setDefaults(array('data' => array('4','15')));

$group[1] =& HTML_QuickForm::createElement('select', 'empresa', 'Empresa Distribuidora: ');
$empresa = array();
$empresa[0] = 'Seleccione una empresa';
	
// para que muestre el "seleccione una empresa" 
$do_tipo_distribuidora = DB_DataObject::factory('tipo_distribuidora');
$do_empresas = DB_DataObject::factory('empresas');
$do_empresas -> joinAdd($do_tipo_distribuidora);
$do_empresas->orderBy('emp_activa desc,emp_nombre');
$do_empresas->find();		 
while ($do_empresas->fetch())
	{$empresa[$do_empresas->emp_id] = $do_empresas->emp_nombre;}

$group[1]->loadArray($empresa);	
$group[1]->updateAttributes(array('id' => 'empresa','onchange' => ' updateSuc();'));
$group[2] =& HTML_QuickForm::createElement('select','suc','Sucursal: ',null,array('id'=>'suc'));	
$form->addGroup($group, 'empresa_sucursal', 'Empresa - Sucursal: ', ' ',false);

if ($_GET['empresa']=='') 
	$group[1]->setValue(0);			

$data = $_GET['empresa'];	
if ($data) {		
		require_once('../sucursales/sucursales.inc.php');			
		$do_suc = DB_DataObject::factory('sucursales');
		$do_suc->suc_emp_id = $data;
		if ($do_suc->find()) {
			$group[2]->addOption("Todas","");
			$group[2]->loadDbResult($do_suc->getDatabaseResult(),'suc_nombre','suc_id');
}
else 
	{$group[2]->addOption("Sin sucursal","");}
}
if ($_GET['suc']) {
		$group[2]->setSelected($_GET['suc']);
}

$form->addElement('html','
<script>
function updateSuc() { 
	$("#suc").html("");
	$("#suc").attr("disabled","disabled");           
	jQuery.ajax({
		type: "GET",
		url: "../sucursales/get_sucursal.php",
		data: "empresa="+$("#empresa").val(),
		success: function(a) {
			$("#suc").html(a);					
			$("#suc").attr("disabled","");    					
		}
});
}
</script>');

//almanaque
$form -> addElement('text','filtro_dia','Fecha: ',array('id'=>'filtro_dia'),null);
//$group2[1] =& HTML_QuickForm::createElement('text','filtro_dia','Dia: ',array('id'=>'filtro_dia'),null);
//$form->addGroup($group, 'dia_grupo', 'D&iacute;a:', ' ',false);
//$form->addGroup($group2, 'dia_grupo', 'D&iacute;a - Mes:', ' ',false);
	
//$form->addElement('radio','dia_mes','D&iacute;a o Mes: ','D&iacute;a','dia',array('id'=>'dia'));
//$form->addElement('radio','dia_mes',null,'Mes','mes',array('id'=>'mes')); 
//$form->addElement('text','filtro_dia','Dia: ',array('id'=>'filtro_dia','style' =>'display:none;'),null);
//$form->addElement('select','filtro_mes','Mes: ',null,array('id'=>'filtro_mes','style' =>'display:none;'),null);   
$form->addElement('html','
<script>
    	$(document).ready(function() {	
			if ($("#mes:checked").val()) {
				$("#filtro_mes").attr("disabled","");
    			$("#filtro_dia").attr("disabled","disabled");    
			}
			else {
				$("#dia").selected();
				$("#filtro_mes").attr("disabled","disabled");
    			$("#filtro_dia").attr("disabled","");
			}
			$("#mes").change(function() {
    			$("#filtro_mes").attr("disabled","");
    			$("#filtro_dia").attr("disabled","disabled");           
    		});
    		$("#dia").change(function() {
    			$("#filtro_mes").attr("disabled","disabled");
    			$("#filtro_dia").attr("disabled","");
    		});
    	})
        function updateMeses() { 
        	$("#filtro_mes").html("");
			$("#filtro_mes").attr("disabled","disabled");           
            jQuery.ajax({
				type: "GET",
				url: "../semestres/get_mes.php",
				data: "semestre="+$(\'select[name="data[1]"]\').val(),
				success: function(a) {
					$("#filtro_mes").html(a);
					$("#filtro_mes").attr("disabled","");         					
				}
			});
        }
    </script>');
	$form->addElement('html',
		'
		<link rel="stylesheet" type="text/css" media="all" href="../js/jquery.datepick/jquery.datepick.css" />
		<style type="text/css">
			.datepick-popup select {
	    							font-size: 100%;
	    							margin: 0px 0px 0px 0;
					    			padding: 0;
									}
		</style>
		<script type="text/javascript" src="../js/jquery.datepick/jquery.datepick.js"></script>				 
		<script type="text/javascript" src="../js/jquery.datepick/jquery.datepick-es-AR.js"></script>
		<script type="text/javascript">
		 	$("#filtro_dia").datepick({ 
			    onSelect: customRange}); 
			function customRange(dates) { 
			    if (this.id == "filtro_dia") { 
			        $("#filtro_dia").datepick("option", "minDate", dates[0] || null); 
				    } 
				     
					}			 
				 		   				    			     
		</script>
	');
//

$form->addElement('hidden','filtro','si');
$form->addElement('submit', null, 'Buscar');
?>