<?php
session_start();

//Header('Location: ' . $_SERVER['PHP_SELF']);

//header('Expires:Mon,01 Jan 2018 00:00:00 GMT');
//header('Last-Modified:' . gmdate("D,d M Y H:i:s") . " GMT");
//header('Cache-Control:no-store, no-cache,must-revalidate');
//header('Cache-Control: post-check=0, pre-check=0', FALSE);
//header('Pragma: no-cache');

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

$wynik = pg_query_params($db, "select p.id_produktu,p.nazwa,p.ilosc_w_opakowaniu,p.cena,p.postac,p.producent,m.ilosc FROM projekt.magazyn m JOIN projekt.produkt p ON m.id_produktu=p.id_produktu WHERE m.id_apteka=$1", array($id));

echo "<table>";
echo "<tr><th>ID produktu</th><th>nazwa</th><th>ilość w opakowaniu</th><th>cena</th><th>postac</th><th>producent</th><th>ilość</th></tr>";

while($rekord=pg_fetch_row($wynik))
{
        //$rekord[0] = str_replace("(", "",$rekord[0]);
        //$rekord[0] = str_replace(")", "",$rekord[0]);
        //$wiersz = explode(",",$rekord[0]);
        echo "<tr>";
        foreach ($rekord as $value)
                echo "<td>$value</td>";
        echo "</tr>";

}
echo "</table>";
?>
