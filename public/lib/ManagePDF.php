<?php
require_once('../Core.php');

class ManagePDF {
	private $core;
	private $statement;
	private $results;

	public function listAll() {
		$this->core = Core::getInstance();
		session_start();

	    $this->statement = $this->core->dbh->prepare("SELECT id, htmlSource, cssSource, dateCreated, photo from pdf WHERE user_id = :userID");
	    $this->statement->bindParam(':userID', $_SESSION['userID']);
	    $this->statement->execute();

	    if ($this->statement) {
	    	$this->results = $this->statement->fetchAll(PDO::FETCH_ASSOC);
	    	echo json_encode($this->results);
	    }
	    else {
	    	echo -1;
	    }
	}

	public function update() {
		$this->core = Core::getInstance();

		$sql = "UPDATE pdf SET htmlSource = :htmlSource, cssSource = :cssSource WHERE id = :id";
		$this->statement = $this->core->dbh->prepare($sql);                                  
		$this->statement->bindParam(':htmlSource', $_POST['htmlSource']);       
		$this->statement->bindParam(':cssSource', $_POST['cssSource']);    
		$this->statement->bindParam(':id', $_POST['id']);
		 
		$this->statement->execute(); 
	}

	public function send() {
		include '../mpdf/mpdf.php';
		require_once '../swiftmailer/swift_required.php';

		$this->core = Core::getInstance();

		$smtp_host 			= 'amur.superhosting.bg';
		$fileName 			= 'temporary.pdf';
		$smtp_username 		= 'html2pdf@givanov.eu';
		$smtp_password 		= 't3st123';
		$smtp_port 			= 25;
		$from_email 		= $smtp_username;
		$from_name			= 'HTML2PDF convertor';
		$to_email			= $_POST['emailRecepient'];
		$email_body			= 'One of our users sends you email which contain pdf. Check it.';

		//get data from database
		$this->statement = $this->core->dbh->prepare("SELECT htmlSource, cssSource from pdf WHERE id = :id");
	    $this->statement->bindParam(':id', $_POST['id']);
	    $this->statement->execute();
	    $this->results = $this->statement->fetch(PDO::FETCH_ASSOC);

	    //create pdf
		$mpdf   = new mPDF('utf-8','A4','','' , 2 , 2 , 2 , 2 , 2 , 2);
		$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
		$mpdf->setAutoBottomMargin = 'stretch'; // Set pdf bottom margin to stretch to avoid content overlapping
		$mpdf->SetDisplayMode('fullpage');
		$html   = preg_replace("/<link href=.*?>(.*?)/", "", $this->results['htmlSource']);
		$html   = preg_replace("/<script>(.*?)<\/script>/", "", $this->results['htmlSource']);
		$mpdf->WriteHTML($this->results['cssSource'], 1);
		$mpdf->WriteHTML($html, 2);
		$pdf_as_string = $mpdf->Output($fileName, 'S');

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
		$attachment = Swift_Attachment::newInstance($pdf_as_string, $fileName, 'application/pdf');
		$message->attach($attachment);  

		$message->setContentType("text/html");

		$result = $mailer->send($message);


		//delete attachment when mail is send
		if (is_file($fileName)){
			unlink($fileName);
		}
	}

	public function delete() {
		$this->core = Core::getInstance();
		
		$id = $_POST['id'];
	
		$this->statement = $this->core->dbh->prepare("DELETE from pdf WHERE id = :id");
		$this->statement->bindParam(':id', $id);
		$this->statement->execute();
	}
}

$manpdf = new ManagePDF();

switch($_POST['mode']) {

	case 'list':
		$manpdf->listAll();
		break;
	case 'update':
		$manpdf->update();
		break;
	case 'send':
		$manpdf->send();
		break;
	case 'delete':
		$manpdf->delete();
		break;
}

?>