<?php
session_start();
require_once "mysql.php";

$_SESSION['opis_admin'] = "Wejście do admin.php" ;
if (!isset($_SESSION['admin']) || (!$_SESSION['admin'] == true)) //jeśli nieprawda, że zalogowany admin
	{
		
		$_SESSION['opis_admin'] = "Nie rozpoznano admina";
		header('Location: sklep.php');
		exit();
	}
	
mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			$connection->set_charset("utf8");			
			if($connection->connect_errno!=0)
			{throw new Exception(mysqli_connect_errno());}
			else
			{
				$query = "";
				
				if(isset($_POST['dodaj_m']))
				{
					$query = "INSERT INTO miody VALUES(NULL, '".$_POST['nazwamiodu']."', '".$_POST['opismiodu']."')";
					if($connection->query($query))
					{
						$_SESSION['opis_admin'] = "Dodano nowy rodzaj miodu do bazy.";
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				elseif(isset($_POST['usunm']))
				{
					$query = "DELETE FROM miody WHERE id_miod ='".$_POST['idmiodu']."'";
					if($connection->query($query))
					{
						$_SESSION['opis_admin'] = "Usunięto miód ".$_POST['idmiodu'];
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				elseif(isset($_POST['usunsloik']))
				{
					$query = "DELETE FROM miod_poj WHERE id_mp ='".$_POST['sloik']."'";
					if($connection->query($query))
					{
						$_SESSION['opis_admin'] = "Usunięto miód ".$_POST['sloik'];
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				elseif(isset($_POST['dodaj_mp']))
				{
					$query = "INSERT INTO miod_poj VALUES(NULL, '".$_POST['id_miod']."', '".$_POST['id_poj']."', '".$_POST['cena']."', '".$_POST['ilosc']."')";
					if($connection->query($query))
					{
						$_SESSION['opis_admin'] = "Dodano miód/słoik";
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				elseif(isset($_POST['order']))
				{
					$query = "UPDATE zamowienie SET status = '".$_POST['status']."' WHERE zamowienie.id_zamowienie ='".$_POST['id_zamowienie']."'";
					if($connection->query($query))
					{
						$_SESSION['opis_admin'] = "Zaktualizowano zamówienie";
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				$connection->close();
			}
		}
		catch(Exception $err)
		{
			$_SESSION['opis_admin'] = $err;
		}
		
		header('Location: admin.php');
		exit();
?>
