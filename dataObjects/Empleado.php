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
    public $empleado_apellido;               // varchar(255)  not_null
    public $empleado_nombre;                 // varchar(255)  not_null
    public $empleado_tipo_doc_id;            // int(11)  not_null multiple_key group_by
    public $empleado_nro_doc;                // int(11)  not_null group_by
    public $empleado_direccion;              // varchar(255)  
    public $empleado_localidad_id;           // int(11)  not_null multiple_key group_by
    public $empleado_CP;                     // varchar(255)  
    public $empleado_CUIL;                   // varchar(255)  
    public $empleado_CBU;                    // varchar(255)  
    public $empleado_fecha_inicio;           // date(10)  
    public $empleado_telefono;               // varchar(255)  
    public $empleado_estado;                 // varchar(255)  
    public $empleado_fecha_nacimiento;       // date(10)  
    public $empleado_sector_id;              // int(11)  multiple_key group_by
    public $empleado_tarea_id;               // int(11)  multiple_key group_by
    public $empleado_capacitacion;           // varchar(45)  multiple_key
    public $empleado_sexo_id;                // int(11)  multiple_key group_by
    public $empleado_estado_civil_id;        // int(11)  multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    var $fb_preDefOrder = array(
        'empleado_apellido',
        'empleado_nombre',
        'empleado_tipo_doc_id',
        'empleado_nro_doc',
        'empleado_CUIL',
        'empleado_fecha_nacimiento',
        'empleado_direccion',
        'empleado_localidad_id',
        'empleado_CP',
        'empleado_CBU',
        'empleado_fecha_inicio',
        'empleado_telefono',
        'empleado_sector_id',
        'empleado_tarea_id',
        'empleado_estado',
        'empleado_capacitacion',
        'empleado_sexo_id',
        'empleado_estado_civil_id'      
    );
    
    public $fb_fieldLabels = array (
        'empleado_apellido' => 'Apellido: ',
        'empleado_nombre' => 'Nombre: ',
        'empleado_tipo_doc_id' => 'Tipo Documento: ',
        'empleado_nro_doc' => 'N&uacute;mero de Documento: ',
        'empleado_CUIL' => 'CUIL: ',
        'empleado_CBU' => 'CBU: ',
        'empleado_direccion' => 'Domicilio: ',
        'empleado_localidad_id' => 'Localidad: ',
        'empleado_CP' => 'C&oacute;digo Postal: ',
        'empleado_sector_id' => 'Sector: ',
        'empleado_tarea_id' => 'Tarea: ',
        'empleado_fecha_inicio' => 'Fecha de Ingreso: ',
        'empleado_telefono' => 'Telefono: ',
        'empleado_estado' => 'Estado: ',
        'empleado_capacitacion' => 'Capacitaci&oacute;n: ',
        'empleado_fecha_nacimiento' => 'Fecha de Nacimiento: ',
        'empleado_sexo_id' => 'Sexo: ',
        'empleado_estado_civil_id' => 'Estado Civil: '
    );

    function preGenerateForm(&$fb) {
        //fecha de nacimiento
        $aux =  HTML_QuickForm::createElement('text', 'empleado_fecha_nacimiento', 'Fecha de Nacimiento: ', array('id' => 'empleado_fecha_nacimiento', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD/MM/AAAA'));
        $this -> fb_preDefElements['empleado_fecha_nacimiento'] = $aux;
        //

        //fecha de ingreso
        $aux =  HTML_QuickForm::createElement('text', 'empleado_fecha_inicio', 'Fecha de Ingreso: ', array('id' => 'empleado_fecha_inicio', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD/MM/AAAA'));
        $this -> fb_preDefElements['empleado_fecha_inicio'] = $aux;
        //

        //tipo documento
        $this -> empleado_tipo_doc_id = utf8_encode($this->empleado_tipo_doc_id);
        //
        
        //numero de documento
        $aux =  HTML_QuickForm::createElement('text', 'empleado_nro_doc', 'N&uacute;mero de Documento: ', array('id' => 'empleado_nro_doc', 'value' => '', 'size' => '8'));
        $this -> fb_preDefElements['empleado_nro_doc'] = $aux;
        //
        
        /*/fecha de antiguedad
        $aux =  HTML_QuickForm::createElement('text', 'empleado_fecha_antiguedad', 'Fecha de Antigûedad: ', array('id' => 'empleado_fecha_antiguedad', 'value' => '', 'size' => '11', 'class' => 'datepicker', 'title' => 'DD/MM/AAAA'));
        $this -> fb_preDefElements['empleado_fecha_antiguedad'] = $aux;
        /*/

    }
    
    function postGenerateForm(&$frm,&$fb) {
        //funcion para el datepicker
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
            </script>');
        
        //recupero las fechas en la modificacion
        if ($_GET['accion'] == 'm'){
            list($anio,$mes,$dia) = explode("-",$this -> empleado_fecha_nacimiento);
            $fecha_nacimiento = $dia.'-'.$mes.'-'.$anio;
            list($anio,$mes,$dia) = explode("-",$this -> empleado_fecha_inicio);
            $fecha_ingreso = $dia.'-'.$mes.'-'.$anio;        
            
            $frm-> addElement('html','
                <script type="text/javascript">
                    $(document).ready(function() {
                        var fecha_nacimiento = "'.$fecha_nacimiento.'";
                        var fecha_ingreso = "'.$fecha_ingreso.'";
                        
                        $("#empleado_fecha_nacimiento").datepicker("setDate", "fecha_nacimiento");
                        $("#empleado_fecha_inicio").datepicker("setDate", "fecha_ingreso");
                    });
                </script>
            ');
        }
        //
    }
}
