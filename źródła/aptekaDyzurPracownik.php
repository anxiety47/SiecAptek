<?php
session_start();

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "Brak połączenia z bazą";

$idA = $_REQUEST['apteka'];



echo "<br/>Pracownik: <select id='dpPracownik'>";
$result = pg_query($db, "SELECT id_pracownika, imie, nazwisko FROM projekt.pracownicy where id_apteka=$idA");
while($row=pg_fetch_assoc($result))
        echo "<option value='$row[id_pracownika]'>$row[imie] $row[nazwisko]</option>";
echo "</select><br/>";

echo "<br/>Dyżur: <select id='dpDyzur'>";
$result = pg_query($db, "SELECT id_dyzuru_apteki, godzina_rozpoczecia, godzina_zakonczenia FROM projekt.dyzur where id_apteka=$idA");
while($row=pg_fetch_assoc($result))
        echo "<option value='$row[id_dyzuru_apteki]'>od $row[godzina_rozpoczecia] do  $row[godzina_zakonczenia]</option>";
echo "</select><br/>";


echo "<br/><button onclick='nowyDyzurPracownik()'>Prześlij</button>";

?>
