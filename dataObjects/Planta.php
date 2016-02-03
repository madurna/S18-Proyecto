<?php
/**
 * Table Definition for planta
 */
require_once 'DB/DataObject.php';

class DataObjects_Planta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'planta';              // table name
    public $planta_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $planta_color;                    // varchar(45)  not_null
    public $planta_direccion;                // varchar(45)  not_null
    public $planta_fecha_fin;                // date(10)  not_null
    public $planta_fecha_inicio;             // date(10)  not_null
    public $planta_precio_estimado;          // float(12)  not_null group_by
    public $planta_estado_id;                // int(11)  not_null multiple_key group_by
    public $planta_localidad_id;             // int(11)  not_null multiple_key group_by
    public $planta_descripcion;              // varchar(200)  

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    //public $fb_linkDisplayFields = array('obra_civil_direccion');
    
    var $fb_preDefOrder = array(
        'planta_direccion',
        'planta_fecha_inicio',
        'planta_fecha_fin',
        'planta_precio_estimado',
        'planta_color',
        'planta_estado_id',
        'planta_localidad_id',
        'planta_descripcion'
    );
    
    public $fb_fieldLabels = array (
        'planta_direccion' => 'Lugar de Instalacci&oacute;n: ',
        'planta_fecha_fin' => 'Fecha Estimada de fin: ',
        'planta_fecha_inicio' => 'Fecha Estimada de Instalacci&oacute;n: ',
        'planta_precio_estimado' => 'Precio Estimado: ',
        'planta_estado_id' => 'Estado: ',
        'planta_localidad_id' => 'Localidad: ',
        'planta_descripcion' => 'Descripci&oacute;n: ',
        'planta_color' => 'Color Planta: '
    );
    
    function preGenerateForm(&$fb) {

        if ($_GET['ver'] == ''){
            //fecha fin
            $aux =  HTML_QuickForm::createElement('text', 'planta_fecha_fin', 'Fecha Estimada de fin: ', array('id' => 'planta_fecha_fin', 'value' => '', 'readonly' => 'readonly', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
            $this -> fb_preDefElements['planta_fecha_fin'] = $aux;
                
            //fecha inicio
            $aux =  HTML_QuickForm::createElement('text', 'planta_fecha_inicio', 'Fecha Estimada de Instalacci&oacute;n: ', array('id' => 'planta_fecha_inicio', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
            $this -> fb_preDefElements['planta_fecha_inicio'] = $aux;
            //

            //descripcion
            $aux = HTML_QuickForm::createElement('textarea','planta_descripcion','Descripci&oacute;n: ',array('cols'=>'50','rows'=>'5','style'=>'resize:none;' ));
            //$aux =  HTML_QuickForm::createElement('text', 'planta_fecha_inicio', 'Fecha Estimada de Instalacci&oacute;n: ', array('id' => 'planta_fecha_inicio', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
            $this -> fb_preDefElements['planta_descripcion'] = $aux;
            //
        }
        
        if ($_GET['accion']){
            $this -> planta_direccion = utf8_encode($this->planta_direccion);
            $this -> planta_descripcion = utf8_encode($this->planta_descripcion);
        }
    }

        function postGenerateForm(&$frm,&$fb) { 
        
        $frm-> addElement('html','
            
            <script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
            <script type="text/javascript" src="../js/jqueryui/js/jquery-ui-1.8.11.custom.min.js"></script>

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
                $fecha_inicio = fechaAntiISO($this -> planta_fecha_inicio);
                $fecha_fin = fechaAntiISO($this -> planta_fecha_fin);
                
                $frm-> addElement('html','
                    <script type="text/javascript">
                        $(document).ready(
                            function(){
                                var fecha_inicio = "'.$fecha_inicio.'";
                                var fecha_fin = "'.$fecha_fin.'";
                                $("#planta_fecha_inicio").datepicker("setDate", fecha_inicio);
                                $("#planta_fecha_fin").datepicker("setDate", fecha_fin);
                            }
                        );
                    </script>
                ');//}
                
                $num=$this->planta_id;
                
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
                    
                    $planta=DB_DataObject::factory('planta');
                    $planta->orderBy('planta_id DESC');
                    $planta->find(true);
                    $num=$planta->planta_id+1;
                }
                else{
                    //ver
                    $num=$this->planta_id;
                }
            }
            
            $frm->insertElementBefore($frm-> createElement('html','<tr><td style="text-align:right"><b>N&uacute;mero: </b></td><td>'.$num.'</td></tr>'), 'planta_direccion');

    }
}
