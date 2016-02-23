<?php
/**
 * Table Definition for obrero
 */
require_once 'DB/DataObject.php';

class DataObjects_Obrero extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'obrero';              // table name
    public $obrero_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $obrero_apellido;                 // varchar(255)  not_null
    public $obrero_nombre;                   // varchar(255)  not_null
    public $obrero_tipo_doc_id;              // int(11)  not_null multiple_key group_by
    public $obrero_nro_doc;                  // int(11)  not_null group_by
    public $obrero_direccion;                // varchar(255)  
    public $obrero_localidad_id;             // int(11)  not_null multiple_key group_by
    public $obrero_CP;                       // varchar(255)  
    public $obrero_CUIL;                     // varchar(255)  
    public $obrero_CBU;                      // varchar(255)  
    public $obrero_fecha_inicio;             // date(10)  
    public $obrero_telefono;                 // varchar(255)  
    public $obrero_estado;                   // varchar(255)  
    public $obrero_fecha_nacimiento;         // date(10)  
    public $obrero_usuario_id;               // int(11)  multiple_key group_by
    public $obrero_categoria_id;             // int(11)  multiple_key group_by
    public $obrero_puesto_id;                // int(11)  multiple_key group_by
    public $obrero_obrero_especialidad_id;    // int(11)  multiple_key group_by
    public $obrero_estudio_alcanzado_id;     // int(11)  multiple_key group_by
    public $obrero_sexo_id;                  // int(11)  multiple_key group_by
    public $obrero_estado_civil_id;          // int(11)  multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

        public $fb_linkDisplayFields = array('obrero_apellido');
    
    var $fb_preDefOrder = array(
        'obrero_apellido',
        'obrero_nombre',
        'obrero_CUIL',
        'obrero_tipo_doc_id',
        'obrero_nro_doc',
        'obrero_fecha_nacimiento',
        'obrero_direccion',
        'obrero_localidad_id',
        'obrero_CP',
        'obrero_CBU',
        'obrero_cuenta_bancaria',
        'obrero_fecha_inicio',
        'obrero_telefono',
        'obrero_tel_fijo_celular',
        'obrero_tel_laboral1',
        'obrero_tel_laboral2',
        'obrero_referido1',
        'obrero_referido2',
        'obrero_estado_id',        
    );
    
    public $fb_fieldLabels = array (
        'obrero_apellido' => 'Apellido: ',
        'obrero_nombre' => 'Nombre: ',
        'obrero_tipo_doc_id' => 'Tipo Documento: ',
        'obrero_nro_doc' => 'N&uacute;mero de Documento: ',
        'obrero_direccion' => 'Domicilio: ',
        'obrero_localidad_id' => 'Localidad: ',
        'obrero_CP' => 'C&oacute;digo Postal: ',
        'obrero_CUIL' => 'CUIL: ',
        'obrero_cuenta_bancaria' => 'Cuenta Bancaria: ',
        'obrero_CBU' => 'CBU: ',
        'obrero_fecha_inicio' => 'Fecha de Inicio: ',
        'obrero_telefono' => 'Telefono: ',
        'obrero_tel_fijo_celular' => 'Celular: ',
        'obrero_tel_laboral1' => 'Tel. Laboral 1: ',
        'obrero_tel_laboral2' => 'Tel. Laboral 2: ',
        'obrero_referido1' => 'Referido 1: ',
        'obrero_referido2' => 'Referido 2: ',
        'obrero_estado_id' => 'Estado: ',
        'obrero_fecha_nacimiento' => 'Fecha de Nacimiento: ',
        'obrero_usuario_id' => 'Usuario',
    );
    
    function preGenerateForm(&$fb) {

        if ($_GET['ver'] == ''){
            //fecha inicio
            $aux =  HTML_QuickForm::createElement('text', 'obrero_fecha_inicio', 'Fecha inicio: ', array('id' => 'obrero_fecha_inicio', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
            $this -> fb_preDefElements['obrero_fecha_inicio'] = $aux;
                
            //fecha nacimiento
            $aux =  HTML_QuickForm::createElement('text', 'obrero_fecha_nacimiento', 'Fecha nacimiento: ', array('id' => 'obrero_fecha_nacimiento', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD-MM-AAAA'));
            $this -> fb_preDefElements['obrero_fecha_nacimiento'] = $aux;
            //
        }

        //tipo documento
        $this -> obrero_tipo_doc_id = utf8_encode($this->obrero_tipo_doc_id);
        //
        
        //CUIL
        $aux =  HTML_QuickForm::createElement('text', 'obrero_CUIL', 'CUIL: ', array('id' => 'obrero_CUIL', 'value' => '', 'size' => '11', 'maxlength' => '11', 'onChange' => 'cargar_dni(this.value)'));
        $this -> fb_preDefElements['obrero_CUIL'] = $aux;
        //
        
        //numero de documento
        $aux =  HTML_QuickForm::createElement('text', 'obrero_nro_doc', 'N&uacute;mero de Documento: ', array('id' => 'obrero_nro_doc', 'value' => '', 'size' => '8', 'readonly' => 'readonly'));
        $this -> fb_preDefElements['obrero_nro_doc'] = $aux;
        //
        
        //CBU
        $aux =  HTML_QuickForm::createElement('text', 'obrero_CBU', 'CBU: ', array('id' => 'obrero_CBU', 'value' => '', 'size' => '25', 'maxlength' => '22', 'onChange' => 'cargar_cuenta(this.value)'));
        $this -> fb_preDefElements['obrero_CBU'] = $aux;
        //
        
        //cuenta bancaria
        $aux =  HTML_QuickForm::createElement('text', 'obrero_cuenta_bancaria', 'Cuenta Bancaria: ', array('id' => 'obrero_cuenta_bancaria', 'value' => '', 'size' => '11', 'maxlength' => '11', 'readonly' => 'readonly'));
        $this -> fb_preDefElements['obrero_cuenta_bancaria'] = $aux;
        //
        
        if ($_GET['accion']){
            $this -> obrero_apellido = utf8_encode($this->obrero_apellido);
            $this -> obrero_nombre = utf8_encode($this->obrero_nombre);
            $this -> obrero_direccion = utf8_encode($this->obrero_direccion);
        }
    }
    
    function postGenerateForm(&$frm,&$fb) { 
        
        $frm-> addElement('html','
            
            <link type="text/css" rel="stylesheet" href="css/autocomplete_obrero/jquery-ui-1.8.4.custom.css" />
            <link type="text/css" rel="stylesheet" href="css/autocomplete_obrero/estilo.css" />
            <script type="text/javascript" src="js/autocomplete_obrero/jquery-1.4.2.min.js"></script>
            <script type="text/javascript" src="js/autocomplete_obrero/jquery-ui-1.8.4.custom.min.js"></script>

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
                    var obj = document.getElementById("obrero_nro_doc");
                    obj.value = dni;
                }
                
                function cargar_cuenta (cbu){
                    var cuenta = cbu.substring(10, 21)
                    var obj = document.getElementById("obrero_cuenta_bancaria");
                    obj.value = cuenta;
                }
            </script>');
            
            
            //$frm->addRule('obrero_cuil', 'El CUIL debe tener 11 digitos', 'minlength', 11, 'client');
            //modificacion-eliminacion
            if ($_GET['accion']){
                $fecha_inicio = fechaAntiISO($this -> obrero_fecha_inicio);
                $fecha_nacimiento = fechaAntiISO($this -> obrero_fecha_nacimiento);
                
                $frm-> addElement('html','
                    <script type="text/javascript">
                        $(document).ready(
                            function(){
                                var fecha_inicio = "'.$fecha_inicio.'";
                                var fecha_nacimiento = "'.$fecha_nacimiento.'";
                                $("#obrero_fecha_inicio").datepicker("setDate", fecha_inicio);
                                $("#obrero_fecha_nacimiento").datepicker("setDate", fecha_nacimiento);
                            }
                        );
                    </script>
                ');//}
                
                //$this -> obrero_fecha_inicio = "KKKK";
                $num=$this->obrero_id;
                
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
                                    $("#obrero_fecha_inicio").datepicker("setDate", fecha_inicio);
                                }
                            );
                        </script>
                    ');
                    
                    $cli=DB_DataObject::factory('obrero');
                    $cli->orderBy('obrero_id DESC');
                    $cli->find(true);
                    $num=$cli->obrero_id+1;
                }
                else{
                    //ver
                    $num=$this->obrero_id;
                }
            }
            
            $frm->insertElementBefore($frm-> createElement('html','<tr><td style="text-align:right"><b>N&uacute;mero: </b></td><td>'.$num.'</td></tr>'), 'obrero_apellido');
            
            //Agrega Reglas
            $frm->addRule('obrero_CUIL', 'El CUIL debe tener 11 dígitos', 'minlength', 11, 'client');
            $frm->addRule('obrero_CBU', 'El CBU debe tener 22 dígitos', 'minlength', 22, 'client');
            $frm->addRule('obrero_cuenta_bancaria', 'El Nro. de Cuenta debe tener 11 dígitos', 'minlength', 11, 'client');
    
    }
    
    public function get_obrero($obrero_id){
        $this -> obrero_id = $obrero_id;
        if($this -> find(true))
            return $this -> obrero_nombre.' '.$this -> obrero_apellido;
    }
}

?>