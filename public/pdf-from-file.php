<?php
include 'config.php';
include 'mpdf/mpdf.php';
session_start();

/*
$html   = $_POST['htmlSource'];
$html   = preg_replace("/<link href=.*?>(.*?)/", "", $html);
$html   = preg_replace("/<script>(.*?)<\/script>/", "", $html);

*/

$file = file_get_contents($_FILES['uploadHTML']['temp_name']);
var_dump($file);

//$mpdf   = new mPDF('utf-8','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);
//$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
//$mpdf->setAutoBottomMargin = 'stretch'; // Set pdf bottom margin to stretch to avoid content overlapping
//$mpdf->SetDisplayMode('fullpage');
//$mpdf->WriteHTML($css, 1);
//$mpdf->WriteHTML($html, 2);

//$mpdf->WriteHTML(file_get_contents('../test/style.css'), 1);
//$mpdf->WriteHTML(file_get_contents('../test/example.html'), 2);

//$mpdf->Output('filename'.date('m-d-Y').'.pdf', 'D');
// F - force save
// D - open or save

//$stm = $db->prepare("INSERT INTO pdf(user_id, htmlSource, cssSource, dateCreated) VALUES ( :user_id, :htmlSource, :cssSource, NOW())");
//$stm->bindParam(':user_id', $_SESSION['userID']);
//$stm->bindParam(':htmlSource', $html);
//$stm->bindParam(':cssSource', $css);
//$stm->execute();




?>