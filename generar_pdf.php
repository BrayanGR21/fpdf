<?php
require('fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Factura', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function ImprovedTable($header, $data)
    {
        $w = array(40, 60, 20, 30, 30);

        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();

        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'C');
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R');
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R');
            $this->Ln();
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }

    function SummaryTable($data)
    {

        $w = array(150, 30);

        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'R');
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'R');
            $this->Ln();
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

$pdf = new PDF();
$pdf->AddPage();

$header = array('Servicio', 'Descripción', 'Cantidad', 'Precio', 'Total');

$data = array(
    array('Marketing', 'Digital Marketing & SEO', '2', '$120', '$240.00'),
    array('Web Design & Development', 'Desktop & Mobile Web App Design', '2', '$250', '$500.00'),
    array('UI/UX Design', 'Mobile Android & iOS App Design', '1', '$80', '$80.00')
);

$pdf->SetFont('Arial', '', 8);
$pdf->ImprovedTable($header, $data);

$summaryData = array(
    array('Sub Total', '$820.00'),
    array('Impuesto (18%)', '$147.60'),
    array('Total', '$967.60')
);

$pdf->Ln(10);
$pdf->SummaryTable($summaryData);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Informacion adicional:', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, 'A ut vitae nullam risus at. Justo enim nisi elementum ac. Massa molestie metus vitae ornare turpis donec odio sollicitudin. Ac ut tellus eu donec dictum risus blandit. Quam diam dictum amet.');

$pdf->Output('D', 'Factura.pdf');
?>
