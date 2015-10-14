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
$group2[1] =& HTML_QuickForm::createElement('select','periodo','Periodo: ',$periodos,array('id'=>'periodo'));
$group2[2] =& HTML_QuickForm::createElement('select', 'anio', 'A&ntilde;o: ');
$group2[2] -> setSelected (date('Y'));
//vector para la carga de los años

$anio_sig=date('Y')+1;
//$anios[0]=$anio_sig;
for ($i=0 ; $i<10 ; $i++)
{
	$anios[$anio_sig-$i]=$anio_sig-$i;
}
//-----------------

$group2[2]->loadArray($anios);
$form->addGroup($group2, 'periodo_anio', 'Periodo - A&ntilde;o: ', ' ',false);
$form->addElement('hidden','filtro','si');
$form->addElement('text','cant_dias','D&iacute;as H&aacute;biles',array('value'=>'10','onclick' => 'javascript:this.value=""'));
$form->addElement('submit', null, 'Buscar');
?>