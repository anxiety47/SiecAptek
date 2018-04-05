<?php session_start(); ?>
<?php include 'czyZalogowany.php'; ?>
<!DOCTYPE html>
<head>
        <title> Baza-Admin </title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <!-- <script src="Baza.js"> </script> -->
        <!-- dodaj link do skryyptu -->
</head>
<body>
        <div class="tab">
                <button class = "tablinks" id ="aptekiTabA" onclick="openTabsA(event,'apteki')"> Apteki </button>
                <button class = "tablinks" id ="miastaTabA" onclick="openTabsA(event,'miasta')"> Miasta </button>
                <button class = "tablinks" id ="pracownicyTabA" onclick="openTabsA(event,'pracownicy')"> Pracownicy </button>
                <button class = "tablinks" id ="dyzuryTabA" onclick="openTabsA(event,'dyzury')"> Dyżury </button>
		<button class = "tablinks" id ="dyzurPracownikTabA" onclick="openTabsA(event,'dyzurPracownik')">Dyżur-Pracownik </button>
		<button class = "tablinks" id ="produktyTabA" onclick="openTabsA(event,'produkty')">Produkty </button>
		<button class = "tablinks" id ="magazynTabA" onclick="openTabsA(event,'magazyn')">Magazyn </button>

                <a href = "wylogowanie.php">Wyloguj z bazy </a>
        </div>

        <div id = "aptekaA">
         	<?php include 'aptekaAdmin.php'; ?>
		<div id='aptekaForm'></div>
        </div>
        <div id = "miastaA">
           	<?php include 'miastaAdmin.php'; ?>
		<div id='miastoForm'></div>
        </div>

        <div id = "pracownicyA">
		<?php include 'pracownicyAdmin.php'; ?>
                <div id='pracownicyForm'></div>
        </div>

        <div id = "dyzuryA">
		<?php include 'dyzuryAdmin.php'; ?>
                <div id='dyzuryForm'></div>
	</div>
        <div id = "produktyA">
		<?php include 'produktyAdmin.php'; ?>
                <div id='produktyForm'></div>
	</div>

	<div id = "dyzurPracownikA">
                <?php include 'dyzurPracownikAdmin.php'; ?>
                <div id='dyzurPracownikFormApteka'></div>
		<div id='dyzurPracownikForm'></div>
        </div>
	 <div id = "magazynA">
                <?php include 'magazynAdmin.php'; ?>
                <!-- <div id='dyzurPracownikFormApteka'></div> -->
                <div id='magazynForm'></div>
        </div>



<script>


dyzurPracownikA.style.display = 'none';
produktyA.style.display = 'none';
dyzuryA.style.display = 'none';
pracownicyA.style.display = 'none';
miastaA.style.display = 'none';
aptekaA.style.display = 'none';
magazynA.style.display='none';

function openTabsA(e, tab) {
        var a = document.getElementById('aptekaA');
        var m = document.getElementById('miastaA');
        var p = document.getElementById('pracownicyA');
        var d = document.getElementById('dyzuryA');
        var pa = document.getElementById('produktyA');
	var dp = document.getElementById('dyzurPracownikA');
	var mag = document.getElementById('magazynA');
	
	mag.style.display='none';
        a.style.display = 'none';
        m.style.display = 'none';
        p.style.display = 'none';
        d.style.display = 'none';
        pa.style.display = 'none';
	dp.style.display = 'none';

        if (tab == 'apteki')
                a.style.display = 'block';
        if (tab == 'miasta')
                m.style.display = 'block';
        if (tab == 'pracownicy')
                p.style.display = 'block';
        if (tab == 'dyzury')
                d.style.display = 'block';
        if (tab == 'produkty')
                pa.style.display = 'block';
	if (tab == 'dyzurPracownik')
                dp.style.display = 'block';
	if (tab == 'magazyn')
                mag.style.display = 'block';


}
function zakoncz()
{
	location.reload(true);
}


function nowyMagazyn()
{
        var apteka = document.getElementById('magazynApteka').value;
        var produkt = document.getElementById('magazynProdukt').value;
        var ilosc = document.getElementById('magazynIlosc').value;
        document.getElementById("magazynForm").innerHTML = "";


        //console.log(idMiasta + adres + telefon);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("magazynForm").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "nowyMagazyn.php?apteka="+apteka+"&produkt="+produkt+"&ilosc="+ilosc, true);
        xhttp.send();

}

function nowaApteka()
{
	var idMiasta = document.getElementById('aptekaMiasto').value;
	var adres = document.getElementById('aptekaAdres').value;
	var telefon = document.getElementById('aptekaTelefon').value;
	document.getElementById("aptekaForm").innerHTML = "";
	
	
	console.log(idMiasta + adres + telefon);
	var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("aptekaForm").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "nowaApteka.php?miasto="+idMiasta+"&adres="+adres+"&telefon="+telefon, true);
        xhttp.send();
	
}

function noweMiasto()
{
	var miasto = document.getElementById('miastoNazwa').value;
        document.getElementById("miastoForm").innerHTML = "";


	console.log(miasto);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("miastoForm").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "noweMiasto.php?miasto="+miasto, true);
        xhttp.send();
}

function nowyPracownik()
{
        var imie = document.getElementById('pracownikImie').value;
	var nazwisko = document.getElementById('pracownikNazwisko').value;
	var stanowisko = document.getElementById('pracownikStanowisko').value;
	var apteka = document.getElementById('pracownikApteka').value;
	var pensja = document.getElementById('pracownikPensja').value;
	var telefon = document.getElementById('pracownikTelefon').value;
	var pesel = document.getElementById('pracownikPesel').value;

        document.getElementById("pracownicyForm").innerHTML = "";

	
        console.log(imie);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("pracownicyForm").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "nowyPracownik.php?imie="+imie+"&nazwisko="+nazwisko+"&stanowisko="+stanowisko+"&apteka="+apteka+"&pensja="+pensja+"&telefon="+telefon+"&pesel="+pesel, true);
        xhttp.send();
}

function nowyProdukt()
{
        var nazwa = document.getElementById('produktNazwa').value;
        var ilosc = document.getElementById('produktIlosc').value;
        var cena = document.getElementById('produktCena').value;
        var postac  = document.getElementById('produktPostac').value;
        var producent = document.getElementById('produktProducent').value;
        var recepta = document.getElementById('produktRecepta').checked;
      

        document.getElementById("produktyForm").innerHTML = "";


        console.log(recepta);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("produktyForm").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "nowyProdukt.php?nazwa="+nazwa+"&ilosc="+ilosc+"&cena="+cena+"&postac="+postac+"&producent="+producent+"&recepta="+recepta, true);
        xhttp.send();
}

function nowyDyzur()
{
        var apteka = document.getElementById('dyzurApteka').value;
	var dzien = document.getElementById('dyzurDzien').value;
        var start = dzien + " " + document.getElementById('dyzurStart').value;
        var stop = dzien + " " + document.getElementById('dyzurStop').value;
       
	
	console.log(start + " " + stop);

        document.getElementById("dyzuryForm").innerHTML = "";

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dyzuryForm").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "nowyDyzur.php?apteka="+apteka+"&dzien="+dzien+"&start="+start+"&stop="+stop, true);
        xhttp.send();
	
}

function nowyDyzurPracownik()
{
        var pracownik = document.getElementById('dpPracownik').value;
        var dyzur = document.getElementById('dpDyzur').value;
        
        document.getElementById("dyzurPracownikForm").innerHTML = "";

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dyzurPracownikForm").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "nowyDyzurPracownik.php?pracownik="+pracownik+"&dyzur="+dyzur, true);
        xhttp.send();

}

function aptekaDyzurPracownik()
{

	var apteka = document.getElementById('dpApteka').value;
        
        document.getElementById("dyzurPracownikFormApteka").innerHTML = "";

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dyzurPracownikFormApteka").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "aptekaDyzurPracownik.php?apteka="+apteka, true);
        xhttp.send();



}
</script>
</body>
</html>
