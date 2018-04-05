<?php
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";


$wynik = pg_query_params($db, "select distinct k.id_klienta,k.imie,k.nazwisko,k.adres,k.pesel,k.nr_telefonu FROM projekt.klient k JOIN projekt.zamowienie z ON k.id_klienta=z.id_klienta WHERE z.id_apteka=$1", array($id));

echo "<table><tr><th>ID klienta</th><th>imię</th><th>nazwisko</th><th>adres</th><th>PESEL</th><th>Numer telefonu</th></tr>";
while($rekord=pg_fetch_row($wynik))
{
        echo "<tr>";
        foreach ($rekord as $value)
                echo "<td>$value</td>";
        echo "</tr>";

}
echo "</table>";
?>
