<?php
/**
 * Table Definition for servicio_tecnico
 */
require_once 'DB/DataObject.php';

class DataObjects_Servicio_tecnico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'servicio_tecnico';    // table name
    public $servicio_tecnico_id;             // int(11)  not_null primary_key auto_increment group_by
    public $servicio_tecnico_fecha_estimada_inicio;    // date(10)  not_null
    public $servicio_tecnico_precio_estimado;    // float(12)  not_null group_by
    public $servicio_tecnico_estado_id;      // int(11)  not_null multiple_key group_by
    public $servicio_tecnico_descripcion;    // varchar(300)  
    public $id_planta_contrato;              // int(11)  group_by
    public $id_planta_cliente;               // int(11)  group_by
    public $servicio_tecnico_fecha_alta;     // date(10)  not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    var $fb_preDefOrder = array(
        'servicio_tecnico_fecha_estimada_inicio',
        'servicio_tecnico_precio_estimado',
        'servicio_tecnico_descripcion'
    );
    
    public $fb_fieldLabels = array (
        'servicio_tecnico_fecha_estimada_inicio' => 'Fecha Estimada de Inicio: ',
        'servicio_tecnico_precio_estimado' => 'Precio Estimado($): ',
        'servicio_tecnico_descripcion' => 'Descripci&oacute;n: '
    );

    function preGenerateForm(&$fb) {

        if ($_GET['ver'] == ''){
            
            //fecha inicio
            $aux =  HTML_QuickForm::createElement('text', 'servicio_tecnico_fecha_estimada_inicio', 'Fecha Estimada de Inicio: ', array('id' => 'servicio_tecnico_fecha_estimada_inicio', 'value' => '', 'size' => '20', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
            $this -> fb_preDefElements['servicio_tecnico_fecha_estimada_inicio'] = $aux;

            //descripcion
            $aux = HTML_QuickForm::createElement('textarea','servicio_tecnico_descripcion','Descripci&oacute;n: ',array('cols'=>'50','rows'=>'5','style'=>'resize:none;' ));
            $this -> fb_preDefElements['servicio_tecnico_descripcion'] = $aux;
            //
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
            
            //modificacion-eliminacion
            if ($_GET['contenido']){
                $fecha_inicio = fechaAntiISO($this -> servicio_tecnico_fecha_estimada_inicio);
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
                
            }else{
                //alta
                if (!($_GET['contenido'])) {
                    $fecha_inicio = date('d-m-Y');
                    $frm-> addElement('html','
                        <script type="text/javascript">
                            $(document).ready(
                                function(){
                                    var fecha_inicio = "'.$fecha_inicio.'";
                                    $("#servicio_tecnico_fecha_estimada_inicio").datepicker("setDate", fecha_inicio);
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
            
            //$frm->insertElementBefore($frm-> createElement('html','<tr><td style="text-align:right"><b>N&uacute;mero: </b></td><td>'.$num.'</td></tr>'), 'planta_direccion');

    }
}
