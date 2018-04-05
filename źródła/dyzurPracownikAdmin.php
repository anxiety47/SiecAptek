<?php
session_start();

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "Brak połączenia z bazą";

echo "<h3>Dodawanie rekordów do tablicy <i>Dyżur_Pracownik</i></h3>";
echo "Wszystkie pola są wymagane - jeśli nie zostaną wypełnione rekord nie zostanie dodany do bazy<br/><br/>";


echo "Apteka: <select id='dpApteka'>";
$result = pg_query($db, "SELECT a.id_apteka, m.nazwa, a.adres FROM projekt.apteki a JOIN projekt.miasta m ON a.id_miasto=m.id_miasto");
while($row=pg_fetch_assoc($result))
        echo "<option value='$row[id_apteka]'>$row[adres] $row[nazwa]</option>";
echo "</select><br/>";

echo "<br/><button onclick='aptekaDyzurPracownik()'>Prześlij</button>";


/*
echo "Pracownik: <select id='dpPracownik'>";
$result = pg_query($db, "SELECT id_pracownika, imie, nazwisko FROM projekt.pracownicy");
while($row=pg_fetch_assoc($result))
        echo "<option value='$row[id_pracownika]'>$row[imie] $row[nazwisko]</option>";
echo "</select><br/>";

echo "Dyżur: <select id='dpDyzur'>";
$result = pg_query($db, "SELECT id_dyzuru_apteki, godzina_rozpoczecia, godzina_zakonczenia FROM projekt.dyzur");
while($row=pg_fetch_assoc($result))
        echo "<option value='$row[id_dyzuru_apteki]'>$row[godzina_rozpoczecia] $row[godzina_zakonczenia]</option>";
echo "</select><br/>";


echo "<br/><button onclick='nowyDyzurPracownik()'>Prześlij</button>";


*/
?>
