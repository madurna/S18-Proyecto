<?php
require_once('../config/web.config');
//require_once('../inc/fpdf.php');
//require_once('../inc/class.multicelltag.php');
require_once('../inc/class.fpdf_table.php');
require_once('../inc/header_footer.inc');
require_once('../inc/table_def.inc');
//define the Paragraph String ~~ Required by Multicell Class
//define('PARAGRAPH_STRING', '~~~');

require_once('../config/data.config');
require_once('funciones_importador/getInfoPDF.php');
require_once ('DB.php');
// Librerias propias
//require_once('../inc/rutinas.php');
require_once('../inc/comun.php');

function generarPDF($zip_nombre,$arch_id = null) {

//FECHA ACTUAL
$datos=getInfoPDF($zip_nombre,$arch_id);
$fecha=date('d/m/Y');

//$fechaHoy=date("d/m/Y");
$fechaHoy=$datos['arch_fecha_carga'];
$mes=substr($fechaHoy, 5,2);

switch ($mes){
    case '01': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Enero de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;  
    case '02': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Febrero de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;  
    case '03': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Marzo de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;
    case '04': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Abril de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;  
    case '05': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Mayo de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;  
    case '06': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Junio de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;  
    case '07': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Julio de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;  
    case '08': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Agosto ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;
    case '09': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Septiembre de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;
    case '10': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Octubre de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;
    case '11': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Noviembre de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;
    case '12': 
        $fechaHoy=substr($fechaHoy, 8, 2)." de Diciembre de ".substr($fechaHoy, 0, 4)." - ".substr($fechaHoy, 11, 8);
        break;
}

$hora=date("H:i:s");

//Creación del objeto de la clase heredada
$pdf=new pdf_usage('P', 'mm', 'A4');

$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setLeftMargin(15);
$pdf->setRightMargin(15);
$pdf->SetFont('Times','',12);

$pdf->SetStyle("ne","times","B",12,"0,0,0");


$texto="\t<ne>Se ha recibido el archivo de tipo: </ne>".$datos['tipoarch_descripcion']."\n\n
\t<ne>Nombre de Archivo: </ne>".$datos['arch_zip']."\n\n
\t<ne>Número de Transacción: </ne>".$datos['arch_nro_transaccion']."\n\n
\t<ne>Fecha y Hora: </ne>".$fechaHoy."\n\n
\t<ne>Código de Seguridad: </ne>".$datos['arch_cod_seguridad']."\n\n";
$pdf->MultiCellTag(0,5,$texto,0,'J');

//$pdf->Ln(0.5);
//Header('Content-Type: application/msword');

//El nombre de archivo va a ser el cod de la empresa seguido del nro de transaccion
//En que carpeta se va a guardar el archivo?
$nombre_pdf = $datos['arch_nro_transaccion'].".pdf";

if (!is_writable(PDF_PATH)) {
	return false;
}
else {
	$pdf->Output(PDF_PATH."/".$nombre_pdf, "F");
	return($nombre_pdf);
}
}

