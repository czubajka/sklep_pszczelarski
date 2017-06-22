<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>Rejestracja użytkownika</title>
</head>
<body>
	
	<?php 
	$login = $_POST['login'];
	$password = $_POST['pswd'];
	$name = $_POST['imie'];
	$sname = $_POST['nazwisko'];
	$email = $_POST['email'];
	$address_str = $_POST['adres_ulica'];
	$address_nr = $_POST['ulica_nr'];
	$address_post = $_POST['kodp'];
	$address_city = $_POST['miejsce'];
	$phone = $_POST['tel'];
	$add_to_nl = $_POST['newsletter'];
	$source = $_POST['skad'];
	$hobby = $_POST['hobby'];
	$edu = $_POST['edu'];
	
	require_once "mysql.php";
	

	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo 'Error:"$connection->connect_errno." Opis: ".$connection->connect_error';
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['pswd'];
		echo "it works!";
		$connection->close();
	}

echo<<<END

	<h2>Witaj $name! </h2>
	<p>Twoje dane:</p>
	<p><span class="etykieta">Imię: </span>$name</p>
	<p><span class="etykieta">Nazwisko: </span>$sname</p>
	<p><span class="etykieta">Login: </span>$login</p>
	<p><span class="etykieta">Email: </span>$email</p>
	<p><span class="etykieta">Telefon: </span>$phone</p>
	<p><span class="etykieta">Hasło: </span>$password</p>
	<p><span class="etykieta">Newsletter: </span>$add_to_nl</p>
	<p><span class="etykieta">Adres: </span>ul. $address_str $address_nr, $address_post $address_city</p>
	<p><span class="etykieta">Wiem o Was z: </span>$source.</p>
	<p><span class="etykieta">Hobby: </span>$hobby</p>
	<p><span class="etykieta">Wykształcenie: </span>$edu</p>
	
	
END;
	?>
</body>
</html>