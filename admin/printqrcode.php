<?php
require_once 'libs/fpdf/fpdf.php';
require_once './assets/query.php';

$query = new Query();

$fac = $query->fetchFaculty($_GET['fac_id']);

$name = "{$fac['fac_fname']} {$fac['fac_lname']}";

$pdf = new FPDF('p', 'in', array(3, 4));

$pdf->SetMargins(0, 0, 0);
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

// Image (file name, x position, y position, width [optional], height [optional])
$pdf->Image('./assets/img/1697023494.png', .251, .5, 2.5);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(3, 3, '', 0, 1, 'C');
$pdf->Cell(3, .3, $name, 0, 1, 'C');

$pdf->Output();

?>
<script>
  console.log(JSON.parse('<?= json_encode($fac) ?>'))
</script>