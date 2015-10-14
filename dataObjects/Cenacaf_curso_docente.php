<?php
/**
 * Table Definition for cenacaf_curso_docente
 */
require_once 'DB/DataObject.php';

class DataObjects_Cenacaf_curso_docente extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cenacaf_curso_docente';    // table name
    public $cenacaf_curso_docente_id;        // int(11)  not_null primary_key auto_increment group_by
    public $cenacaf_curso_docente_fecha;     // date(10)  not_null
    public $cenacaf_curso_docente_curso_id;    // int(11)  not_null multiple_key group_by
    public $cenacaf_curso_docente_docente_id;    // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cenacaf_curso_docente',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_fieldLabels = array (
		'cenacaf_curso_docente_fecha' => 'Fecha del Curso: ',
		'cenacaf_curso_docente_curso_id' => 'Curso: ',
		'cenacaf_curso_docente_docente_id' => 'Docente: '
    );
	
	function preGenerateForm(&$fb) {
		//fecha
		$aux =  HTML_QuickForm::createElement('text', 'cenacaf_curso_docente_fecha', 'Fecha del Curso: ', array('id' => 'cenacaf_curso_docente_fecha', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD/MM/AAAA'));
    	$this -> fb_preDefElements['cenacaf_curso_docente_fecha'] = $aux;
    	//
	}
	
	function postGenerateForm(&$frm,&$fb) {
		$fecha_hoy = date('d-m-Y');
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
						changeYear: false,
						yearRange:"+1:+2",
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
				
				$(document).ready(
					function() {
						var fecha = "'.$fecha_hoy.'";
						$("#cenacaf_curso_docente_fecha").datepicker("setDate", fecha);
					}
				);
			</script>
		');
	}
}