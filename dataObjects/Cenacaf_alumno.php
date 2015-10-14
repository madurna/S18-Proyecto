<?php
/**
 * Table Definition for cenacaf_alumno
 */
require_once 'DB/DataObject.php';

class DataObjects_Cenacaf_alumno extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cenacaf_alumno';      // table name
    public $cenacaf_alumno_id;               // int(11)  not_null primary_key auto_increment group_by
    public $cenacaf_alumno_nombre;           // varchar(45)  not_null
    public $cenacaf_alumno_apellido;         // varchar(45)  not_null
    public $cenacaf_alumno_tipo_documento_id;    // int(11)  not_null multiple_key group_by
    public $cenacaf_alumno_numero_documento;    // varchar(11)  not_null
    public $cenacaf_alumno_legajo;           // varchar(100)  
    public $cenacaf_alumno_linea_id;         // int(11)  not_null multiple_key group_by
    public $cenacaf_alumno_empresa;          // varchar(45)  
    public $cenacaf_alumno_base;             // varchar(45)  
    public $cenacaf_alumno_puesto;           // varchar(45)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cenacaf_alumno',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_fieldLabels = array (
		'cenacaf_alumno_nombre' => 'Nombre del Alumno: ',
		'cenacaf_alumno_apellido' => 'Apellido del Alumno',
		'cenacaf_alumno_tipo_documento_id' => 'Tipo de Documento: ',
		'cenacaf_alumno_numero_documento' => 'N&uacute;mero de Documento: ',
		'cenacaf_alumno_legajo' => 'Legajo: ',
		'cenacaf_alumno_linea_id' => 'L&iacute;nea: ',
		'cenacaf_alumno_empresa' => 'Empresa: ',
		'cenacaf_alumno_base' => 'Base: ',
		'cenacaf_alumno_puesto' => 'Puesto: '
    );

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
			</script>
		');
			
		//seteo la fecha
		if ($_GET['accion']=='m'){
			//obtengo fecha y curso
			$cenacaf_curso_alumno = DB_DataObject::factory('cenacaf_curso_alumno');
			$cenacaf_curso_alumno -> cenacaf_curso_alumno_alumno_id = $_GET['contenido'];
			$cenacaf_curso_alumno -> find(true);
			$fecha_db = $cenacaf_curso_alumno -> cenacaf_curso_alumno_fecha;
			$curso_db = $cenacaf_curso_alumno -> cenacaf_curso_alumno_curso_id;
			//
			
			//seteo fecha
			list($anio,$mes,$dia) = explode("-",$fecha_db);
			$fecha_seteada = $dia.'-'.$mes.'-'.$anio;
			//
		}
		else{
			$fecha_seteada = date('d-m-Y');
			$curso_db = '';
		}
		//
			
		//agrego fecha antes del nombre
		$frm->insertElementBefore($frm-> createElement('text', 'cenacaf_curso_alumno_fecha', 'Fecha : ', array('id' => 'cenacaf_curso_alumno_fecha', 'class' => 'datepicker', 'title' => 'DD/MM/AAAA', )), 'cenacaf_alumno_nombre');
		//
		
		//agrego curso antes del nombre
		$do_cenacaf_curso = DB_DataObject::factory('cenacaf_curso');
		$cursos = $do_cenacaf_curso -> get_cursos();
		$aux =& $frm-> createElement('select','cenacaf_curso_alumno_curso_id','Curso: ',$cursos,array('id' => 'cenacaf_curso_alumno_curso_id'));
		$aux -> setSelected($curso_db);
		$frm->insertElementBefore($aux, 'cenacaf_alumno_nombre');
		//
		
		//funcion para setear la fecha
		$frm-> addElement('html','
			<script type="text/javascript">
				$(document).ready(
					function() {
						var fecha_seteada = "'.$fecha_seteada.'";
						$("#cenacaf_curso_alumno_fecha").datepicker("setDate", fecha_seteada);
					}
				);
			</script>
		');
		//
	}
}
