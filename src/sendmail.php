<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('seregagl1998@gmail.com', 'Radical design');
	//Кому отправить
	$mail->addAddress('seregagl1996@gmail.com');
	//Тема письма
	$mail->Subject = 'Привет! Это "Radical design"';

	//Тело письма
	$body = '<h1>Письмо с сайта radical design</h1>';
	
	if(trim(!empty($_POST['request-name']))){
		$body.='<p><strong>Имя:</strong> '.$_POST['request-name'].'</p>';
	}
	if(trim(!empty($_POST['request-phone']))){
		$body.='<p><strong>Телефон:</strong> '.$_POST['request-phone'].'</p>';
	}
	
	if(trim(!empty($_POST['request-question']))){
		$body.='<p><strong>Сообщение:</strong> '.$_POST['request-question'].'</p>';
	}

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	} else {
		$message = 'Данные отправлены!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
