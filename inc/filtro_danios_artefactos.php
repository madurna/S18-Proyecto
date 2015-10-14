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
$form->addGroup($group, 'empresa', 'Empresa: ', ' ',false);

if ($_GET['empresa']=='') 
	$group[1]->setValue(0);			

//almanaque para fecha
$form -> addElement('text','filtro_dia','Fecha: ',array('id'=>'filtro_dia'),null);
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
//AGREGARLO DESPUES
/*
$group3[1] =& HTML_QuickForm::createElement('text','hora','Hora: ');
$group3[2] =& HTML_QuickForm::createElement('text','minutos','Minutos: ');
$form-> addElement('group', 'hora', 'Hora - Minutos: ',$group3, ' ',false);
*/
//Almanaque para fecha reclamo
$form -> addElement('text','filtro_reclamo','Fecha Reclamo: ',array('id'=>'filtro_reclamo'),null);
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
		 	$("#filtro_reclamo").datepick({ 
			    onSelect: customRange}); 
			function customRange(dates) { 
			    if (this.id == "filtro_reclamo") { 
			        $("#filtro_dia").datepick("option", "minDate", dates[0] || null); 
				    } 
				     
					}			 
				 		   				    			     
		</script>
	');
//
$form->addElement('text','codigo_suministro','C&oacute;digo Sumistro:');
$form->addElement('text','codigo_ct','C&oacute;digo CT:');
$form->addElement('submit', null, 'Buscar');
?>