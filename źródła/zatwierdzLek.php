<?php
session_start();

$lek = $_REQUEST["lek"];
$postac = $_REQUEST["postac"];
$ilosc = $_REQUEST["ilosc"];
$ilesztuk = $_REQUEST["ilesztuk"];

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";


if ($ilesztuk < 1 || $ilesztuk == NULL)
        echo "To pole musi być uzupełnione";
else {

	$idP = pg_query_params($db, "select projekt.podaj_id_produktu($1, $2, $3)", array($lek, $postac, $ilosc));
	$idProdukt = pg_fetch_row($idP);

	$ileWMag = pg_query_params($db, "select projekt.sprawdz_ile_sztuk_w_magazynie($1,$2)",array($idProdukt[0], $id));
	$ileWMagazynie = pg_fetch_row($ileWMag);

	if ($ileWMagazynie[0] == NULL)	
		echo "<b>Nie ma takiego leku w magazynie. Sprawdź, czy dane są poprawne</b>";
	else if ($ileWMagazynie[0] < $ilesztuk) {
		echo "<b>W magazynie obecnie znajduje się tylko </b>" . $ileWMagazynie[0] . "<b> sztuk. Wprowadź inne dane lub zakończ transakcję.</b>";
		echo "<br/><button id='zakonczZaMaloSztuk' onclick='anuluj_zamowienie()'>Zakończ</button>";
	}
	else 
	{
		echo "<input type='number' id='idLeku' value='$idProdukt[0]'>";
		///////
		

		echo "<br/><button id='dodajNastepny' onclick='dodajNastepnyLek()'> Dodaj lek </button>";
		echo "<button id='zakonczZamowienie' onclick='zakonczZamowienie()'> Zakończ zamowienie </button>";
		
		
	}

	//	echo $tabLeki[0]['id'];
	//	echo $tabLeki[0]['ilosc'];
	
	/*
	{
		echo "<br/>ok<br/>";
		$recepta = pg_query_params($db, "select projekt.sprawdz_czy_lek_na_recepte($1)",array($idProdukt[0]));
		$czyNaRecepte = pg_fetch_row($recepta);
		
		if ($czyNaRecepte[0] == t) {
			echo "<br/>Lek jest na receptę, musisz podać dane klienta alby kontynuować.";
			echo "Imię: <br/><input type='text' id='imieKlienta' required><br/>";
	                echo "Nazwisko:<br/><input type='text' id='nazwiskoKlienta' required><br/>";
        	        echo "adres:<br/><input type='text' id='adresKlienta' required><br/>";
               		echo "PESEL:<br/><input type='text' id='peselKlienta' required><br/>";
            		echo "numer telefonu: <br/><input type='text' id='nrtelKlienta' required><br/>";
                	echo "<button onclick='walidacjaKlient()' id = 'przeslijDaneKlienta'>Prześlij dane </button>";
                //echo "<input type='submit' value='prześlij' id='przeslijDaneKlienta'>";

		}
		else
		{
			echo "<br/>Lek nie jest na receptę, wpisanie danych klienta nie jest obowiązkowe<br/>";
			echo "tuu";
		
		//echo "Imię: <br/><input type='text' id='imieKlienta'><br/>";
		//echo "Nazwisko:<br/><input type='text' id='nazwiskoKlienta'><br/>";
		//echo "adres:<br/><input type='text' id='adresKlienta'><br/>";
		//echo "PESEL:<br/><input type='text' id='peselKlienta'><br/>";
		//echo "numer telefonu: <br/><input type='text' id='nrtelKlienta'><br/>";
		//echo "<button onclick='walidacja()' id = 'przeslijDaneKlienta'>Prześlij dane </button>";
		
		}
	}
	*/
}




/*

echo "<select id='postac'>";
while($rekord=pg_fetch_row($wynik))
{
        echo "<option value='$rekord[0]'>$rekord[0]</option>";
}
echo "</select>    ";


$wynik2 = pg_query_params($db, "select projekt.wypisz_ilosc_leku($1)", array($q));

echo "<select id='ilosc'>";
while($rekord2=pg_fetch_row($wynik2))
{
        echo "<option value='$rekord2[0]'>$rekord2[0]</option>";
}
echo "</select>";


echo "<button id='infoOKliencie' onclick='infoOKliencie()'> Zatwierdź </button>";
*/
?>

