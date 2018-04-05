<?php

session_start();

$nazwa = $_REQUEST["nazwa"];
$ilosc = $_REQUEST["ilosc"];
$cena = $_REQUEST["cena"];
$postac = $_REQUEST["postac"];
$producent = $_REQUEST["producent"];
$recepta = $_REQUEST["recepta"];


$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

if ($ilosc == '' || $cena == '' || $recepta == '')
	echo "<br/>Nie wszystkie dane są uzupełnione";
else
{
	
	$wstaw =  pg_query_params($db, "INSERT INTO projekt.produkt VALUES(DEFAULT,NULLIF($1,''),$2,$3,NULLIF($4,''),NULLIF($5,''),$6)", array($nazwa,$ilosc,$cena,$postac,$producent,$recepta));


	if( pg_last_error() )
        	echo "<br/>Błędne dane - nie wpisano do bazy.";
	else
        	echo "<br/>Dane przesłane.";
}

echo "<br/><br/>Naciśnij przycisk <i>Aktualizuj bazę</i> po wprowadzeniu wszystkich nowych rekordów<br/>";
echo "<button onclick='zakoncz()'>Aktualizuj bazę</button>";

?>
