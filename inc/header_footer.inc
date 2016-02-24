<?php
/**
 * Class extention for Header and Footer Definitions
 *
 */
class pdf_usage extends fpdf_table
{


function Header()
{
  	$this->setLeftMargin(5);
    //Logo
    $this->Image('../img/logo_header.png',25,8,50);
    //Arial bold 15
    $this->SetFont('Times','B',10);
    //Movernos a la derecha
    //$this->Cell(10);
    $this->Ln(15);
    //Título
    $this->MultiCell(95,5,'ORGANISMO DE CONTROL DE ENERGIA ELECTRICA DE LA PROVINCIA DE BUENOS AIRES',0,'C');
    //Salto de línea
    $this->Ln(15);
 }
 
    
  public function Footer()
  {
    
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
   }
    
}

?>