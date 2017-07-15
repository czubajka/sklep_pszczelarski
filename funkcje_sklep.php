<?php 
require "mysql.php";

function blad($err)
{
	echo '<span class="error" style="font-weight: bold; font-size: 3em;">Błąd w bazie danych! Przepraszamy za utrudnienia. Koniecznie wróć do nas później!</span>';				
	echo '<br>Informacja developerska: '.$err;
}

function wynik_do_tablicy($result)
{
		$result_table = array();
		for ($j = 0 ; $row = $result->fetch_assoc() ; $j++)
		{
			$result_table[$j] = $row;
		}
	return $result_table;
}

function pobierz_typy_miodow()	//pobieranie typów miodów z bazy
{
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
			try
			{
				$connection = polacz();
				if($connection->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{
					$query = "SELECT M.nazwa_m, M.id_miod 
					FROM miody AS M;";
					$result = $connection->query($query);
					if(!$result) throw new Exception($connection->error);	//jeśli nie udało się zapytanie
					else													//jeśli zapytanie się udało 
					{	
						$num_of_prod =$result->num_rows;					 //ilość znalezionych produktów
						if ($num_of_prod == 0)
						{
							echo '<p class="error">Brak miodów, wszystkie zjedzone... Zapraszamy po następnym miodobraniu!</p>';
						}
						$result = wynik_do_tablicy($result);
					}
					$connection->close();
					return $result;
				}
			}
			catch(Exception $err)
			{
				blad($err);
			}
}

function wyswietl_miody($tablica_miodow)
{
	if(!is_array($tablica_miodow))
	{
		echo '<p class="error">Brak miodów w bazie</p>';
		return;
	}
	echo "<ul>";
	foreach($tablica_miodow as $row)
	{
		$url = "show_me_my_miod.php?id_miod=".($row['id_miod']);
		$miod = $row['nazwa_m'];
		echo "<li>";
		echo '<a href="'.$url.'"alt="miod">'.$miod.'</a><br>';	//tworzenie linka do szczegolow
	}	
}

function pobierz_nazwe_miodu($id_miod)
{
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
			try
			{
				$connection = polacz();
				if($connection->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{
					$query = "SELECT M.nazwa_m 
					FROM miody AS M WHERE M.id_miod = '".$id_miod."'";
					$result = $connection->query($query);
					if(!$result) throw new Exception($connection->error);	//jeśli nie udało się zapytanie
					else													//jeśli zapytanie się udało 
					{	
						$num_of_prod =$result->num_rows;					 //ilość znalezionych produktów
						if ($num_of_prod == 0)
						{
							echo '<p class="error">Brak miodów, wszystkie zjedzone... Zapraszamy po następnym miodobraniu!</p>';
						}
						$row = $result->fetch_object();
						return $row->nazwa_m;
					}
					$connection->close();
				}
			}
			catch(Exception $err)
			{
				blad($err);
			}
}

function pobierz_miody($miod)
{
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
				try
				{
					$connection = polacz();
					if($connection->connect_errno!=0)
					{
						throw new Exception(mysqli_connect_errno());
					}
					else
					{
						$query = "SELECT M.nazwa_m, MP.id_mp, P.nazwa_poj
						FROM miody AS M, miod_poj AS MP, pojemnosc AS P
						WHERE MP.rodzaj = M.id_miod AND MP.pojemnosc = P.id_poj AND M.nazwa_m = '$miod';";
						$result = $connection->query($query);
						if(!$result) throw new Exception($connection->error);	//jeśli nie udało się zapytanie
						else													//jeśli zapytanie się udało 
						{	
							$num_of_prod =$result->num_rows;					 //ilość znalezionych produktów
							if ($num_of_prod == 0)
							{
								echo '<p class="error">Brak miodów, wszystkie zjedzone... Zapraszamy po następnym miodobraniu!</p>';
							}
							$result = wynik_do_tablicy($result);
						}
						$connection->close();
						return $result;
					}
				}
				catch(Exception $err)
				{
					blad($err);
				}	
}

function wyswietl_miody_pojemnosci($tablica_miodow)
{	
	if(!is_array($tablica_miodow))
	{
		echo '<p class="error">Brak miodów w bazie</p>';
		return;
	}
	echo "<ul>";
	foreach($tablica_miodow as $row)
	{
		$url = "ten_sloik_miodu.php?id_mp=".($row['id_mp']);
		$miod = $row['nazwa_m'];
		$pojemnosc = $row['nazwa_poj'];
		echo "<li>";
		echo '<a href="'.$url.'"alt="miod">Miód '.$miod.'- pojemność '.$pojemnosc.'</a><br>';	//tworzenie linka do szczegolow
	}	
}

function pobierz_szczegoly_miodu($id_mp)
{
	if ((!$id_mp) ||($id_mp==''))
	{
		echo '<p class="error">Nie ma takiego miodu!</p>';
	}
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
				try
				{
					$connection = polacz();
					if($connection->connect_errno!=0)
					{
						throw new Exception(mysqli_connect_errno());
					}
					else
					{
						$query = "SELECT M.nazwa_m, M.id_miod, MP.id_mp, P.nazwa_poj, M.opis_m, MP.cena, MP.stan
						FROM miody AS M, miod_poj AS MP, pojemnosc AS P
						WHERE MP.rodzaj = M.id_miod AND MP.pojemnosc = P.id_poj AND MP.id_mp = '$id_mp';";
						$result = $connection->query($query);
						if(!$result) throw new Exception($connection->error);	//jeśli nie udało się zapytanie
						else													//jeśli zapytanie się udało 
						{	
							$result = @$result->fetch_assoc();
						}
						$connection->close();
						return $result;
					}
				}
				catch(Exception $err)
				{
					blad($err);
				}		
}

function wyswietl_szczegoly_mp($miod) 		//wyświetla szczegółowe dane o wybranym miodzie
{
  if (is_array($miod)) 
  {
    echo "<table><tr>";
    if (@file_exists("img/".($miod['nazwa_m']).".jpg")) {
      $wielkosc = GetImageSize("img/".$miod['nazwa_m'].".jpg");
      if(($wielkosc[0] > 0) && ($wielkosc[1] > 0)) {
        echo "<td><img src=\"img/".$miod['nazwa_m'].".jpg\" style=\"border: 1px solid black\"/></td";
      }
    }
    echo "<td><ul>";
    echo "<li><strong>RODZAJ MIODU:</strong> ";
    echo $miod['nazwa_m'];
    echo "</li><li><strong>ID PRODUKTU:</strong> ";
    echo $miod['id_mp'];
	echo "<li><strong>POJEMNOŚĆ:</strong> ";
    echo $miod['nazwa_poj'];
    echo "</li><li><strong>Cena:</strong> ";
    echo $miod['cena'];
	echo "<li><strong>Ilość w magazynie:</strong> ";
    echo $miod['stan'];
    echo "</li><li><strong>Opis:</strong> ";
    echo $miod['opis_m'];
    echo "</li></ul></td></tr></table>";
  } 
  else {
    echo "Dane miodu niedostępne. Wróć tu za chwilkę.";
  }
}

function przycisk($cel, $dzialanie) {
  echo '<a href="'.$cel.'" class="button">'.$dzialanie.'</a>';
}

function pokaz_koszyk($koszyk, $zmiany = true)
{
	echo "<table border= \"0\" width= \"auto\" cellspacing=\"10\">
	<form action=\"".$_SESSION['url']."\" method=\"POST\">
	<tr><th colspan=\"1\" bgcolor=\"cccccc\">Produkt</th>
	<th bgcolor=\"cccccc\">Cena jednostkowa</th>
	<th bgcolor=\"cccccc\">Ilość</th>
	<th bgcolor=\"cccccc\">Cena za ilość</th>
	</tr>";
	
	foreach($koszyk as $id_mp=>$ilosc)
	{
		$miod= pobierz_szczegoly_miodu($id_mp);
		echo "<tr>";
		echo "<td align=\"left\">
		<a href=\"ten_sloik_miodu.php?id_mp=".$id_mp."\">Miód ".$miod['nazwa_m']."</a>, pojemność ".$miod['nazwa_poj']."
		</td><td align=\"left\">PLN ".$miod['cena']."
		</td><td align=\"center\">";
		
		if($zmiany==true)
		{
			echo "<input type=\"text\" name=\"$id_mp\" value=\"$ilosc\" size=\"2\">";
		}
		else echo $ilosc;
		
		echo "</td><td align=\"right\">PLN ".number_format($miod['cena']*$ilosc,2)."</td></tr><br>";	
	}
	
	echo "<tr>
			<th colspan=\"2\" bgcolor=\"cccccc\"&nbsp;</td>
			<th align=\"center\" bgcolor=\"#cccccc\">
			".$_SESSION['produkty_ilosc']."
			</th>
			<th align=\"right\" bgcolor=\"#cccccc\">
			PLN ".number_format($_SESSION['suma'],2)."
			</th>
			</tr>";
	
	if($zmiany==true)
	{
		echo "<tr>
				<td colspan=\"2\">&nbsp;</td>
				<td align=\"center\">
					<input type=\"hidden\" name=\"zapisz\" value=\"true\" />
					<input type=\"submit\" value=\"Zapisz zmiany\">
				</td><td>&nbsp;</td>
				</tr>";
	}
	echo "</form></table>";
}

function policz_produkty($koszyk)	//obliczanie ilości produktów w koszyku
{
	$produkty=0;
	if(is_array($koszyk))
	{
		foreach($koszyk as $id_mp=>$produkty_ilosc)
		{
			$produkty+=$produkty_ilosc;
		}
	}
	return $produkty;
}

function policz_sume($koszyk)		//obliczanie całkowitej wartości zamówionych produktów
{
	$suma = 0.0;
	if(is_array($koszyk))
	{
		$connection = polacz();
		foreach($koszyk as $id_mp=>$produkty_ilosc)
		{
			$query = "SELECT cena FROM miod_poj WHERE id_mp='".$id_mp."'";
			$result = $connection->query($query);
			if($result)
			{
				$produkt = $result->fetch_object();
				$cena_produktu = $produkt->cena;
				$suma += $cena_produktu*$produkty_ilosc;
			}
		}
	}
	return $suma;
}

function wyswietl_dane()
{
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
	
		try
		{
			$connection = polacz();	
			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$query = "SELECT U.login, U.imie, U.nazwisko, U.email, A.ulica, A.nrdomu, A.kodpocztowy, A.miejscowosc 
				FROM user AS U, adres AS A
				WHERE 
				A.id_adres=U.adres 
				AND U.login = '".$_SESSION['login']."';";		//zapytanie o dane użytkownika
				$result = $connection->query($query);
				if(!$result) throw new Exception($connection->error);	//jeśli nie udało się zapytanie
				else													//jeśli zapytanie się udało 
				{
					
					$kolumna = $result->fetch_assoc(); 		//zapisywanie wyniku do zmiennej (tablicy) kolumna
						
						echo '<p><strong>Imię: </strong>'.$kolumna['imie'].'</p>';
						echo '<p><strong>Nazwisko: </strong>'.$kolumna['nazwisko'].'</p>';
						echo '<p><strong>E-mail: </strong>'.$kolumna['email'].'</p>';
						echo '<p><strong>Adres<br>Ulica: </strong>'.$kolumna['ulica'].$kolumna['nrdomu'].'<br>'.$kolumna['kodpocztowy'].', '.$kolumna['miejscowosc'].'</p><br>';
					$result->free();
				}
				$connection->close();
			}
		}
		catch(Exception $err)
		{
			echo '<span class="error" style="font-weight: bold; font-size: 3em;">Błąd w bazie danych! Przepraszamy za utrudnienia. Koniecznie wróć do nas później!</span>';
			echo '<br>Informacja developerska: '.$err;
		}
}

function pobierz_dostawe()
{
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
	
		try
		{
			$connection = polacz();
				if($connection->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{
					$query = "SELECT nazwa, id_przesylka, cena
					FROM przesylka;";
					$result = $connection->query($query);
					if(!$result) throw new Exception($connection->error);	//jeśli nie udało się zapytanie
					else													//jeśli zapytanie się udało 
					{	
						$num_of_prod =$result->num_rows;					 //ilość znalezionych produktów
						if ($num_of_prod == 0)
						{
							echo '<p class="error">Problemy z dostawcami! W związku z tym dostawa darmowa ;)</p>';
						}
						$result = $result->fetch_assoc;
					}
					$connection->close();
					return $result;
				}
		}
		catch(Exception $err)
		{
			blad($err);
		}
}

function wyczysc_koszyk()
{
	if(isset($_SESSION['suma'])) 
	{
		unset($_SESSION['suma']);
	}
	
	if(isset($_SESSION['produkty_ilosc']))
	{
		unset($_SESSION['produkty_ilosc']);
	}

	if(isset($_SESSION['koszyk']))
	{
		unset($_SESSION['koszyk']);
	}
	
	if(isset($_SESSION['dostawa']))
	{
		unset($_SESSION['dostawa']);
	}
}

function zamowienia($user)
{
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
				try
				{
					$connection = polacz();
					if($connection->connect_errno!=0)
					{
						throw new Exception(mysqli_connect_errno());
					}
					else
					{
						$query = "SELECT Z.id_zamowienie, Z.data_zamowienia, S.nazwa
						FROM zamowienie AS Z, status AS S
						WHERE Z.status = S.id_status AND Z.klient = '$user';";
						$result = $connection->query($query);
						if(!$result) throw new Exception($connection->error);	//jeśli nie udało się zapytanie
						else													//jeśli zapytanie się udało 
						{	
							$num_of_prod =$result->num_rows;					 //ilość znalezionych zamówień
							if ($num_of_prod == 0)
							{
								echo '<p class="error">Brak zamówień</p>';
							}
						}
						$connection->close();
						return $result;
					}
				}
				catch(Exception $err)
				{
					blad($err);
				}	
}

function szczegolyzamowienia($nr)
{
	mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
				try
				{
					$connection = polacz();
					if($connection->connect_errno!=0)
					{
						throw new Exception(mysqli_connect_errno());
					}
					else
					{
						$query  = "SELECT M.nazwa_m, TZ.cenajednostkowa, POJ.nazwa_poj, TZ.ilosc, TZ.id_zamowienia 
						FROM zamowienie AS Z, tresc_zamowienia AS TZ, miod_poj AS MP, miody AS M, pojemnosc AS POJ
						WHERE TZ.id_zamowienia = Z.id_zamowienie AND TZ.towar = MP.id_mp AND MP.rodzaj = M.id_miod AND MP.pojemnosc = POJ.id_poj AND TZ.id_zamowienia = '".$nr."'";
						$result = $connection->query($query);
						if(!$result) throw new Exception($connection->error);	//jeśli nie udało się zapytanie
						else													//jeśli zapytanie się udało 
						{	
							$num_of_prod =$result->num_rows;					 //ilość znalezionych zamówień
							if ($num_of_prod == 0)
							{
								echo '<p class="error">Brak danych</p>';
							}
						}
						$connection->close();
						return $result;
						
					}
				}
				catch(Exception $err)
				{
					blad($err);
				}		
}

?>