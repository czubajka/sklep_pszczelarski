<?php
	session_start();
	
	if (!isset($_SESSION['udanarejestracja']))	//jeśli użytkownik wszedł na stronę bezpośrednio po adresie, zostanie przekierowany na stronę do rejestracji (w przyszłości na stronę logowania)
	{
		header('Location: p1rejestracja.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	
	//Usuwanie zmiennych sesyjnych pamiętających wartości wpisywane do pól rejestracji oraz błędów
		if(isset($_SESSION['form_login'])) unset($_SESSION['form_login']);
		if(isset($_SESSION['form_email'])) unset($_SESSION['form_email']);
		if(isset($_SESSION['form_name'])) unset($_SESSION['form_name']);
		if(isset($_SESSION['form_sname'])) unset($_SESSION['form_sname']);
		if(isset($_SESSION['form_edu'])) unset($_SESSION['form_edu']);
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
		if(isset($_SESSION['error_adres'])) unset($_SESSION['error_adres']);
		if(isset($_SESSION['error_recaptcha'])) unset($_SESSION['error_recaptcha']);	
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl-PL">
<head>
	<meta charset="utf-8"/>
	<title>Udana rejestracja</title>
	<style>.error{color:red}</style>
</head>
<body>
	<h2>Witaj!</h2>
	
	<p>Dziękujemy za rejestrację!</p>
	<p>Twoje dane:</p>
	<br><br>
<?php 
	require_once "mysql.php";
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
	
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);	
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
				AND U.login = '".$_SESSION['zalogowany']."';";		//zapytanie o dane użytkownika
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
									AND user_hobby.login = '".$_SESSION['zalogowany']."';";
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
		session_destroy()
?>

</body>
</html>