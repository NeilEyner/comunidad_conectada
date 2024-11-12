<?php

namespace App\Controllers;

use TCPDF;
use App\Models\CompraModel;
use App\Models\ProductoModel;
use App\Models\EnvioModel;

class PdfController extends BaseController
{
    public function exportarCompraPDF($idCompra)
    {
        // Inicializar modelos
        $compraModel = new CompraModel();
        $productoModel = new ProductoModel();
        $envioModel = new EnvioModel();

        // Obtener datos de la compra
        $compra = $compraModel->find($idCompra);
        $productos = $compraModel->getProductosCompra($idCompra);
        $envio = $envioModel->where('ID_Compra', $idCompra)->first();

        // Crear nuevo documento PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establecer información del documento
        $pdf->SetCreator('TuSistema');
        $pdf->SetAuthor('Nombre de tu Sistema');
        $pdf->SetTitle('Comprobante de Compra #' . $idCompra);

        // Eliminar encabezado y pie de página predeterminados
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Establecer márgenes
        $pdf->SetMargins(15, 15, 15);

        // Agregar página
        $pdf->AddPage();

        // Establecer fuente
        $pdf->SetFont('helvetica', '', 12);

        // Logo y título
        $pdf->Image(FCPATH . 'assets/img/logo.png', 15, 10, 30);
        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->Cell(0, 20, 'Comprobante de Compra', 0, 1, 'C');
        $pdf->Ln(10);

        // Información de la compra
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Detalles de la Compra', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 7, 'Nº de Orden:', 0, 0);
        $pdf->Cell(0, 7, $compra['ID'], 0, 1);
        $pdf->Cell(50, 7, 'Fecha:', 0, 0);
        $pdf->Cell(0, 7, date('d/m/Y', strtotime($compra['Fecha'])), 0, 1);
        $pdf->Ln(5);

        // Información de envío
        if ($envio) {
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Información de Envío', 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 11);
            $pdf->Cell(50, 7, 'Dirección:', 0, 0);
            $pdf->Cell(0, 7, $envio['Direccion_Destino'], 0, 1);
            $pdf->Cell(50, 7, 'Estado:', 0, 0);
            $pdf->Cell(0, 7, $envio['Estado'], 0, 1);
            $pdf->Ln(5);
        }

        // Tabla de productos
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Productos', 0, 1, 'L');
        
        // Encabezados de la tabla
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(70, 8, 'Producto', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Cantidad', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Precio Unit.', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Subtotal', 1, 1, 'C', true);

        // Contenido de la tabla
        $pdf->SetFont('helvetica', '', 11);
        $total = 0;

        foreach ($productos as $item) {
            $subtotal = $item['Precio'] * $item['Cantidad'];
            $total += $subtotal;

            $pdf->Cell(70, 8, $item['Nombre'], 1, 0);
            $pdf->Cell(30, 8, $item['Cantidad'], 1, 0, 'C');
            $pdf->Cell(40, 8, 'Bs. ' . number_format($item['Precio'], 2), 1, 0, 'R');
            $pdf->Cell(40, 8, 'Bs. ' . number_format($subtotal, 2), 1, 1, 'R');
        }

        // Total
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(140, 8, 'Total', 1, 0, 'R', true);
        $pdf->Cell(40, 8, 'Bs. ' . number_format($total, 2), 1, 1, 'R', true);

        if ($envio && $envio['Costo_envio']) {
            $pdf->Cell(140, 8, 'Costo de Envío', 1, 0, 'R', true);
            $pdf->Cell(40, 8, 'Bs. ' . number_format($envio['Costo_envio'], 2), 1, 1, 'R', true);
            
            $totalConEnvio = $total + $envio['Costo_envio'];
            $pdf->Cell(140, 8, 'Total con Envío', 1, 0, 'R', true);
            $pdf->Cell(40, 8, 'Bs. ' . number_format($totalConEnvio, 2), 1, 1, 'R', true);
        }

        // Información adicional
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(0, 5, 'Gracias por su compra. Para cualquier consulta sobre su pedido, por favor contacte con nuestro servicio de atención al cliente.', 0, 'L');

        // QR Code con el ID de la compra
        $pdf->write2DBarcode('COMPRA-' . $idCompra, 'QRCODE,L', 15, $pdf->GetY() + 10, 30, 30);

        // Generar el PDF
        $pdf->Output('Compra-' . $idCompra . '.pdf', 'D');
    }
}