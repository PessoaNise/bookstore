<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require '../vendor/autoload.php';
include "../resources/db/PedidoDB.php";
include "../resources/db/ItemPedidoDB.php";

// Configurar zona horaria correcta
date_default_timezone_set('America/Mexico_City');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Línea superior decorativa
        $this->SetDrawColor(40, 40, 40);
        $this->SetLineWidth(0.8);
        $this->Line(15, 10, 195, 10);
        
        // Logo text
        $this->SetY(14);
        $this->SetFont('helvetica', 'B', 22);
        $this->SetTextColor(40, 40, 40);
        $this->Cell(0, 10, 'LIBRERÍA PESSOA', 0, 1, 'C');
        
        // Subtítulo
        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 4, 'Comprobante de compra', 0, 1, 'C');
        
        // Línea inferior del header
        $this->SetDrawColor(40, 40, 40);
        $this->SetLineWidth(0.3);
        $this->Line(15, 32, 195, 32);
        
        $this->SetY(35);
    }

    // Page footer
    public function Footer() {
        $this->SetY(-25);
        
        // Línea separadora
        $this->SetDrawColor(180, 180, 180);
        $this->SetLineWidth(0.2);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        
        $this->Ln(3);
        $this->SetFont('helvetica', '', 7);
        $this->SetTextColor(130, 130, 130);
        $this->Cell(0, 4, 'Librería Pessoa — Tu librería de confianza', 0, 1, 'C');
        $this->Cell(0, 4, 'Este documento es un comprobante válido de su compra.', 0, 1, 'C');
        
        // Número de página
        $this->SetFont('helvetica', 'I', 7);
        $this->Cell(0, 4, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'C');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('Librería Pessoa');
$pdf->SetAuthor('Librería Pessoa');
$pdf->SetTitle('Ticket de Compra');
$pdf->SetSubject('Comprobante de compra');
$pdf->SetKeywords('Librería, Pessoa, ticket, compra');

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(15, 38, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(15);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 30);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// add a page
$pdf->AddPage();

//////////////////////////////////////////

$orderData = PedidoDB::getDatosPersonaOrdenPorIdOrden($_GET['idOrden']);

// Convertir fecha de UTC a hora local
$fechaUTC = new DateTime($orderData['creada'], new DateTimeZone('UTC'));
$fechaUTC->setTimezone(new DateTimeZone('America/Mexico_City'));
$fechaLocal = $fechaUTC->format('d/m/Y H:i:s');

// --- Sección: Información de la orden ---
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetTextColor(40, 40, 40);
$pdf->Cell(0, 8, 'INFORMACIÓN DE LA ORDEN', 0, 1, 'L');

$pdf->SetDrawColor(200, 200, 200);
$pdf->SetLineWidth(0.2);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(4);

// Datos en dos columnas
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(60, 60, 60);

$col1 = 95;
$col2 = 85;
$lineH = 6;

$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell($col1, $lineH, 'No. de referencia:', 0, 0);
$pdf->SetFont('helvetica', '', 9);
$pdf->Cell($col2, $lineH, '#' . $orderData['id'], 0, 1);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell($col1, $lineH, 'Fecha de compra:', 0, 0);
$pdf->SetFont('helvetica', '', 9);
$pdf->Cell($col2, $lineH, $fechaLocal, 0, 1);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell($col1, $lineH, 'Cliente:', 0, 0);
$pdf->SetFont('helvetica', '', 9);
$pdf->Cell($col2, $lineH, $orderData['nombre'] . ' ' . $orderData['a_paterno'], 0, 1);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell($col1, $lineH, 'Email:', 0, 0);
$pdf->SetFont('helvetica', '', 9);
$pdf->Cell($col2, $lineH, $orderData['correo_electronico'], 0, 1);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell($col1, $lineH, 'Dirección:', 0, 0);
$pdf->SetFont('helvetica', '', 9);
$pdf->Cell($col2, $lineH, $orderData['calle'] . ' #' . $orderData['numero'], 0, 1);

$pdf->Ln(6);

// --- Sección: Detalle de artículos ---
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetTextColor(40, 40, 40);
$pdf->Cell(0, 8, 'DETALLE DE ARTÍCULOS', 0, 1, 'L');

$pdf->SetDrawColor(200, 200, 200);
$pdf->SetLineWidth(0.2);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(2);

// Tabla header
$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetTextColor(40, 40, 40);
$pdf->Cell(80, 8, 'Libro', 0, 0, 'L', true);
$pdf->Cell(30, 8, 'Precio', 0, 0, 'R', true);
$pdf->Cell(30, 8, 'Cantidad', 0, 0, 'C', true);
$pdf->Cell(40, 8, 'Subtotal', 0, 1, 'R', true);

// Línea bajo header de tabla
$pdf->SetDrawColor(180, 180, 180);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());

// Items
$items = ItemPedidoDB::getDatosItemsOrdenPorIdOrden($orderData['id']);
$pdf->SetFont('helvetica', '', 9);
$pdf->SetTextColor(60, 60, 60);
$fill = false;

foreach ($items as $item) {
    $subtotal = $item['precio_venta'] * $item['cantidad'];
    
    if ($fill) {
        $pdf->SetFillColor(250, 250, 250);
    }
    
    $pdf->Cell(80, 7, $item['titulo'], 0, 0, 'L', $fill);
    $pdf->Cell(30, 7, '$' . number_format($item['precio_venta'], 2), 0, 0, 'R', $fill);
    $pdf->Cell(30, 7, $item['cantidad'], 0, 0, 'C', $fill);
    $pdf->Cell(40, 7, '$' . number_format($subtotal, 2), 0, 1, 'R', $fill);
    
    $fill = !$fill;
}

// Línea sobre el total
$pdf->SetDrawColor(40, 40, 40);
$pdf->SetLineWidth(0.4);
$pdf->Line(115, $pdf->GetY() + 2, 195, $pdf->GetY() + 2);
$pdf->Ln(5);

// Total
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetTextColor(40, 40, 40);
$pdf->Cell(140, 10, 'TOTAL:', 0, 0, 'R');
$pdf->Cell(40, 10, '$' . number_format($orderData['total'], 2), 0, 1, 'R');

// Línea decorativa final
$pdf->Ln(8);
$pdf->SetDrawColor(40, 40, 40);
$pdf->SetLineWidth(0.3);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'I', 8);
$pdf->SetTextColor(130, 130, 130);
$pdf->Cell(0, 5, 'Gracias por su compra en Librería Pessoa.', 0, 1, 'C');
$pdf->Cell(0, 5, 'Conserve este comprobante como referencia de su pedido.', 0, 1, 'C');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('ticket_libreria_pessoa.pdf', 'I');
