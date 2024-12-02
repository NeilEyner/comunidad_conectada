<?php

namespace App\Controllers;

use TCPDF;
use App\Models\CompraModel;
use App\Models\ProductoModel;
use App\Models\EnvioModel;

class PdfController extends BaseController
{
    protected $db;

    public function __construct()
    {
        // Cargar la base de datos
        $this->db = \Config\Database::connect();
    }
    public function exportarCompraPDF($idCompra)
    {
        // Obtener datos de la compra y relaciones
        $compra = $this->db->table('compra')
            ->select('compra.*, usuario.Nombre as NombreCliente, usuario.Correo_electronico, usuario.Telefono, usuario.Direccion')
            ->join('usuario', 'usuario.ID = compra.ID_Cliente')
            ->where('compra.ID', $idCompra)
            ->get()
            ->getRowArray();

        // Obtener detalles de la compra
        $detalles = $this->db->table('detalle_compra')
            ->select('detalle_compra.*, producto.Nombre as NombreProducto, usuario.Nombre as NombreArtesano, tiene_producto.Precio, tiene_producto.Imagen_URL')
            ->join('producto', 'producto.ID = detalle_compra.ID_Producto')
            ->join('usuario', 'usuario.ID = detalle_compra.ID_Artesano', 'left')
            ->join('tiene_producto', 'tiene_producto.ID_Producto = producto.ID AND tiene_producto.ID_Artesano = detalle_compra.ID_Artesano')
            ->where('detalle_compra.ID_Compra', $idCompra)
            ->get()
            ->getResultArray();

        // Obtener datos del envío
        $envio = $this->db->table('envio')
            ->select('envio.*, comunidad.Nombre as NombreComunidad, transporte.Tipo as TipoTransporte, u_delivery.Nombre as NombreDelivery')
            ->join('comunidad', 'comunidad.ID = envio.Comunidad_Destino', 'left')
            ->join('transporte', 'transporte.ID = envio.ID_Transporte', 'left')
            ->join('usuario as u_delivery', 'u_delivery.ID = envio.ID_Delivery', 'left')
            ->where('envio.ID_Compra', $idCompra)
            ->get()
            ->getRowArray();

        // Obtener datos del pago
        $pago = $this->db->table('pago')
            ->where('ID_Compra', $idCompra)
            ->get()
            ->getRowArray();

        // Crear nuevo documento PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Configurar información del documento
        $pdf->SetCreator('Sistema de Compras');
        $pdf->SetAuthor('Artesanos');
        $pdf->SetTitle('Compra #' . $idCompra);

        // Configurar márgenes
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // Configurar fuente
        $pdf->SetFont('helvetica', '', 10);

        // Agregar página
        $pdf->AddPage();

        // Logo y título
        $pdf->Image(FCPATH . 'assetBs. img/logo.png', 15, 10, 30);
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Detalle de Compra #' . $idCompra, 0, 1, 'C');
        $pdf->Ln(10);

        // Información del cliente
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Información del Cliente', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 6, 'Nombre:', 0, 0);
        $pdf->Cell(0, 6, $compra['NombreCliente'], 0, 1);
        $pdf->Cell(50, 6, 'Email:', 0, 0);
        $pdf->Cell(0, 6, $compra['Correo_electronico'], 0, 1);
        $pdf->Cell(50, 6, 'Teléfono:', 0, 0);
        $pdf->Cell(0, 6, $compra['Telefono'], 0, 1);
        $pdf->Cell(50, 6, 'Dirección:', 0, 0);
        $pdf->Cell(0, 6, $compra['Direccion'], 0, 1);
        $pdf->Ln(5);

        // Información de la compra
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Detalles de la Compra', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 6, 'Fecha:', 0, 0);
        $pdf->Cell(0, 6, date('d/m/Y H:i', strtotime($compra['Fecha'])), 0, 1);
        $pdf->Cell(50, 6, 'Estado:', 0, 0);
        $pdf->Cell(0, 6, $compra['Estado'], 0, 1);
        $pdf->Ln(5);

        // Tabla de productos
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 30, 'Productos', 0, 1, 'L');
        $pdf->SetFont('helvetica', 'B', 9);

        // Encabezados de la tabla
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(60, 7, 'Producto', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Artesano', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Cantidad', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Precio', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Subtotal', 1, 1, 'C', true);

        // Contenido de la tabla
        $pdf->SetFont('helvetica', '', 9);
        foreach ($detalles as $detalle) {
            // Altura estándar para la fila
            $rowHeight = 20;
            $imageWidth = 15;
            $x = $pdf->GetX();
            $y = $pdf->GetY();

            // Dibujar el borde de la celda del producto
            $pdf->Cell(60, $rowHeight, '', 1, 0);
            $pdf->SetXY($x, $y);

            // Agregar imagen del producto si existe
            if (!empty($detalle['Imagen_URL'])) {
                // Calcular posición para centrar la imagen verticalmente
                $imageY = $y + ($rowHeight - $imageWidth) / 2;
                $pdf->Image(base_url($detalle['Imagen_URL']), $x + 2, $imageY, $imageWidth, $imageWidth);
                // Texto del producto con padding para la imagen
                $pdf->SetXY($x + $imageWidth + 4, $y);
                $pdf->MultiCell(60 - $imageWidth - 4, $rowHeight, $detalle['NombreProducto'], 0, 'L');
            } else {
                // Solo texto si no hay imagen
                $pdf->MultiCell(60, $rowHeight, $detalle['NombreProducto'], 0, 'L');
            }

            // Restaurar posición X,Y para las siguientes celdas
            $pdf->SetXY($x + 60, $y);

            // Resto de las celdas en la fila
            $pdf->Cell(40, $rowHeight, $detalle['NombreArtesano'], 1, 0);
            $pdf->Cell(30, $rowHeight, $detalle['Cantidad'], 1, 0, 'C');
            $pdf->Cell(30, $rowHeight, 'Bs.  ' . number_format($detalle['Precio'], 2), 1, 0, 'R');
            $pdf->Cell(30, $rowHeight, 'Bs.  ' . number_format($detalle['Precio'] * $detalle['Cantidad'], 2), 1, 1, 'R');
        }

        // Total
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(160, 7, 'Total:', 1, 0, 'R');
        $pdf->Cell(30, 7, 'Bs.  ' . number_format($compra['Total'], 2), 1, 1, 'R');
        $pdf->Ln(5);

        // Información del envío
        if ($envio) {
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Información del Envío', 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(50, 6, 'Comunidad:', 0, 0);
            $pdf->Cell(0, 6, $envio['NombreComunidad'], 0, 1);
            $pdf->Cell(50, 6, 'Dirección:', 0, 0);
            $pdf->Cell(0, 6, $envio['Direccion_Destino'], 0, 1);
            $pdf->Cell(50, 6, 'Estado:', 0, 0);
            $pdf->Cell(0, 6, $envio['Estado'], 0, 1);
            $pdf->Cell(50, 6, 'Delivery:', 0, 0);
            $pdf->Cell(0, 6, $envio['NombreDelivery'] ?? 'No asignado', 0, 1);
            $pdf->Cell(50, 6, 'Transporte:', 0, 0);
            $pdf->Cell(0, 6, $envio['TipoTransporte'] ?? 'No asignado', 0, 1);
            $pdf->Cell(50, 6, 'Costo de envío:', 0, 0);
            $pdf->Cell(0, 6, 'Bs.  ' . number_format($envio['Costo_envio'], 2), 0, 1);
            $pdf->Ln(5);
        }

        // Información del pago
        if ($pago) {
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Información del Pago', 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(50, 6, 'Método de pago:', 0, 0);
            $pdf->Cell(0, 6, $pago['Metodo_pago'], 0, 1);
            $pdf->Cell(50, 6, 'Estado:', 0, 0);
            $pdf->Cell(0, 6, $pago['Estado'], 0, 1);
            $pdf->Cell(50, 6, 'Fecha:', 0, 0);
            $pdf->Cell(0, 6, date('d/m/Y H:i', strtotime($pago['Fecha'])), 0, 1);
        }

        // QR Code con información de la compra
        $qrData = "Compra #" . $idCompra . "\n";
        $qrData .= "Cliente: " . $compra['NombreCliente'] . "\n";
        $qrData .= "Fecha: " . $compra['Fecha'] . "\n";
        $qrData .= "Total: Bs.  " . $compra['Total'];

        $pdf->Ln(10);
        $pdf->write2DBarcode($qrData, 'QRCODE,L', 160, $pdf->GetY(), 40, 40);

        // Términos y condiciones o notas adicionales
        $pdf->Ln(45);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(0, 4, 'Nota: Este documento es un comprobante de compra. Para cualquier reclamo o consulta, por favor conserve este documento y contacte con nuestro servicio de atención al cliente.', 0, 'L');

        // Generar el PDF
        $pdf->Output('Compra-' . $idCompra . '.pdf', 'D');
    }
    public function exportarCompraPDF1($idCompra)
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
        $pdf->Image(FCPATH . 'assetBs. img/logo.png', 15, 10, 30);
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