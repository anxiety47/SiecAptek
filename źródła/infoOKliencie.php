<?php
session_start();
$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";


$ileLekow = $_REQUEST["licznik"];
$i;
for ($i = 0; $i < $ileLekow; $i++)
{
	$lek = "lek" . $i;
	$ilosc = "ile" . $i;

	$tabLekow[$i]['lek'] = $_REQUEST[$lek];
	$tabLekow[$i]['ilosc'] = $_REQUEST[$ilosc];
 
}
$dane = false;
for ($i = 0; $i < $ileLekow; $i++)
{
	$recepta = pg_query_params($db, "select projekt.sprawdz_czy_lek_na_recepte($1)",array($tabLekow[$i]['lek']));
	$czyNaRecepte = pg_fetch_row($recepta);
	if ($czyNaRecepte[0] == t)
		$dane = true;
}

if ($dane == true)
{
	echo "<br/>W zamówieniu znajduje się lek na receptę - wymagane są informacje o kliencie<br/><br/>";
	echo "Imię: <br/><input type='text' id='imieKlienta' required><br/>";
        echo "Nazwisko:<br/><input type='text' id='nazwiskoKlienta' required><br/>";
        echo "Adres(ulica i miasto):<br/><input type='text' id='adresKlienta' required><br/>";
        echo "PESEL:<br/><input type='text' id='peselKlienta' required><br/>";
        echo "Numer telefonu: <br/><input type='text' id='nrtelKlienta' required><br/>";
        echo "<br/><button onclick='walidacjaKlient()' id = 'przeslijDaneKlienta'>Prześlij dane </button>";



}
else
{
	echo "<br/>W zamówieniu nie ma produktów na receptę - dane klienta nie będą wprowadzane.<br/>";
	echo  "<button onclick='sprzedazBezKlienta()' id = 'realizujZamowienie'>Zrealizuj zamówienie </button>";

}
?>
