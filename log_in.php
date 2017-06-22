<?php
	session_start();
	
	if(!isset($_POST['login'])||(!isset($_POST['pswd'])))
	{
		header('Location: login.php');
		exit();
	}
	
	require_once "mysql.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo 'Error:'."$connection->connect_errno";
		//echo " Opis: ".$connection->connect_error;
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['pswd'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		if ($result = @$connection->query(
		sprintf("SELECT * FROM user WHERE login='%s'",
		mysqli_real_escape_string($connection, $login))))
		{
			$num_of_users = $result->num_rows;
			if($num_of_users==1)
			{
				$kolumna = $result->fetch_assoc();
				
				if(password_verify($password, $kolumna['haslo']))
				{	
					$_SESSION['zalogowany'] = true;
				
					$_SESSION['login'] = $kolumna['login'];
					$_SESSION['imie'] =$kolumna['imie'];
					$_SESSION['nazwisko'] =$kolumna['nazwisko'];
					$_SESSION['email'] =$kolumna['email'];
					$_SESSION['zgoda_news'] =$kolumna['zgoda_news'];
					$_SESSION['edu'] = $kolumna['wyksztalcenie'];
				
					unset($_SESSION['blad_logowania']); //usuwa ew ustawiony błąd logowania
				
					$result->free(); 	//zwalnia pamięć
				
					header('Location: user_start.php'); //przekierowanie do strony głównej użytkownika
				}
				else
				{
					$_SESSION['blad_logowania'] = '<span style="color:red">Nieprawidłowe hasło lub login!</span>';
					header('Location: login.php');
				}
			}
			else
			{
			$_SESSION['blad_logowania'] = '<span style="color:red">Nieprawidłowe hasło lub login!</span>';
			header('Location: login.php');
			}
		}
		
		$connection->close();
	}
?>