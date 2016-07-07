<?php
/**
 * Table Definition for clientes
 */
require_once 'DB/DataObject.php';

class DataObjects_Clientes extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'clientes';            // table name
    public $cliente_id;                      // int(11)  not_null primary_key auto_increment group_by
    public $cliente_apellido;                // varchar(255)  not_null
    public $cliente_nombre;                  // varchar(255)  not_null
    public $cliente_tipo_doc_id;             // int(11)  not_null multiple_key group_by
    public $cliente_nro_doc;                 // int(11)  not_null group_by
    public $cliente_direccion;               // varchar(255)  
    public $cliente_localidad_id;            // int(11)  multiple_key group_by
    public $cliente_fecha_inicio;            // date(10)  
    public $cliente_telefono;                // varchar(255)  
    public $cliente_estado_id;               // int(11)  multiple_key group_by
    public $cliente_fecha_nacimiento;        // date(10)  
    public $cliente_razon_social;            // varchar(45)  
    public $cliente_observacion;             // varchar(255)  
    public $cliente_cuenta_corriente;        // int(45)  group_by
    public $nro_contrato_id;                 // int(11)  group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	// Strips the UTF-8 mark: (hex value: EF BB BF)
	
	//public $fb_linkDisplayFields = array('cliente_apellido');
	
	var $fb_preDefOrder = array(
    	'cliente_apellido',
		'cliente_nombre',
		'cliente_razon_social',
		'cliente_tipo_doc_id',
		'cliente_nro_doc',
		'cliente_fecha_nacimiento',
		'cliente_direccion',
		'cliente_localidad_id',
		'cliente_fecha_inicio',
		'cliente_telefono',
		'cliente_cuenta_corriente',
		'cliente_estado_id',
		'cliente_observacion'		
    );
	
	public $fb_fieldLabels = array (
		'cliente_apellido' => 'Apellido: ',
		'cliente_nombre' => 'Nombre: ',
		'cliente_razon_social' => 'Razon Social: ',
		'cliente_tipo_doc_id' => 'Tipo Documento: ',
		'cliente_nro_doc' => 'N&uacute;mero de Documento: ',
		'cliente_direccion' => 'Domicilio: ',
		'cliente_localidad_id' => 'Localidad: ',
		'cliente_cuenta_corriente' => 'Cuenta Corriente: ',
		'cliente_fecha_inicio' => 'Fecha de Inicio: ',
		'cliente_telefono' => 'Telefono: ',
		'cliente_estado_id' => 'Estado: ',
		'cliente_fecha_nacimiento' => 'Fecha de Nacimiento: ',
		'cliente_observacion' => 'Obsevaci&oacute;n: '
    );
	
	function preGenerateForm(&$fb) {

		if ($_GET['ver'] == ''){
			//fecha inicio
			$aux =  HTML_QuickForm::createElement('text', 'cliente_fecha_inicio', 'Fecha inicio: ', array('id' => 'cliente_fecha_inicio', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
			$this -> fb_preDefElements['cliente_fecha_inicio'] = $aux;
				
			//fecha nacimiento
			$aux =  HTML_QuickForm::createElement('text', 'cliente_fecha_nacimiento', 'Fecha nacimiento: ', array('id' => 'cliente_fecha_nacimiento', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
			$this -> fb_preDefElements['cliente_fecha_nacimiento'] = $aux;
			//
		}

		//tipo documento
		$this -> cliente_tipo_doc_id = utf8_encode($this->cliente_tipo_doc_id);
		//
		
		//numero de documento
		$aux =  HTML_QuickForm::createElement('text', 'cliente_nro_doc', 'N&uacute;mero de Documento: ', array('id' => 'cliente_nro_doc', 'value' => '', 'size' => '8'));
		$this -> fb_preDefElements['cliente_nro_doc'] = $aux;
		//
		
		//cuenta corriente
		$aux =  HTML_QuickForm::createElement('text', 'cliente_cuenta_corriente', 'Cuenta Corriente: ', array('id' => 'cliente_cuenta_corriente', 'value' => '', 'size' => '11', 'maxlength' => '11'));
		$this -> fb_preDefElements['cliente_cuenta_corriente'] = $aux;
		//

		//descripcion
        $aux = HTML_QuickForm::createElement('textarea','cliente_observacion','Obsevaci&oacute;n: ',array('cols'=>'50','rows'=>'5','style'=>'resize:none;' ));
        $this -> fb_preDefElements['cliente_observacion'] = $aux;
        //
		
		if ($_GET['accion']){
			$this -> cliente_apellido = utf8_encode($this->cliente_apellido);
			$this -> cliente_nombre = utf8_encode($this->cliente_nombre);
			$this -> cliente_direccion = utf8_encode($this->cliente_direccion);
		}
	}
	
	function postGenerateForm(&$frm,&$fb) { 
		
		$frm-> addElement('html','
			
			<script type="text/javascript" src="../js/jquery-1.8.3.js"></script>
            <script type="text/javascript" src="../js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

			<script type="text/javascript">
				function trim(str) {
					return str.replace(/^\s*|\s*$/g,"");
				}
		
				jQuery(function($){
					
					$.datepicker.setDefaults($.datepicker);
				});

				$(document).ready(function() {
					$(".datepicker").datepicker();
				});
				
				function cargar_dni (cuil){
					var dni = cuil.substring(2, 10)
					var obj = document.getElementById("cliente_nro_doc");
					obj.value = dni;
				}
				
				function cargar_cuenta (cbu){
					var cuenta = cbu.substring(10, 21)
					var obj = document.getElementById("cliente_cuenta_bancaria");
					obj.value = cuenta;
				}
			</script>');
			
			
			//$frm->addRule('cliente_cuil', 'El CUIL debe tener 11 digitos', 'minlength', 11, 'client');
			//modificacion-eliminacion
			if ($_GET['accion']){ print_r($_GET['ver']);
				$fecha_inicio = fechaAntiISO($this -> cliente_fecha_inicio);
				$fecha_nacimiento = fechaAntiISO($this -> cliente_fecha_nacimiento);
				
				$frm-> addElement('html','
					<script type="text/javascript">
						$(document).ready(
							function(){
								var fecha_inicio = "'.$fecha_inicio.'";
								var fecha_nacimiento = "'.$fecha_nacimiento.'";
								$("#cliente_fecha_inicio").datepicker("setDate", "fecha_inicio");
								$("#cliente_fecha_nacimiento").datepicker("setDate", "fecha_nacimiento");
							}
						);
					</script>
				');//}
				
				//$this -> cliente_fecha_inicio = "KKKK";
				$num=$this->cliente_id;
				
			}
			else{
				//alta
				if ($_GET['ver'] == '') {
					$fecha_inicio = date('d-m-Y');
					$frm-> addElement('html','
						<script type="text/javascript">
							$(document).ready(
								function(){
									var fecha_inicio = "'.$fecha_inicio.'";
									$("#cliente_fecha_inicio").datepicker("setDate", fecha_inicio);
								}
							);
						</script>
					');
					
					$cli=DB_DataObject::factory('clientes');
					$cli->orderBy('cliente_id DESC');
					$cli->find(true);
					$num=$cli->cliente_id+1;
				}
				else{
					//ver
					$num=$this->cliente_id;
				}
			}
			
			$frm->insertElementBefore($frm-> createElement('html','<tr><td style="text-align:right"><b>N&uacute;mero: </b></td><td>'.$num.'</td></tr>'), 'cliente_apellido');
			
			//Agrega Reglas
			//$frm->addRule('cliente_CUIL', 'El CUIL debe tener 11 dígitos', 'minlength', 11, 'client');
			//$frm->addRule('cliente_CBU', 'El CBU debe tener 22 dígitos', 'minlength', 22, 'client');
			$frm->addRule('cliente_cuenta_corriente', 'El Nro. de Cuenta debe tener 11 dígitos', 'minlength', 11, 'client');
	
	}
	
    public function get_cliente($cliente_id){
    	$this -> cliente_id = $cliente_id;
    	if($this -> find(true))
			return $this -> cliente_nombre.' '.$this -> cliente_apellido;
	}
}
?>