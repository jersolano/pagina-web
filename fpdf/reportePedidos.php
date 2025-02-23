<?php
require('./fpdf.php');
require_once '../controladores/main_controller.php';

class PDF extends FPDF
{
   function Header()
   {
      // Logo
      $this->Image('logo.png', 10, 6, 30);

      // Título
      $this->SetFont('Arial', 'B', 14);
      $this->Cell(190, 10, utf8_decode('Pollería Don Pollo'), 0, 1, 'C');
      $this->SetFont('Arial', '', 12);
      $this->Cell(190, 5, utf8_decode('Reporte de Pedidos'), 0, 1, 'C');
      $this->Ln(3);

      // Fecha y Hora del Reporte
      date_default_timezone_set('America/Lima');
      $fecha = date('d/m/Y');
      $hora = date('H:i:s');

      $this->SetFont('Arial', '', 10);
      $this->Cell(190, 6, 'Fecha: ' . $fecha . ' | Hora: ' . $hora, 0, 1, 'C');
      $this->Ln(5);
   }

   function Footer()
   {
      $this->SetY(-15);
      $this->SetFont('Arial', 'I', 8);
      $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
   }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(255, 102, 0); // Color de fondo para la cabecera
$pdf->SetTextColor(255, 255, 255);

// Encabezados de la tabla (sin la columna Productos)
$pdf->Cell(10, 7, 'ID', 1, 0, 'C', true);
$pdf->Cell(50, 7, 'Cliente', 1, 0, 'C', true);
$pdf->Cell(30, 7, 'Tipo', 1, 0, 'C', true);
$pdf->Cell(30, 7, 'Total', 1, 0, 'C', true);
$pdf->Cell(40, 7, 'Estado', 1, 1, 'C', true);

// Consulta a la base de datos
$sql = "SELECT 
            p.pedido_id,
            cl.nombre_cliente,
            tp.tipo AS tipo_pedido,
            p.monto_total,
            ep.estado
        FROM pedidos p
        JOIN clientes cl ON cl.cliente_id = p.cliente_id
        JOIN tipo_pedido tp ON p.tipo = tp.tipo_pedido_id
        JOIN estado_pedido ep ON p.estado = ep.estado_pedido_id order by p.pedido_id";

$resultados = MainController::query($sql);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);

// Imprimir los datos en la tabla
foreach ($resultados as $fila) {
   $pdf->Cell(10, 7, $fila['pedido_id'], 1, 0, 'C');
   $pdf->Cell(50, 7, utf8_decode($fila['nombre_cliente']), 1, 0, 'L');
   $pdf->Cell(30, 7, utf8_decode($fila['tipo_pedido']), 1, 0, 'C');
   $pdf->Cell(30, 7, number_format($fila['monto_total'], 2), 1, 0, 'C');
   $pdf->Cell(40, 7, utf8_decode($fila['estado']), 1, 1, 'C');
}

$pdf->Output();
