<?php
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";


$wynik = pg_query_params($db, "select p.imie, p.nazwisko, p.stanowisko,d.godzina_rozpoczecia,d.godzina_zakonczenia FROM projekt.pracownicy p, projekt.dyzur d, projekt.dyzur_pracownik dp WHERE d.id_dyzuru_apteki=dp.id_dyzuru_apteki AND dp.id_pracownika=p.id_pracownika AND p.id_apteka=$1", array($id));


echo "<table><tr><th>imię</th><th>nazwisko</th><th>stanowisko</th><th>rozpoczęcie dyżuru</th><th>zakończenie dyżuru</th></tr>";
while($rekord=pg_fetch_assoc($wynik))
{
        if ($rekord[godzina_rozpoczecia] <= date('Y-m-d 23:59:59') && $rekord[godzina_zakonczenia] >= date('Y-m-d 00:00:00'))
        {
		echo "<tr>";
                foreach ($rekord as $value)
                        echo "<td>$value</td>";
                echo "</tr>";

	}
}
 echo "</table>";



?>
