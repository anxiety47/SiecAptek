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

$imieK = $_REQUEST["imieK"];
$nazwiskoK = $_REQUEST["nazwiskoK"];
$adresK = $_REQUEST["adresK"];
$peselK = $_REQUEST["peselK"];
$telK = $_REQUEST["nrTelK"];

//echo "sth";

//$test = pg_query($db, "SELECT imie from projekt.klient where id_klienta=1");
//$testpg = pg_fetch_row($test);
//echo $testpg[0];


$dodaj = pg_query_params($db, "INSERT INTO projekt.klient VALUES(default,$1,$2,$3,$4,$5)", array($imieK,$nazwiskoK,$adresK,$peselK,$telK));

// dowiedziec się jakos jak zwrocic blad (ew. sprawdzac czy klient jest w bazie funkcja
//
//echo pg_last_error();
//

$klientB = pg_query_params($db, "select projekt.czy_klient_jest_w_bazie($1)",array($peselK));
$czyKlientWBazie = pg_fetch_row($klientB);
//echo "<br/>czy klient jest w bazie? : " . $czyKlientWBazie[0]  . "<br/>";

if ($czyKlientWBazie[0] == t)
{
	echo "<br/>Dane klienta zostały zapisane w bazie.<br/>";
	$idK = pg_query_params($db,"select projekt.sprawdz_id_klienta($1)",array($peselK));
        $idKlienta = pg_fetch_row($idK);

	//echo $idKlienta[0];
	
	$zamowienie = pg_query_params($db, "INSERT INTO projekt.zamowienie VALUES (default,$1,$2,$3)",array($idKlienta[0],$id,date('Y-m-d H:i:s')));

	$idZ = pg_query_params($db, "SELECT projekt.podaj_id_zamowienia($1,$2,$3)",array($idKlienta[0],$id,date('Y-m-d H:i:s')));
	$idZamowienia = pg_fetch_row($idZ);

	echo "Nr zamówienia: " . $idZamowienia[0] . "<br/>";
	
	for ($x = 0; $x < $ileLekow; $x++) 
	{
		$zamowienieProdukt = pg_query_params($db, "INSERT INTO projekt.zamowienie_produkt VALUES($1,$2,$3)",array($idZamowienia[0], $tabLekow[$x]['lek'], $tabLekow[$x]['ilosc'] ));
		$magazyn = pg_query_params($db, "SELECT projekt.aktualizuj_stan_magazynu($1,$2,$3)",array($id, $tabLekow[$x]['lek'], $tabLekow[$x]['ilosc']));
		$przychody = pg_query_params($db, "SELECT projekt.aktualizuj_przychody($1,$2,$3)",array($id, $tabLekow[$x]['lek'], $tabLekow[$x]['ilosc']));
	
		
		//echo "<br/>" . $idZamowienia[0] . " " . $tabLekow[$x]['lek'] . " " . $tabLekow[$x]['ilosc'] . "<br/>";

		//echo "dzialaaaa";
	}

	//$magazyn = pg_query_params($db, "SELECT aktualizuj_stan_magazynu($1,$2,$3)",array($id, $tabLekow[$x]['lek'], $tabLekow[$x]['ilosc']));

	echo "<b>Zamówienie zostało zrealizowane.<b/><br/>";
	echo "<button id='koniecZamowienia' onclick='anuluj_zamowienie()'>Zakończ</button>";


}
else 
	echo "Dane klienta są źle wypełnione.";













//echo "dane wczytane";
?>
