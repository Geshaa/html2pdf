<?php
include 'config.php';
include 'mpdf/mpdf.php';
session_start();

if ($_FILES['uploadHTML']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['uploadHTML']['tmp_name']) && $_FILES['uploadHTML']['type'] == 'text/html') {
    $fileContent   = file_get_contents($_FILES['uploadHTML']['tmp_name']);
    $fileContent   = preg_replace("/<link href=.*?>(.*?)/", "", $fileContent);
    $fileContent   = preg_replace("/<script>(.*?)<\/script>/", "", $fileContent);
}

$dom = new DOMDocument();
@$dom->loadHTML($fileContent);
$styleTags = $dom -> getElementsByTagName('style');

foreach ($styleTags as $style) {
    $css .= $style -> firstChild -> data;
}

$mpdf   = new mPDF('utf-8','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);
$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
$mpdf->setAutoBottomMargin = 'stretch'; // Set pdf bottom margin to stretch to avoid content overlapping
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($fileContent);
$mpdf->Output('filename'.date('m-d-Y').'.pdf', 'D');

$stm = $db->prepare("INSERT INTO pdf(user_id, htmlSource, cssSource, dateCreated) VALUES ( :user_id, :htmlSource, :cssSource, NOW())");
$stm->bindParam(':user_id', $_SESSION['userID']);
$stm->bindParam(':htmlSource', $fileContent);
$stm->bindParam(':cssSource', $css);
$stm->execute();

?>