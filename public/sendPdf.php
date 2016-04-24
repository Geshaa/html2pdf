<?php
	include 'config.php';
	include 'mpdf/mpdf.php';
	require_once 'swiftmailer/swift_required.php';

	$smtp_host 			= 'givanov.eu';
	$fileName 			= 'temporary.pdf';
	$smtp_username 		= 'html2pdf@givanov.eu';
	$smtp_password 		= 't3st123';
	$smtp_port 			= 25;
	$from_email 		= $smtp_username;
	$from_name			= 'ivan';
	$to_email			= $_POST['emailRecepient'];
	$email_body			= 'One of our users sends you email which contain pdf. Check it.';

	//get data from database
	$statement = $db->prepare("SELECT htmlSource, cssSource from pdf WHERE id = :id");
    $statement->bindParam(':id', $_POST['id']);
    $statement->execute();
    $results = $statement->fetch(PDO::FETCH_ASSOC);

    //create pdf
	$mpdf   = new mPDF('utf-8','A4','','' , 2 , 2 , 2 , 2 , 2 , 2);
	$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
	$mpdf->setAutoBottomMargin = 'stretch'; // Set pdf bottom margin to stretch to avoid content overlapping
	$mpdf->SetDisplayMode('fullpage');
	$html   = preg_replace("/<link href=.*?>(.*?)/", "", $results['htmlSource']);
	$html   = preg_replace("/<script>(.*?)<\/script>/", "", $results['htmlSource']);
	$mpdf->WriteHTML($results['cssSource'], 1);
	$mpdf->WriteHTML($html, 2);

	//send pdf as email attachment
	$transporter = Swift_SmtpTransport::newInstance($smtp_host, $smtp_port);
	$transporter->setUsername($smtp_username);
	$transporter->setPassword($smtp_password);

	$mailer = Swift_Mailer::newInstance($transporter);

	$message = Swift_Message::newInstance('Email Subject')
			->setFrom(array($from_email => $from_name))
			->setTo($to_email)
			->setBody($email_body);

	//need to check from real server if it sends mails
	$attachment = Swift_Attachment::newInstance($mpdf->Output($fileName, 'F'), $fileName, 'application/pdf');
	$message->attach($attachment);  

	$message->setContentType("text/html");

	$result = $mailer->send($message);


	//delete attachment when mail is send
	if (is_file($fileName)){
		unlink($fileName);
	}
?>