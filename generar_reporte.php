<?php
require('GeneradorReportes/fpdf.php'); // Incluye FPDF
$mysqli = new mysqli('localhost', 'root', '', 'catchai');

// Verifica conexión
if ($mysqli->connect_error) {
    die("Error en la conexión: " . $mysqli->connect_error);
}

// Consulta los datos de la tabla pedidoproducto con el nombre de los productos y las categorias
$query = "
    SELECT 
        pp.Pedido_IdPedido AS idPedido, 
        pp.PrecioPP AS monto, 
        pp.Cantidad AS cantidad, 
        p.Producto AS producto,
        c.Categoria AS categoria
    FROM 
        pedidoproducto pp 
    INNER JOIN 
        producto p ON pp.Producto_idProducto = p.idProducto
    INNER JOIN 
        categoria c ON p.Categoria_idCategoria = c.idCategoria
";
$resultado = $mysqli->query($query);

// Crea el PDF
class PDF extends FPDF
{
    function Header()
    {
        // Logotipo
        $this->Image('Images/logo.png', 10, 6, 30); // ruta y tamaño del logo
        
        // Título
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Reporte de Pedidos', 0, 1, 'C');
        $this->SetFont('Arial', 'I', 12);
        $this->Cell(0, 10, 'Cat Chai Cafeteria', 0, 1, 'C');
        $this->Ln(10);

        // Encabezados de la tabla
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(100, 150, 250);
        $this->SetTextColor(255);
        $this->SetDrawColor(50, 50, 100);
        $this->SetLineWidth(.3);
        $w = [30, 40, 30, 50, 40]; // ancho de las columnas

        // Centrar la tabla
        $totalWidth = array_sum($w);  // Sumar el ancho total de las columnas
        $xPos = (210 - $totalWidth) / 2; // Calcular la posición para centrar la tabla (en A4: 210 mm de ancho)

        // Establecer la posición en X para centrar la tabla
        $this->SetX($xPos);

        // Imprimir encabezados de columna
        $header = ['ID Pedido', 'Monto (Bs)', 'Cantidad', 'Producto', 'Categoria'];
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 10, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
    }

    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    function FancyTable($data)
    {
        // Anchura de las columnas
        $w = [30, 40, 30, 50, 40]; 

        // Restaurar colores y fuente
        $this->SetFillColor(240, 240, 240);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 10);

        // Alineación correcta
        $totalWidth = array_sum($w);
        $xPos = (210 - $totalWidth) / 2;
        $this->SetX($xPos);

        // Datos
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 10, $row['idPedido'], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 10, number_format($row['monto'], 2) . ' ', 'LR', 0, 'R', $fill);
            $this->Cell($w[2], 10, $row['cantidad'], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 10, $row['producto'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 10, $row['categoria'], 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }

        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Inicializa el PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Recoge los datos en un array
$data = [];
while ($fila = $resultado->fetch_assoc()) {
    $data[] = $fila;
}

// Genera la tabla con estilo
$pdf->FancyTable($data);

// Salida del PDF
$pdf->Output('D', 'Reporte_Pedidos.pdf');
?>
