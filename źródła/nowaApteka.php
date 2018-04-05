<?php

session_start();

$miasto = $_REQUEST["miasto"];
$adres = $_REQUEST["adres"];
$telefon = $_REQUEST["telefon"];

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

$wstaw =  pg_query_params($db, "INSERT INTO projekt.apteki VALUES(DEFAULT,NULLIF($1,''),$2,$3,0,0)", array($adres,$miasto,$telefon));

if( pg_last_error() )
	echo "<br/>Błędne dane - nie wpisano do bazy.";
else
	echo "<br/>Dane przesłane.";

echo "<br/><br/>Naciśnij przycisk <i>Aktualizuj bazę</i> po wprowadzeniu wszystkich nowych rekordów<br/>";
echo "<button onclick='zakoncz()'>Aktualizuj bazę</button>";

?>
