<?php
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

$ileLekow = $_REQUEST["licznik"];

for ($i = 0; $i < $ileLekow; $i++)
{
        $lek = "lek" . $i;
        $ilosc = "ile" . $i;

        $tabLekow[$i]['lek'] = $_REQUEST[$lek];
        $tabLekow[$i]['ilosc'] = $_REQUEST[$ilosc];

}

$klient = null;
$zamowienie = pg_query_params($db, "INSERT INTO projekt.zamowienie VALUES (default,$1,$2,$3)",array($klient,$id,date('Y-m-d H:i:s')));

$idZ = pg_query_params($db, "SELECT projekt.podaj_id_zamowienia_bez_klienta($1,$2)",array($id,date('Y-m-d H:i:s')));
$idZamowienia = pg_fetch_row($idZ);

echo "<br/>numer zamówienia: " . $idZamowienia[0] . "<br/>";

for ($x = 0; $x < $ileLekow; $x++)
{
	$zamowienieProdukt = pg_query_params($db, "INSERT INTO projekt.zamowienie_produkt VALUES($1,$2,$3)",array($idZamowienia[0], $tabLekow[$x]['lek'], $tabLekow[$x]['ilosc'] ));
        $magazyn = pg_query_params($db, "SELECT projekt.aktualizuj_stan_magazynu($1,$2,$3)",array($id, $tabLekow[$x]['lek'], $tabLekow[$x]['ilosc']));
        $przychody = pg_query_params($db, "SELECT projekt.aktualizuj_przychody($1,$2,$3)",array($id, $tabLekow[$x]['lek'], $tabLekow[$x]['ilosc']));


        //echo "<br/>" . $idZamowienia[0] . " " . $tabLekow[$x]['lek'] . " " . $tabLekow[$x]['ilosc'] . "<br/>";

        }

        //$magazyn = pg_query_params($db, "SELECT aktualizuj_stan_magazynu($1,$2,$3)",array($id, $tabLekow[$x]['lek'], $tabLekow[$x]['ilosc']));

        echo "<b>Zamówienie zostało zrealizowane.</b><br/>";
        echo "<button id='koniecZamowienia' onclick='anuluj_zamowienie()'>Zakończ</button>";




//echo "bez";
?>
