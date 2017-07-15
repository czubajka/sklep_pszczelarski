<?php
	session_start();
	
	if(!isset($_POST['login'])||(!isset($_POST['pswd'])))
	{
		header('Location: login.php');
		exit();
	}
	
	require_once "mysql.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	$connection->set_charset("utf8");
	if($connection->connect_errno!=0)
	{
		echo 'Error:'."$connection->connect_errno";
		//echo " Opis: ".$connection->connect_error;
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['pswd'];
		
		
		
		if($result = @$connection->query(
					sprintf("SELECT * FROM admin WHERE login='%s'",
					mysqli_real_escape_string($connection, $login))))
			{
				$num_of_users = $result->num_rows;
				if($num_of_users==1)
				{
					echo"doszło";
					$r = $result->fetch_assoc();
					if($password == $r['haslo'])
					{	
						$_SESSION['zalogowany'] = true;
						$_SESSION['admin'] = true;
						echo"doszło";
						unset($_SESSION['blad_logowania']); //usuwa ew ustawiony błąd logowania
						header('Location: admin.php');
						exit();
						$result->free(); 	//zwalnia pamięć				
					}
				}
			}
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		if ($result = @$connection->query(
		sprintf("SELECT * FROM user AS U, adres AS A, edu AS E WHERE U.adres = A.id_adres AND U.wyksztalcenie=E.id_edu AND U.login='%s'",
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
					$_SESSION['edu'] = $kolumna['nazwa'];
					$_SESSION['adres'] = $kolumna['adres'];
					$_SESSION['ulica'] = $kolumna['ulica'];
					$_SESSION['nrdomu'] = $kolumna['nrdomu'];
					$_SESSION['miejscowosc'] = $kolumna['miejscowosc'];
					$_SESSION['kodpocztowy'] = $kolumna['kodpocztowy'];
					
					
					
					unset($_SESSION['blad_logowania']); //usuwa ew ustawiony błąd logowania
				
					$result->free(); 	//zwalnia pamięć
				
					if(isset($_POST['zkasy']) && $_POST['zkasy']==true)
					{
						unset($_POST['zkasy']);
						header('Location: do_kasy.php');
					}	
					else
					{
						header('Location: user_start.php'); //przekierowanie do strony głównej użytkownika
					}
					
				}				
				else
				{
					$_SESSION['blad_logowania'] = '<span style="color:red">Nieprawidłowe hasło lub login!</span>';
					if(isset($_POST['zkasy']) && $_POST['zkasy']==true)
					{
						unset($_POST['zkasy']);
						header('Location: do_kasy.php');
					}	
					else
					{
						header('Location: login.php');
					}
				}
			}
			else
			{
			$_SESSION['blad_logowania'] = '<span style="color:red">Nieprawidłowe hasło lub login!</span>';
			if(isset($_POST['zkasy']) && $_POST['zkasy']==true)
					{
						unset($_POST['zkasy']);
						header('Location: do_kasy.php');
					}	
					else
					{
						header('Location: login.php');
					}
			}
		}
		
		$connection->close();
	}
?>