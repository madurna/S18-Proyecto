<?php
require_once('../config/web.config');
require_once(CFG_PATH.'/data.config');
// PEAR
require_once(INC_PATH.'/pear.inc');
require_once(INC_PATH.'/rules.php');
require_once 'HTML/QuickForm.php';
require_once('HTML/QuickForm/hierselect.php');

class formReportesIndices {
    public $form;
    function formReportesIndices($id='form',$metodo='get',$action = null) {
        $form = new HTML_QuickForm($id,$metodo,$action);
        $this->form = $form;
    }

    function armarFormEmpSemestre($name='data',$label='Empresa Distribuidora: ',$atributtes=null,$separator='Semestre: ') {
        $sel =& New HTML_QuickForm_hierselect($name, $label, null, $separator);
        $empresa = array();
        $semestre = array();
        $empresa[''] = 'Seleccione una empresa';
        $semestre['']['']='-';
        
        $do_empresas = DB_DataObject::factory('empresas');
        $do_empresas->orderBy('emp_activa desc,emp_nombre');
        $do_empresas->find();
        while ($do_empresas->fetch()) {
            $empresa[$do_empresas->emp_id] = $do_empresas->getSalidaForm();
            $do_semestres = DB_DataObject::factory('semestres');
            $do_semestres->getArraySemestresForm($do_empresas->emp_tdist_id);
            $do_semestres->whereAdd("sem_baja = 0");
            $semestre[$do_empresas->emp_id] = $do_semestres->getArraySemestresForm($do_empresas->emp_tdist_id);

        }
        $sel->setOptions(array($empresa, $semestre));
        return $sel;
    }

    public function getformReportesIndices($link,$aSuc = true)  // el valor de $link es $_GET['cont'] $aSuc = Permitir ver todas las sucursales
    {
        $form = new HTML_QuickForm('form','get',$_SERVER['REQUEST_URI']);
        $form->addElement('hidden','cont',$link);
        $sel = $form->addElement($this->armarFormEmpSemestre());
        $form->addRule('data','Debe seleccionar una empresa', 'required', null, 'client');

        $sel_suc =& $form->addElement('select','suc','Sucursal: ',null,array('id'=>'suc'));

        $data = $_GET['data'];

        if ($data[0]) {
            require_once('../sucursales/sucursales.inc.php');
            $do_suc = DB_DataObject::factory('sucursales');
            $do_suc->suc_emp_id = $data[0];
            if ($do_suc->find()) {
                if ($aSuc)
                    $sel_suc->addOption("Todas","");
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

//        $do_tar = DB_DataObject::factory('tarifa');
//        $do_tar->orderBy('tarifa_nombre');
//        $do_tar->find();
//        $tarifas = array();
//        $tarifas[0] = "Todas";
//        while($do_tar->fetch()) {
//            $tarifas[$do_tar->tarifa_id] = utf8_encode($do_tar->tarifa_nombre);
//        }
//
//        $form->addElement('select','tarifa','Tarifas: ',$tarifas);

        $do_causa = DB_DataObject::factory('tipo_causa');
        $do_causa->orderBy('tipocau_descripcion');
        $do_causa->find();
        $causas = array();
        $causas[0] = "Todas";
        while($do_causa->fetch()) {
            $causas[$do_causa->tipocau_id] = utf8_encode($do_causa->tipocau_descripcion);
        }

        $form->addElement('select','motivo','Motivo o causa: ',$causas);

        $form->addElement('checkbox','fuerza_mayor','Fuerza Mayor:');
        return $form;
    }
}
