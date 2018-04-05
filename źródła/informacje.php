<?php
session_start();
$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

$wynik = pg_query_params($db, "select a.id_apteka, a.adres, m.nazwa AS miasto, a.nr_telefonu FROM projekt.miasta m JOIN projekt.apteki a ON m.id_miasto=a.id_miasto WHERE a.id_apteka=$1", array($id));

$rekord=pg_fetch_assoc($wynik);

echo "ID apteki: " . $rekord['id_apteka'] . "<br/>";
echo "Adres:  " . $rekord['adres'] . "<br/>";
echo "Miasto: " . $rekord['miasto'] . "<br/>";
echo "Numer telefonu: " . $rekord['nr_telefonu'] . "<br/>";

$pracIlosc = pg_query_params($db, "select count(*) FROM projekt.pracownicy WHERE id_apteka=$1", array($id));
$iloscPracownikow = pg_fetch_row($pracIlosc);

echo "Liczba pracowników zatrudnionych w aptece: " . $iloscPracownikow[0] ;



?>
