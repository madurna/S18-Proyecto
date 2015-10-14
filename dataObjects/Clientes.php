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
    public $cliente_CUIL;                    // varchar(255)  
    public $cliente_CBU;                     // varchar(255)  
    public $cliente_fecha_inicio;            // date(10)  
    public $cliente_telefono;                // varchar(255)  
    public $cliente_estado_id;               // int(11)  multiple_key group_by
    public $cliente_fecha_nacimiento;        // date(10)  
    public $cliente_usuario_id;              // int(11)  group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Clientes',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	// Strips the UTF-8 mark: (hex value: EF BB BF)
	
	public $fb_linkDisplayFields = array('cliente_apellido');
	
	var $fb_preDefOrder = array(
    	'cliente_apellido',
		'cliente_nombre',
		'cliente_CUIL',
		'cliente_tipo_doc_id',
		'cliente_nro_doc',
		'cliente_fecha_nacimiento',
		'cliente_direccion',
		'cliente_localidad_id',
		'cliente_CP',
		'cliente_CBU',
		'cliente_cuenta_bancaria',
		'cliente_fecha_inicio',
		'cliente_telefono',
		'cliente_tel_fijo_celular',
		'cliente_tel_laboral1',
		'cliente_tel_laboral2',
		'cliente_referido1',
		'cliente_referido2',
		'cliente_estado_id',		
    );
	
	public $fb_fieldLabels = array (
		'cliente_apellido' => 'Apellido: ',
		'cliente_nombre' => 'Nombre: ',
		'cliente_tipo_doc_id' => 'Tipo Documento: ',
		'cliente_nro_doc' => 'N&uacute;mero de Documento: ',
		'cliente_direccion' => 'Domicilio: ',
		'cliente_localidad_id' => 'Localidad: ',
		'cliente_CP' => 'C&oacute;digo Postal: ',
		'cliente_CUIL' => 'CUIL: ',
		'cliente_cuenta_bancaria' => 'Cuenta Bancaria: ',
		'cliente_CBU' => 'CBU: ',
		'cliente_fecha_inicio' => 'Fecha de Inicio: ',
		'cliente_telefono' => 'Telefono: ',
		'cliente_tel_fijo_celular' => 'Celular: ',
		'cliente_tel_laboral1' => 'Tel. Laboral 1: ',
		'cliente_tel_laboral2' => 'Tel. Laboral 2: ',
		'cliente_referido1' => 'Referido 1: ',
		'cliente_referido2' => 'Referido 2: ',
		'cliente_estado_id' => 'Estado: ',
		'cliente_fecha_nacimiento' => 'Fecha de Nacimiento: ',
		'cliente_usuario_id' => 'Usuario',
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
		
		//CUIL
		$aux =  HTML_QuickForm::createElement('text', 'cliente_CUIL', 'CUIL: ', array('id' => 'cliente_CUIL', 'value' => '', 'size' => '11', 'maxlength' => '11', 'onChange' => 'cargar_dni(this.value)'));
		$this -> fb_preDefElements['cliente_CUIL'] = $aux;
		//
		
		//numero de documento
		$aux =  HTML_QuickForm::createElement('text', 'cliente_nro_doc', 'N&uacute;mero de Documento: ', array('id' => 'cliente_nro_doc', 'value' => '', 'size' => '8', 'readonly' => 'readonly'));
		$this -> fb_preDefElements['cliente_nro_doc'] = $aux;
		//
		
		//CBU
		$aux =  HTML_QuickForm::createElement('text', 'cliente_CBU', 'CBU: ', array('id' => 'cliente_CBU', 'value' => '', 'size' => '25', 'maxlength' => '22', 'onChange' => 'cargar_cuenta(this.value)'));
		$this -> fb_preDefElements['cliente_CBU'] = $aux;
		//
		
		//cuenta bancaria
		$aux =  HTML_QuickForm::createElement('text', 'cliente_cuenta_bancaria', 'Cuenta Bancaria: ', array('id' => 'cliente_cuenta_bancaria', 'value' => '', 'size' => '11', 'maxlength' => '11', 'readonly' => 'readonly'));
		$this -> fb_preDefElements['cliente_cuenta_bancaria'] = $aux;
		//
		
		if ($_GET['accion']){
			$this -> cliente_apellido = utf8_encode($this->cliente_apellido);
			$this -> cliente_nombre = utf8_encode($this->cliente_nombre);
			$this -> cliente_direccion = utf8_encode($this->cliente_direccion);
		}
	}
	
	function postGenerateForm(&$frm,&$fb) { 
		
		$frm-> addElement('html','
			
			<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/jquery-ui-1.8.4.custom.css" />
			<link type="text/css" rel="stylesheet" href="css/autocomplete_cliente/estilo.css" />
			<script type="text/javascript" src="js/autocomplete_cliente/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="js/autocomplete_cliente/jquery-ui-1.8.4.custom.min.js"></script>

			<script type="text/javascript">
				function trim(str) {
					return str.replace(/^\s*|\s*$/g,"");
				}
		
				jQuery(function($){
					$.datepicker.regional["es"] = {
						closeText: "Cerrar",
						prevText: "&#x3c;Ant",
						nextText: "Sig&#x3e;",
						currentText: "Hoy",
						monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
						"Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
						monthNamesShort: ["Ene","Feb","Mar","Abr","May","Jun",
						"Jul","Ago","Sep","Oct","Nov","Dic"],
						dayNames: ["Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado"],
						dayNamesShort: ["Dom","Lun","Mar","Mi&eacute;","Juv","Vie","S&aacute;b"],
						dayNamesMin: ["Do","Lu","Ma","Mi","Ju","Vi","S&aacute;"],
						weekHeader: "Sm",
						dateFormat: "dd-mm-yy",
						firstDay: 1,
						isRTL: false,
						showMonthAfterYear: false,
						yearSuffix: "",
						changeMonth: true,
						changeYear: true,
						yearRange:"1920:+2",
						showOn: "button",
						buttonImageOnly: true,
						buttonImage: "../img/spirit20_icons/calendar.png"
					};

					$.datepicker.setDefaults($.datepicker.regional["es"]);
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
			if ($_GET['accion']){
				$fecha_inicio = fechaAntiISO($this -> cliente_fecha_inicio);
				$fecha_nacimiento = fechaAntiISO($this -> cliente_fecha_nacimiento);
				
				$frm-> addElement('html','
					<script type="text/javascript">
						$(document).ready(
							function(){
								var fecha_inicio = "'.$fecha_inicio.'";
								var fecha_nacimiento = "'.$fecha_nacimiento.'";
								$("#cliente_fecha_inicio").datepicker("setDate", fecha_inicio);
								$("#cliente_fecha_nacimiento").datepicker("setDate", fecha_nacimiento);
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
			$frm->addRule('cliente_CUIL', 'El CUIL debe tener 11 dígitos', 'minlength', 11, 'client');
			$frm->addRule('cliente_CBU', 'El CBU debe tener 22 dígitos', 'minlength', 22, 'client');
			$frm->addRule('cliente_cuenta_bancaria', 'El Nro. de Cuenta debe tener 11 dígitos', 'minlength', 11, 'client');
	
	}
	
    public function get_cliente($cliente_id){
    	$this -> cliente_id = $cliente_id;
    	if($this -> find(true))
			return $this -> cliente_nombre.' '.$this -> cliente_apellido;
	}
}
?>