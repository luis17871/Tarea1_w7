<?php
require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

// Encabezado de la Empresa
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Empresa XYZ', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'RUC: 1234567890', 0, 1);
$pdf->Cell(0, 10, 'Direccion: Calle Falsa 123, Quito, Ecuador', 0, 1);
$pdf->Cell(0, 10, 'Telefono: +593 999 999 999', 0, 1);
$pdf->Cell(0, 10, 'Email: info@empresa.com', 0, 1);

// Número de factura y fecha
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Factura No. 001-001-000000001', 0, 1, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Fecha de Emision: ' . date('d-m-Y'), 0, 1, 'R');

// Información del Cliente
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Datos del Cliente', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Nombre: Juan Perez', 0, 1);
$pdf->Cell(0, 10, 'Cedula/RUC: 1234567890', 0, 1);
$pdf->Cell(0, 10, 'Direccion: Calle Ejemplo 456, Guayaquil, Ecuador', 0, 1);
$pdf->Cell(0, 10, 'Telefono: +593 987 654 321', 0, 1);
$pdf->SetFont("Arial", "", 10);
// Detalle de la Factura
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Descripcion', 1);
$pdf->Cell(20, 10, 'Cantidad', 1);
$pdf->Cell(25, 10, 'Precio U.', 1); // Reducimos de 30 a 25
$pdf->Cell(25, 10, 'Subtotal', 1);       // Reducimos de 30 a 25
$pdf->Cell(25, 10, 'IVA (12%)', 1);      // Reducimos de 30 a 25
$pdf->Cell(25, 10, 'Total', 1);          // Reducimos de 30 a 25
$pdf->Ln();

// Datos quemados de productos
$productos = [
    ['nombre' => 'Producto A', 'cantidad' => 2, 'precio_unitario' => 10.00],
    ['nombre' => 'Producto B', 'cantidad' => 1, 'precio_unitario' => 20.00],
    ['nombre' => 'Producto C', 'cantidad' => 3, 'precio_unitario' => 7.50]
];

$subtotal_general = 0;
foreach ($productos as $prod) {
    $cantidad = $prod['cantidad'];
    $precioUnitario = $prod['precio_unitario'];
    $subtotal = $cantidad * $precioUnitario;
    $iva = $subtotal * 0.12;
    $total = $subtotal + $iva;
    $subtotal_general += $subtotal;
    

    // Detalle de cada producto
    $pdf->Cell(60, 10, $prod['nombre'], 1);
    $pdf->Cell(20, 10, $cantidad, 1);
    $pdf->Cell(25, 10, number_format($precioUnitario, 2), 1);
    $pdf->Cell(25, 10, number_format($subtotal, 2), 1);
    $pdf->Cell(25, 10, number_format($iva, 2), 1);
    $pdf->Cell(25, 10, number_format($total, 2), 1);
    $pdf->Ln();
}

// Totales de la Factura
$iva_total = $subtotal_general * 0.12;
$total_pagar = $subtotal_general + $iva_total;

$pdf->Ln(10);
$pdf->Cell(130, 10, 'Subtotal', 1); // Ajustamos este ancho a 130 para las totales
$pdf->Cell(50, 10, number_format($subtotal_general, 2), 1); // Ancho ajustado
$pdf->Ln();
$pdf->Cell(130, 10, 'IVA (12%)', 1);
$pdf->Cell(50, 10, number_format($iva_total, 2), 1);
$pdf->Ln();
$pdf->Cell(130, 10, 'Total a Pagar', 1);
$pdf->Cell(50, 10, number_format($total_pagar, 2), 1);

// Información Adicional
$pdf->Ln(20);
$pdf->Cell(0, 10, 'Forma de pago: Transferencia Bancaria', 0, 1); // Cambiamos las comillas simples por dobles
$pdf->Cell(0, 10, 'Cuenta Bancaria: Banco Pichincha, Cta: 123456789', 0, 1);
$pdf->Cell(0, 10, 'Gracias por su compra.', 0, 1);

$pdf->Output();
?>
