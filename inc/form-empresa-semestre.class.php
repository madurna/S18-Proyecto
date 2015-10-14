<?php
require_once('../config/web.config');
require_once(CFG_PATH.'/data.config');
// PEAR
require_once(INC_PATH.'/pear.inc');
require_once(INC_PATH.'/rules.php');
require_once 'HTML/QuickForm.php';
require_once('HTML/QuickForm/hierselect.php');

class form_empresa_semestre 
{
	public $form;
	function form_empresa_semestre($id='form',$metodo='get',$action = null) {
		$form = new HTML_QuickForm($id,$metodo,$action);
		$this->form = $form;
	}	
	
	function armarFormEmpSemestre($name='data',$label='Empresa Distribuidora: ',$atributtes=null,$separator='Semestre: ',$aEmp = false,$aSem = false) {
		$sel =& New HTML_QuickForm_hierselect($name, $label, null, $separator);	
		$empresa = array();
		$semestre = array();
		if (!$aEmp ) {		
			$empresa[''] = 'Seleccione una empresa';
			$semestre['']['']='-';
		}
		
		// para que muestre el "seleccione una empresa" 
		/*if ($_GET['data']['0']=='') 
			$sel->setValue();*/
		$do_empresas = DB_DataObject::factory('empresas');
		//$do_tipo_distribuidora = DB_DataObject::factory('tipo_distribuidora');
		//$do_empresas->joinAdd($do_tipo_distribuidora);
		$do_empresas->orderBy('emp_activa desc,emp_nombre');
		$do_empresas->find();
		if ($aEmp) {
			$empresa['0'] = 'Todas';
			$semestre['0']['0'] = 'Todos';
		}
		
		
		while ($do_empresas->fetch())
		{
			$empresa[$do_empresas->emp_id] = $do_empresas->getSalidaForm();
		  	$do_semestres = DB_DataObject::factory('semestres');
		  	$do_semestres->getArraySemestresForm($do_empresas->emp_tdist_id);
            $do_semestres->whereAdd("sem_baja = 0");
			$semestre[$do_empresas->emp_id] = array();
			if ($aSem) {				
				$semestre[$do_empresas->emp_id]['0'] = 'Todos';
				$semestre[$do_empresas->emp_id] = array_merge($semestre[$do_empresas->emp_id],$do_semestres->getArraySemestresForm($do_empresas->emp_tdist_id));
			}
			else {
					$semestre[$do_empresas->emp_id] = $do_semestres->getArraySemestresForm($do_empresas->emp_tdist_id);
			}
			
			
		  }	  			
		$sel->setOptions(array($empresa, $semestre));
		return $sel;
	}
	function armarFormTdistSemestre($name='data',$label='Tipo Distribuidora: ',$atributtes=null,$separator='Semestre: ') {
		$sel =& New HTML_QuickForm_hierselect($name, $label, null, $separator);	
		$tdist = array();
		$semestre = array();
		
		$do_tdist = DB_DataObject::factory('tipo_distribuidora');
		$do_tdist->orderBy('tdist_nombre');
		$do_tdist->find();
		while ($do_tdist->fetch())
		{
			$tdist[$do_tdist->tdist_id] = $do_tdist->getSalidaForm();
		  	$do_semestres = DB_DataObject::factory('semestres');
		  	$do_semestres->getArraySemestresForm($do_tdist->tdist_id);
                        $do_semestres->whereAdd("sem_baja = 0");
		  	$semestre[$do_tdist->tdist_id] = $do_semestres->getArraySemestresForm($do_tdist->tdist_id);

		  }	  			
		$sel->setOptions(array($tdist, $semestre));
		return $sel;
	}
	
	public function get_form_tdist_semestre() {
		$form = $this->form;
        if ($link===null) {
			$form->addElement('hidden','cont',$link);
        }
		$form->addElement($this->armarFormTdistSemestre());	  
		$form->addRule('data','Debe seleccionar un tipo de distribuidora', 'required', null, 'client');		
	    return $form;
	}
	
    public function get_form_empresa_semestre($link=null,$aEmp=false,$aSem=false)  // el valor de $link es $_GET['cont']
    {														
        //$form = $this->form;
        $form = new HTML_QuickForm('form','get',$_SERVER['REQUEST_URI']);
        if ($link===null) {
			$form->addElement('hidden','cont',$link);
        }
		$form->addElement($this->armarFormEmpSemestre('data','Empresa Distribuidora: ',null,'Semestre: ',$aEmp,$aSem));	  
		if (!$aEmp)
			$form->addRule('data','Debe seleccionar una empresa', 'required', null, 'client');		
	    return $form;
    }
    public function get_form_empresa_semestre2()  // el valor de $link es $_GET['cont']
    {														
        $form = $this->form;
        
		$sel = $this->armarFormEmpSemestre();
		$selectsHS = $sel->getElements();
   		$selectsHS[0]->updateAttributes(array('id' => 'empresa'));
		
		$form->addElement($sel);

	    $form->addRule('data','Debe seleccionar una empresa', 'required', null, 'client');		
	    return $form;
    }
    	
	public function get_form_empresa_semestre_sucursal($link=null,$aSuc = true)  // el valor de $link es $_GET['cont'] $aSuc = Permitir ver todas las sucursales
    {	
		$form = $this->form;
        $form->addElement('hidden','cont',$link);
		$sel = $form->addElement($this->armarFormEmpSemestre());    
		$form->addRule('data','Debe seleccionar una empresa', 'required', null, 'client');
		
		$sel_suc =& $form->addElement('select','suc','Sucursal: ',null,array('id'=>'suc'));				
			
		$data = $_GET['data'];	
		
		if ($data[0]) {		
			//echo data;
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
			
    	return $form;
    }


 	public function get_form_empresa_semestre_sucursal_fm($link,$aSuc = true)  // el valor de $link es $_GET['cont'] $aSuc = Permitir ver todas las sucursales
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
   		$selectsHS[1]->updateAttributes(array('id' => 'sem'));
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
			
    	return $form;
    }

     public function get_form_empresa_semestre_sucursal_elemento($link,$aSuc = true)  // el valor de $link es $_GET['cont'] $aSuc = Permitir ver todas las sucursales
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

        $do_elemento = DB_DataObject::factory('elemento_mt');
        $do_elemento->orderBy('elemento_descripcion');
        $do_elemento->find();
        $elementos = array();
        $elementos[0] = "Seleccione un elemento";
        while($do_elemento->fetch()){
            $elementos[$do_elemento->elemento_id] = $do_elemento->elemento_codigo.' - '.$do_elemento->elemento_descripcion;
        }

        $form->addElement('select','elemento','Elemento MT:',$elementos);

        return $form;
    }

     public function get_form_empresa_semestre_sucursal_codigo($link,$aSuc = true)  // el valor de $link es $_GET['cont'] $aSuc = Permitir ver todas las sucursales
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

//        $do_elemento = DB_DataObject::factory('cortes_por_ct');
//        $do_elemento->groupBy('cortesxct_cod_elem_mt_int');
//        $do_elemento->find();
//        $elementos = array();
//        $elementos[0] = "Seleccione un codigo de elemento";
//        while($do_elemento->fetch()){
//            $elementos[$do_elemento->cortesxct_cod_elem_mt_int] = $do_elemento->cortesxct_cod_elem_mt_int;
//        }
       
        $form->addElement('text','elemento','Codigo de elemento:');

        return $form;
    }
}
