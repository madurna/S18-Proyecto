<?php
/**
 * Table Definition for empleado
 */
require_once 'DB/DataObject.php';

class DataObjects_Empleado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'empleado';            // table name
    public $empleado_id;                     // int(11)  not_null primary_key auto_increment group_by
    public $empleado_legajo;                 // varchar(100)  not_null
    public $empleado_nombre;                 // varchar(200)  not_null
    public $empleado_apellido;               // varchar(200)  not_null
    public $empleado_tipo_documento_id;      // int(11)  not_null multiple_key group_by
    public $empleado_numero_documento;       // int(11)  not_null group_by
    public $empleado_domicilio_calle;        // varchar(200)  not_null
    public $empleado_domicilio_numero;       // varchar(11)  not_null
    public $empleado_domicilio_piso;         // varchar(11)  not_null
    public $empleado_domicilio_departamento;    // varchar(11)  not_null
    public $empleado_domicilio_localidad_id;    // int(11)  not_null multiple_key group_by
    public $empleado_empresa_id;             // int(11)  not_null multiple_key group_by
    public $empleado_sexo_id;                // int(11)  not_null multiple_key group_by
    public $empleado_nacionalidad_id;        // int(11)  not_null multiple_key group_by
    public $empleado_fecha_nacimiento;       // date(10)  not_null
    public $empleado_fecha_ingreso;          // date(10)  not_null
    public $empleado_fecha_antiguedad;       // date(10)  not_null
    public $empleado_estado_civil_id;        // int(11)  not_null multiple_key group_by
    public $empleado_ubicacion_laboral_id;    // int(11)  not_null group_by
    public $empleado_puesto_id;              // int(11)  not_null group_by
    public $empleado_convenio_id;            // int(11)  not_null multiple_key group_by
    public $empleado_cuil;                   // varchar(13)  not_null
    public $empleado_afiliado;               // tinyint(1)  not_null group_by
    public $empleado_estudio_id;             // int(11)  not_null multiple_key group_by
    public $empleado_categoria_id;           // varchar(200)  not_null
    public $empleado_telefono;               // varchar(200)  
    public $empleado_celular;                // varchar(200)  
    public $empleado_mail;                   // varchar(200)  
    public $empleado_fuero_gremial;          // tinyint(1)  group_by
    public $empleado_baja;                   // tinyint(1)  group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Empleado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	public $fb_fieldLabels = array (
		'empleado_legajo' => 'Legajo: ',
		'empleado_nombre' => 'Nombre: ',
		'empleado_apellido' => 'Apellido: ',
		'empleado_tipo_documento_id' => 'Tipo de Documento: ',
		'empleado_numero_documento' => 'Numero de Documento: ',
		'empleado_domicilio_calle' => 'Calle: ',
		'empleado_domicilio_numero' => 'N&uacute;mero: ',
		'empleado_domicilio_piso' => 'Piso: ',
		'empleado_domicilio_departamento' => 'Departamento: ',
		'empleado_domicilio_localidad_id' => 'Localidad: ',
		'empleado_empresa_id' => 'Empresa: ',
		'empleado_sexo_id' => 'Sexo: ',
		'empleado_nacionalidad_id' => 'Nacionalidad: ',
		'empleado_fecha_nacimiento' => 'Fecha de Nacimiento: ',
		'empleado_fecha_ingreso' => 'Fecha de Ingreso: ',
		'empleado_fecha_antiguedad' => 'Fecha de Antigûedad: ',
		'empleado_estado_civil_id' => 'Estado Civil ',
		'empleado_ubicacion_laboral_id' => 'Ubicaci&oacute;n Laboral: ',
		'empleado_puesto_id' => 'Puesto: ',
		'empleado_convenio_id' => 'Convenio: ',
		'empleado_cuil' => 'CUIL: ',
		'empleado_afiliado' => '¿Es Afiliado?: ',
		'empleado_estudio_id' => 'Estudios Alcanzados: ',
		'empleado_categoria_id' => 'Categor&iacute;a: ',
		'empleado_telefono' => 'Tel&eacute;fono: ',
		'empleado_celular' => 'Celular: ',
		'empleado_mail' => 'Mail: ',
		'empleado_fuero_gremial' => '¿Posee fuero gremial?: '
    );
	
	function preGenerateForm(&$fb) {
		//fecha de nacimiento
		$aux =  HTML_QuickForm::createElement('text', 'empleado_fecha_nacimiento', 'Fecha de Nacimiento: ', array('id' => 'empleado_fecha_nacimiento', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD/MM/AAAA'));
    	$this -> fb_preDefElements['empleado_fecha_nacimiento'] = $aux;
		//

		//fecha de ingreso
		$aux =  HTML_QuickForm::createElement('text', 'empleado_fecha_ingreso', 'Fecha de Ingreso: ', array('id' => 'empleado_fecha_ingreso', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD/MM/AAAA'));
    	$this -> fb_preDefElements['empleado_fecha_ingreso'] = $aux;
		//
		
		//fecha de antiguedad
		$aux =  HTML_QuickForm::createElement('text', 'empleado_fecha_antiguedad', 'Fecha de Antigûedad: ', array('id' => 'empleado_fecha_antiguedad', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD/MM/AAAA'));
    	$this -> fb_preDefElements['empleado_fecha_antiguedad'] = $aux;
		//

		//obtengo el id de empresa, convenio y categoria
		if ($_GET['accion'] == 'm'){
			$indice1 = $this -> empleado_empresa_id;
			$indice2 = $this -> empleado_convenio_id;
			$indice3 = $this -> empleado_categoria_id;
		}
		else{
			$indice1 = 0;
			$indice2 = 0;
			$indice3 = 0;
		}
		//
		
		//hierselect de empresa - convenio - categoría
		
		//armo los 3 vectores
		$empresas = array();
		$empresas[0] = 'Seleccione Empresa';
		$convenios = array();
		$convenios[0][0] = 'Seleccione Convenio';
		$categorias = array();
		$categorias[0][0][0] = 'Seleccione Categor&iacute;a';
		//
		
		//recorro las empresas
		$do_empresa = DB_DataObject::factory('empresa');
		$do_empresa -> orderBy('empresa_nombre ASC');
		$do_empresa -> find();
		while ($do_empresa -> fetch()){
			//armo vectores
			$empresas[$do_empresa -> empresa_id] = $do_empresa -> empresa_nombre;
			$convenios[$do_empresa -> empresa_id][0] = 'Seleccione Convenio';
			$categorias[$do_empresa -> empresa_id][0][0] = 'Seleccione Categor&iacute;a';
			//
			
			//recorro los convenios para la empresa que estoy recorriendo
			$do_convenio_empresa = DB_DataObject::factory('convenio_empresa');
			$do_convenio = DB_DataObject::factory('convenio');
			$do_convenio_empresa  -> joinAdd($do_convenio);
			$do_convenio_empresa -> convenio_empresa_empresa_id = $do_empresa -> empresa_id;
			$do_convenio_empresa -> orderBy('convenio_nombre ASC');
			$do_convenio_empresa -> find();
			while ($do_convenio_empresa -> fetch()){
				//armo vectores
				$categorias[$do_empresa -> empresa_id][$do_convenio_empresa -> convenio_empresa_id][0] = 'Seleccione Categor&iacute;a';
				$convenios[$do_empresa -> empresa_id][$do_convenio_empresa -> convenio_empresa_id] = $do_convenio_empresa -> convenio_nombre;
				//
				
				//recorro las categorias para la empresa-convenio que estoy recorriendo
				$do_categoria = DB_DataObject::factory('categoria_convenio_empresa');
				$do_categoria -> categoria_convenio_empresa_id = $do_convenio_empresa -> convenio_empresa_id;
				$do_categoria -> orderBy('categoria_nombre ASC');
				$do_categoria -> find();
				while ($do_categoria -> fetch()){
					//armo vector
					$categorias[$do_empresa -> empresa_id][$do_convenio_empresa -> convenio_empresa_id][$do_categoria -> categoria_id] = $do_categoria -> categoria_nombre;
					//
				}
				//
			}
			//
		}
		//
		
		//reemplazo el campo de "empleado_empresa_id" por el hierselect
		$aux =  HTML_QuickForm::createElement('hierselect', 'empleado_empresa_i', 'Empresa/Convenio/Categor&iacute;a',null,'<br/>');
		$aux -> setOptions(array($empresas, $convenios,$categorias));
		$aux -> setValue(array($indice1,$indice2,$indice3));
		$this -> fb_preDefElements['empleado_empresa_id'] = $aux;
		//
		
		//select de afiliado
		$afiliado_select = array('0'=>'No','1'=>'Si');
    	$aux =  HTML_QuickForm::createElement('select', 'empleado_afiliado', '¿Es afiliado?: ', $afiliado_select, array('id' => 'empleado_afiliado'));    		
    	$this -> fb_preDefElements['empleado_afiliado'] = $aux;
		//
		
		//select de fuero gremial
		$fg_select = array('0'=>'No','1'=>'Si');
    	$aux =  HTML_QuickForm::createElement('select', 'empleado_fuero_gremial', '¿Posee fuero gremial?: ', $fg_select, array('id' => 'empleado_fuero_gremial'));
    	$this -> fb_preDefElements['empleado_fuero_gremial'] = $aux;
		//
	}
	
	function postGenerateForm(&$frm,&$fb) {
		//funcion para el datepicker
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
						yearRange:"1920:+1",
						showOn: "button",
						buttonImageOnly: true,
						buttonImage: "../img/spirit20_icons/calendar.png"
					};

					$.datepicker.setDefaults($.datepicker.regional["es"]);
				});

				$(document).ready(function() {
					$(".datepicker").datepicker();
				});
		
				$(document).ready(function(){
					$("[id*=verDet]").click(function(event){
						event.preventDefault();
						var id = $(this).attr("id");
						id = id.replace("verDet", "");
						$("#det"+id).show(1500);
						$("#linkVerDet"+id).hide();
						$("#linkOcultarDet"+id).show();
					});

					$("[id*=ocultarDet]").click(function(event){
						event.preventDefault();
						var id = $(this).attr("id");
						id = id.replace("ocultarDet", "");
						$("#det"+id).hide(1500);
						$("#linkVerDet"+id).show();
						$("#linkOcultarDet"+id).hide();
					});
				});
			</script>
		');
		//
		
		//recupero las fechas en la modificacion
		if ($_GET['accion'] == 'm'){
			list($anio,$mes,$dia) = explode("-",$this -> empleado_fecha_nacimiento);
			$fecha_nacimiento = $dia.'-'.$mes.'-'.$anio;
			list($anio,$mes,$dia) = explode("-",$this -> empleado_fecha_ingreso);
			$fecha_ingreso = $dia.'-'.$mes.'-'.$anio;
			list($anio,$mes,$dia) = explode("-",$this -> empleado_fecha_antiguedad);
			$fecha_antiguedad = $dia.'-'.$mes.'-'.$anio;		
			
			$frm-> addElement('html','
				<script type="text/javascript">
					$(document).ready(function() {
						var fecha_nacimiento = "'.$fecha_nacimiento.'";
						var fecha_ingreso = "'.$fecha_ingreso.'";
						var fecha_antiguedad = "'.$fecha_antiguedad.'";
						$("#empleado_fecha_nacimiento").datepicker("setDate", fecha_nacimiento);
						$("#empleado_fecha_ingreso").datepicker("setDate", fecha_ingreso);
						$("#empleado_fecha_antiguedad").datepicker("setDate", fecha_antiguedad);
					});
				</script>
			');
		}
		//
	}
}
