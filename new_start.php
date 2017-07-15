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
	if(isset($_SESSION['form_address_city'])) unset($_SESSION['form_address_city']);
	if(isset($_SESSION['form_address_nr'])) unset($_SESSION['form_address_nr']);
	if(isset($_SESSION['form_address_post'])) unset($_SESSION['form_address_post']);
	if(isset($_SESSION['form_address_str'])) unset($_SESSION['form_address_str']);
	if(isset($_SESSION['error_login'])) unset($_SESSION['error_login']);
	if(isset($_SESSION['error_email'])) unset($_SESSION['error_email']);
	if(isset($_SESSION['error_pswd'])) unset($_SESSION['error_pswd']);
	if(isset($_SESSION['error_regulamin'])) unset($_SESSION['error_regulamin']);
	if(isset($_SESSION['error_recaptcha'])) unset($_SESSION['error_recaptcha']);
	if(isset($_SESSION['error_adres'])) unset($_SESSION['error_adres']);
		
		
		

	
?>
<!DOCTYPE html>
<html lang="pl-PL">
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Karolina Nędza-Sikoniowska">
    <title>Pasieka Miodek Uli</title>
    <meta name="description" content="Mała, przydomowa pasieka rodzinna u podnóża Tatr. Internetowy sklep     pszczelarski.">
    <meta name="keywords" content="miód, pasieka, sklep internetowy, Tatry">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon-bee.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
	<link rel="stylesheet" href="styl1.css" type="text/css">
    <meta http-equiv="creation-date" content="Mon, 06 May 2017 21:29:02 GMT">
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
  
<div id="top"><nav>
	<div class="nav"><a href="index.php">o nas</a></div>
    <div class="nav"><a href="news.php">co nowego?</a></div>
    <div class="nav"><a href="sklep.php">sklep</a></div>
	<div class="nav"><a href="kontakt.php">kontakt</a></div>
    <?php
	if (isset($_SESSION['zalogowany'])&&$_SESSION['zalogowany']==true)
	{
		echo '<div class="nav"><a href="user_start.php">twoje konto</a></div>';
	}
	else
	{
		echo '<div class="nav"><a href="register.php">rejestracja</a></div>';
	}
	?>
	<?php
	if (isset($_SESSION['zalogowany'])&&$_SESSION['zalogowany']==true)
	{
		echo '<div class="nav"><a href="logout.php"><span style="color:crimson;">wyloguj</span></a></div>';
	}
	else
	{
		echo '<div class="nav"><a href="login.php"><span style="color:crimson;">zaloguj</span></a></div>';
	}
	?>
	<div style="clear:both"></div>
</nav></div>
 
 <div id="logo">
	<h1>Pasieka MIODEK ULI</h1>
	<h2>Witaj <?php echo $_SESSION['user']?>! Rejestracja udana!</h2>
 </div>
 
 <div id="main">
	<div id="maincontent">
	<h3>Twoje dane:</h3>
<?php 
	require_once "mysql.php";
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
	
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);	
			$connection->set_charset("utf8");
			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$query = "SELECT U.login, U.imie, U.nazwisko, U.email, E.nazwa, A.ulica, A.nrdomu, A.kodpocztowy, A.miejscowosc, U.zgoda_news 
				FROM user AS U, adres AS A, edu AS E
				WHERE 
				A.id_adres=U.adres 
				AND  E.id_edu=U.wyksztalcenie
				AND U.login = '".$_SESSION['user']."';";		//zapytanie o dane użytkownika
				$result = $connection->query($query);
				if(!$result) throw new Exception($connection->error);	//jeśli nie udało się zapytanie
				else													//jeśli zapytanie się udało 
				{
					
					$kolumna = $result->fetch_assoc(); 		//zapisywanie wyniku do zmiennej (tablicy) kolumna
						
						echo '<strong>Login: </strong>'.$kolumna['login'].'<br>';
						echo '<strong>Imię: </strong>'.$kolumna['imie'].'<br>';
						echo '<strong>Nazwisko: </strong>'.$kolumna['nazwisko'].'<br>';
						echo '<strong>E-mail: </strong>'.$kolumna['email'].'<br>';
						echo '<strong>Wykształcenie: </strong>'.$kolumna['nazwa'].'<br>';
						echo '<strong>Adres<br>Ulica: </strong>'.$kolumna['ulica'].$kolumna['nrdomu'].'<br>'.$kolumna['kodpocztowy'].', '.$kolumna['miejscowosc'].'<br>';
						echo '<strong>Zgoda na newsletter: </strong>';
						if ($kolumna['zgoda_news']==0)
							echo 'nie<br>';
						else if ($kolumna['zgoda_news']==1)
							echo 'tak<br>';
						else echo 'brak danych!<br>';
						echo '<strong>Hobby: </strong><br>';
						// zapytanie o hobby
						$query = "SELECT hobby.nazwa FROM hobby, user_hobby 
									WHERE user_hobby.id_hobby=hobby.id_hobby
									AND user_hobby.login = '".$_SESSION['user']."';";
						$result = $connection->query($query);
						while ($wiersz = $result->fetch_array())	//wyświetlanie zainteresowań
						{
							echo "$wiersz[0]"."<br>";
						}
						
					$result->free();
				}
				$connection->close();
			}
		}
		catch(Exception $err)
		{
			echo '<span class="error" style="font-weight: bold; font-size: 3em;">Błąd w bazie danych! Przepraszamy za utrudnienia. Koniecznie wróć do nas później!</span>';
			//echo '<br>Informacja developerska: '.$err;
		}
?>
		<p><strong>Zaloguj się teraz na swoje konto!</strong></p>
		<a href="login.php">możesz to zrobić klikając tutaj</a>
	</div>
		<div style="clear: both"></div>
	</div>
	<footer>
		 <small>Wszystkie prawa zastrzeżone &copy;2017, <a href="mailto:karolcia999@gmail.com">Karolina Nędza-Sikoniowska</a></small>
	</footer>
</body>
</html>
