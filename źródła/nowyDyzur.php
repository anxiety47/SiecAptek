<?php

session_start();

$apteka = $_REQUEST["apteka"];
$dzien = $_REQUEST["dzien"];
$start = $_REQUEST["start"];
$stop = $_REQUEST["stop"];

/*
$dzienTimestamp = strtotime($dzien);
$dzienTygodnia = date('l',$dzienTimestamp);

if($dzienTygodnia == "Sunday" || $dzienTygodnia == "Saturday")
	$specjalny = TRUE;
else $specjalny = FALSE;
*/


$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

if ($dzien == '' || $start == $dzien . " " || $stop == $dzien . " ")
        echo "<br/>Nie wszystkie dane są uzupełnione";
else
{
	$dzienTimestamp = strtotime($dzien);
	$dzienTygodnia = date('l',$dzienTimestamp);

	if($dzienTygodnia == "Sunday" || $dzienTygodnia == "Saturday")
        	$specjalny = TRUE;
	else $specjalny = FALSE;

	if ($specjalny == true)
        	$wstaw =  pg_query_params($db, "INSERT INTO projekt.dyzur VALUES(DEFAULT,$1,$2,$3, true)", array($apteka,$start,$stop));
	else	
		 $wstaw =  pg_query_params($db, "INSERT INTO projekt.dyzur VALUES(DEFAULT,$1,$2,$3,false)", array($apteka,$start,$stop));
		
        if( pg_last_error() )
                echo "<br/>Błędne dane - nie wpisano do bazy.";
        else
                echo "<br/>Dane przesłane.";
}

echo "<br/><br/>Naciśnij przycisk <i>Aktualizuj bazę</i> po wprowadzeniu wszystkich nowych rekordów<br/>";
echo "<button onclick='zakoncz()'>Aktualizuj bazę</button>";


?>

