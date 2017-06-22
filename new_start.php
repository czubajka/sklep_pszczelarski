<?php
	session_start();
	
	if (!isset($_SESSION['udanarejestracja']))
	{
		header('Location: login.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}
	
	//Usuwanie zmiennych sesyjnych pamiętających wartości wpisywane do pól rejestracji oraz błędów
	if(isset($_SESSION['form_login'])) unset($_SESSION['form_login']);
	if(isset($_SESSION['form_email'])) unset($_SESSION['form_email']);
	if(isset($_SESSION['form_name'])) unset($_SESSION['form_name']);
	if(isset($_SESSION['form_sname'])) unset($_SESSION['form_sname']);
	if(isset($_SESSION['form_edu'])) unset($_SESSION['form_edu']);
	if(isset($_SESSION['form_hobby'])) unset($_SESSION['form_hobby']);
	if(isset($_SESSION['form_add_to_nl'])) unset($_SESSION['form_add_to_nl']);
	if(isset($_SESSION['form_phone'])) unset($_SESSION['form_phone']);
	if(isset($_SESSION['form_address_city'])) unset($_SESSION['form_address_city']);
	if(isset($_SESSION['form_address_nr'])) unset($_SESSION['form_address_nr']);
	if(isset($_SESSION['form_address_post'])) unset($_SESSION['form_address_post']);
	if(isset($_SESSION['form_address_str'])) unset($_SESSION['form_address_str']);
	if(isset($_SESSION['error_login'])) unset($_SESSION['error_login']);
	if(isset($_SESSION['error_email'])) unset($_SESSION['error_email']);
	if(isset($_SESSION['error_pswd'])) unset($_SESSION['error_pswd']);
	if(isset($_SESSION['error_regulamin'])) unset($_SESSION['error_regulamin']);
	if(isset($_SESSION['error_recaptcha'])) unset($_SESSION['error_recaptcha']);
		
		
		

	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>Logowanie</title>
	<link rel="stylesheet" href="styl.css">
	<link rel="icon" href="img/favicon-bee.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
    <meta http-equiv="creation-date" content="Mon, 06 May 2017 21:29:02 GMT">
</head>
<body>
	<h2>Witaj!</h2>
	
	<p>Dziękujemy za rejestrację!</p>
	<p>Zaloguj się teraz na swoje konto!</p>
	<br><br>
	<a href="login.php">kliknij tutaj w celu zalogowania</a>

</body>
</html>