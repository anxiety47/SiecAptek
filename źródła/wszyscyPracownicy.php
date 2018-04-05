<?php
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";


$wynik = pg_query_params($db, "select id_pracownika,imie, nazwisko, stanowisko,nr_telefonu FROM projekt.pracownicy WHERE id_apteka=$1", array($id));

echo "<table><tr><th>ID pracownika</th><th>imię</th><th>nazwisko</th><th>stanowisko</th><th>numer telefonu</th></tr>";
while($rekord=pg_fetch_row($wynik))
{
        echo "<tr>";
        foreach ($rekord as $value)
                echo "<td>$value</td>";
        echo "</tr>";

}
echo "</table>";
?>
