<?php

session_start();

$pracownik = $_REQUEST["pracownik"];
$dyzur = $_REQUEST["dyzur"];

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

if ($pracownik == '' || $dyzur == '')
        echo "<br/>Nie wszystkie dane są uzupełnione";
else
{

        $wstaw =  pg_query_params($db, "INSERT INTO projekt.dyzur_pracownik VALUES($1,$2)", array($dyzur, $pracownik));

	//echo pg_last_error();
        if( pg_last_error() )
                echo "<br/>Błędne dane - nie wpisano do bazy.";
        else
                echo "<br/>Dane przesłane.";
}

echo "<br/><br/>Naciśnij przycisk <i>Aktualizuj bazę</i> po wprowadzeniu wszystkich nowych rekordów<br/>";
echo "<button onclick='zakoncz()'>Aktualizuj bazę</button>";

?>

