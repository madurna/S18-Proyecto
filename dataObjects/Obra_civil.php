<?php
/**
 * Table Definition for obra_civil
 */
require_once 'DB/DataObject.php';

class DataObjects_Obra_civil extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'obra_civil';          // table name
    public $obra_civil_id;                  // int(11) not_null primary_key auto_increment group_by
    public $obra_civil_cantidad_pisos;      // int(11) not_null group_by
    public $obra_civil_direccion;           // varchar(45) not_null
    public $obra_civil_fecha_fin;           // date(10) not_null
    public $obra_civil_fecha_inicio;        // date(10) not_null
    public $obra_civil_dimensiones_terreno;   // varchar(45) not_null
    public $obra_civil_valor_compra;        // float(12) not_null group_by
    public $obra_civil_estado_id;           // int(11) not_null multiple_key group_by
    public $obra_civil_localidad_id;        // int(11) not_null multiple_key group_by
    public $obra_civil_descripcion;         // varchar(200) not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    public $fb_linkDisplayFields = array('obra_civil_direccion');
    
    var $fb_preDefOrder = array(
        'obra_civil_descripcion',
        'obra_civil_direccion',
        'obra_civil_cantidad_pisos',
        'obra_civil_fecha_inicio',
        'obra_civil_fecha_fin',
        'obra_civil_dimensiones_terreno',
        'obra_civil_valor_compra',
        'obra_civil_estado_id',
        'obra_civil_localidad_id'
    );
    
    public $fb_fieldLabels = array (
        'obra_civil_cantidad_pisos' => 'Cantidad de pisos: ',
        'obra_civil_direccion' => 'Direcci&oacute;n: ',
        'obra_civil_fecha_fin' => 'Fecha de fin: ',
        'obra_civil_fecha_inicio' => 'Fecha de inicio: ',
        'obra_civil_dimensiones_terreno' => 'Dimensiones de terreno: ',
        'obra_civil_valor_compra' => 'Valor de compra',
        'obra_civil_estado_id' => 'Estado: ',
        'obra_civil_localidad_id' => 'Localidad: ',
        'obra_civil_descripcion' => 'Descripci&oacute;n: ',
    );
    
    function preGenerateForm(&$fb) {

        if ($_GET['ver'] == ''){
            //fecha fin
            $aux =  HTML_QuickForm::createElement('text', 'obra_civil_fecha_fin', 'Fecha fin: ', array('id' => 'obra_civil_fecha_fin', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
            $this -> fb_preDefElements['obra_civil_fecha_fin'] = $aux;
                
            //fecha inicio
            $aux =  HTML_QuickForm::createElement('text', 'obra_civil_fecha_inicio', 'Fecha inicio: ', array('id' => 'obra_civil_fecha_inicio', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
            $this -> fb_preDefElements['obra_civil_fecha_inicio'] = $aux;
            //
        }

        //tipo documento
        $this -> obra_civil_dimensiones_terreno = utf8_encode($this->obra_civil_dimensiones_terreno);
        //
        
        if ($_GET['accion']){
            $this -> obra_civil_direccion = utf8_encode($this->obra_civil_direccion);
            $this -> obra_civil_descripcion = utf8_encode($this->obra_civil_descripcion);
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
                $fecha_inicio = fechaAntiISO($this -> obra_civil_fecha_inicio);
                $fecha_fin = fechaAntiISO($this -> obra_civil_fecha_fin);
                
                $frm-> addElement('html','
                    <script type="text/javascript">
                        $(document).ready(
                            function(){
                                var fecha_inicio = "'.$fecha_inicio.'";
                                var fecha_fin = "'.$fecha_fin.'";
                                $("#obra_civil_fecha_inicio").datepicker("setDate", fecha_inicio);
                                $("#obra_civil_fecha_fin").datepicker("setDate", fecha_fin);
                            }
                        );
                    </script>
                ');//}
                
                $num=$this->obra_civil_id;
                
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
                    
                    $obra_civil=DB_DataObject::factory('obra_civil');
                    $obra_civil->orderBy('obra_civil_id DESC');
                    $obra_civil->find(true);
                    $num=$obra_civil->obra_civil_id+1;
                }
                else{
                    //ver
                    $num=$this->obra_civil_id;
                }
            }
            
            $frm->insertElementBefore($frm-> createElement('html','<tr><td style="text-align:right"><b>N&uacute;mero: </b></td><td>'.$num.'</td></tr>'), 'obra_civil_descripcion');

    }




}
