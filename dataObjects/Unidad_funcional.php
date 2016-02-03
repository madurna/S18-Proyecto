<?php
/**
 * Table Definition for unidad_funcional
 */
require_once 'DB/DataObject.php';

class DataObjects_Unidad_funcional extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'unidad_funcional';    // table name
    public $unidad_funcional_id;             // int(11)  not_null primary_key auto_increment group_by
    public $unidad_funcional_obra_civil_id;    // int(11)  not_null multiple_key group_by
    public $unidad_funcional_cantidad_ambientes;    // int(11)  not_null group_by
    public $unidad_funcional_coeficiente;    // double(5)  not_null group_by
    public $unidad_funcional_departamento;    // varchar(50)  not_null
    public $unidad_funcional_estado_uf_id;    // int(11)  not_null multiple_key group_by
    public $unidad_funcional_dimensiones;    // varchar(100)  not_null
    public $unidad_funcional_monto;          // double(20)  not_null group_by
    public $unidad_funcional_observacion;    // varchar(255)  not_null
    public $unidad_funcional_piso;           // varchar(50)  not_null
    public $unidad_funcional_cliente_id;     // int(11)  multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    public $fb_linkDisplayFields = array('unidad_funcional_piso','unidad_funcional_departamento');
    
    var $fb_preDefOrder = array(
        'unidad_funcional_piso',
        'unidad_funcional_departamento',
        'unidad_funcional_cantidad_ambientes',
        'unidad_funcional_coeficiente',
        'unidad_funcional_dimensiones',
        'unidad_funcional_monto',
        'unidad_funcional_observacion',
        'unidad_funcional_estado_uf_id'

    );
    
    public $fb_fieldLabels = array (
        'unidad_funcional_piso' => 'Piso: ',
        'unidad_funcional_departamento' => 'Depto: ',
        'unidad_funcional_cantidad_ambientes' => 'Ambientes: ',
        'unidad_funcional_coeficiente' => 'Coeficiente: ',
        'unidad_funcional_dimensiones' => 'Dimensiones: ',
        'unidad_funcional_monto' => 'Valor: ',
        'unidad_funcional_observacion' => 'Observaci&oacute;n: ',
        'unidad_funcional_estado_uf_id' => 'Estado: '
    );
    
    function preGenerateForm(&$fb) {

        //tipo documento
        $this -> unidad_funcional_observacion = utf8_encode($this->unidad_funcional_observacion);
        //
        
        if ($_GET['accion']){
            $this -> unidad_funcional_observacion = utf8_encode($this->unidad_funcional_observacion);
        }
    }

        function postGenerateForm(&$frm,&$fb) { 
        
        $frm-> addElement('html','
            
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
                        yearRange:"2013:+2",
                        showOn: "button",
                        buttonImageOnly: true,
                        buttonImage: "../img/spirit20_icons/calendar.png"
                    };

                    $.datepicker.setDefaults($.datepicker.regional["es"]);
                });

                $(document).ready(function() {
                    $(".datepicker").datepicker();
                });

            </script>');
            
            
            //$frm->addRule('cliente_cuil', 'El CUIL debe tener 11 digitos', 'minlength', 11, 'client');
            //modificacion-eliminacion
            if ($_GET['contenido']){
                               
                $num=$this->unidad_funcional_id;
               
            }
            else{
                //alta
                if (!($_GET['contenido'])) {
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
                    
                    $unidad_funcional=DB_DataObject::factory('unidad_funcional');
                    $unidad_funcional->orderBy('unidad_funcional_id DESC');
                    $unidad_funcional->find(true);
                    $num=$unidad_funcional->unidad_funcionsal_id+1;
                }
                else{
                    //ver
                    $num=$this->unidad_funcional_id;
                }
            }
            
            $frm->insertElementBefore($frm-> createElement('html','<tr><td style="text-align:right"><b>N&uacute;mero: </b></td><td>'.$num.'</td></tr>'), 'unidad_funcional_piso');
            
    }




}

