<?php
	require '../../extensiones/fpdf.php';
	require 'conexion.php';
    include '../plugins/php/php-barcode-master/barcode.php';


    $stmt = Conexion::conectar()->prepare("SELECT codigo FROM productos ORDER BY codigo ASC");

	$stmt -> execute();

	$stmt -> fetchAll();
	
	$pdf = new FPDF();
	$pdf->AddPage();
    $pdf->SetAutoPageBreak(true,20);
	$y = $pdf->GetY();
	
	while ($row = $stmt->fetch_assoc()){
	
        $code = $row['codigo'];
        barcode($filepath, $code, 20, 'horizontal', 'code39',true,1);		
        $pdf->Image('../codigosImg/'.$code.'.png',10,$y,50,0,'PNG');
		
	$y = $y+10;
	
    }
	
    $pdf->Output();	
?>