<?php
session_start();
//echo "szczegoly";
$q = $_REQUEST["q"];

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

echo "<br/>Wybierz rodzaj leku oraz ilość sztuk w opakowaniu/pojemność opakowania<br/>";

$wynik = pg_query_params($db, "select projekt.wypisz_postacie_leku($1)", array($q));

echo "<select id='postac'>";
while($rekord=pg_fetch_row($wynik))
{
        echo "<option value='$rekord[0]'>$rekord[0]</option>";
}
echo "</select>    ";


$wynik2 = pg_query_params($db, "select projekt.wypisz_ilosc_leku($1)", array($q));

echo "<select id='ilosc'>";
while($rekord2=pg_fetch_row($wynik2))
{
        echo "<option value='$rekord2[0]'>$rekord2[0]</option>";
}
echo "</select>";

echo "<br/><br/>Wybierz ilość sztuk<br/>";
echo "<input type='number' id='ileSztuk' min='0'>";

//echo "<button id='dodajNastepny' onclick='dodajNastepnyLek()'> Dodaj lek </button>";
echo "<button id='zatwieedzLek' onclick='zatwierdzLek()'> Zatwierdź </button>";
?>
