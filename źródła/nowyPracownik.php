<?php

session_start();

$imie = $_REQUEST["imie"];
$nazwisko = $_REQUEST["nazwisko"];
$stanowisko = $_REQUEST["stanowisko"];
$apteka = $_REQUEST["apteka"];
$pensja = $_REQUEST["pensja"];
$telefon = $_REQUEST["telefon"];
$pesel = $_REQUEST["pesel"];


$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

$wstaw =  pg_query_params($db, "INSERT INTO projekt.pracownicy VALUES(DEFAULT,NULLIF($1,''),NULLIF($2,''),NULLIF($3,''),$4,$5,NULLIF($6,''),NULLIF($7,''))", array($imie,$nazwisko,$stanowisko,$apteka,$pensja,$telefon,$pesel));


if( pg_last_error() )
        echo "<br/>Błędne dane - nie wpisano do bazy.";
else
        echo "<br/>Dane przesłane.";

echo "<br/><br/>Naciśnij przycisk <i>Aktualizuj bazę</i> po wprowadzeniu wszystkich nowych rekordów<br/>";
echo "<button onclick='zakoncz()'>Aktualizuj bazę</button>";


?>
