<?php
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";


$wynik = pg_query_params($db, "select projekt.najlepszych_10_klientow($1)", array($id));

echo pg_last_error();

echo "<br/><h3>10 klientów, którzy zrealizowali najwięcej zamówień</h3>";
echo "<table><tr><th>ID klienta</th><th>imie</th><th>nazwisko</th><th>pesel</th><th>ilość zamówień</th></tr>";

//echo pg_last_error();

while($rekord=pg_fetch_row($wynik))
{

        $rekord[0] = str_replace(")", "",$rekord[0]);
        $rekord[0] = str_replace("(", "",$rekord[0]);
        //$rekord[0] = str_replace("\"", "\'",$rekord[0]);

        $wiersz = explode(",",$rekord[0]);
        echo "<tr>";

        echo "<td>$wiersz[0]</td>";
        $klient = pg_query_params($db, "select imie,nazwisko,pesel from projekt.klient where id_klienta=$1", array($wiersz[0]));
        $osoba=pg_fetch_assoc($klient);

        echo "<td>$osoba[imie]</td>";
        echo "<td>$osoba[nazwisko]</td>";
        echo "<td>$osoba[pesel]</td>";

        echo "<td>$wiersz[1]</td>";


        echo "</tr>";

}
echo "</table>";

?>
