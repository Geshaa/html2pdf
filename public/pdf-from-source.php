<?php
include 'config.php';
include 'mpdf/mpdf.php';
include 'page2images.php';
session_start();

//this is when html and css are separated files and code is put into textboxes
$html   = $_POST['htmlSource'];
$html   = preg_replace("/<link href=.*?>(.*?)/", "", $html);
$html   = preg_replace("/<script>(.*?)<\/script>/", "", $html);
$css    = $_POST['cssSource'];

$mpdf   = new mPDF('utf-8','A4','','' , 2 , 2 , 2 , 2 , 2 , 2);
$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
$mpdf->setAutoBottomMargin = 'stretch'; // Set pdf bottom margin to stretch to avoid content overlapping
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($css, 1);
$mpdf->WriteHTML($html, 2);

$mpdf->Output('filename'.date('m-d-Y').'.pdf', 'D');
// F - force save
// D - open or save

$stm = $db->prepare("INSERT INTO pdf(user_id, htmlSource, cssSource, dateCreated, photo) VALUES ( :user_id, :htmlSource, :cssSource, NOW(), :photo )");
$stm->bindParam(':user_id', $_SESSION['userID']);
$stm->bindParam(':htmlSource', $html);
$stm->bindParam(':cssSource', $css);
$stm->bindParam(':photo', call_p2i_with_callback());
$stm->execute();

?>