<?php session_start(); ?>
<?php include 'czyZalogowany.php'; ?>
<!DOCTYPE html>
<head>
	<title> Baza </title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<script src="Baza.js"> </script>
	<!-- dodaj link do skryyptu -->
</head>
<body>

	<div class="tab">
		<button class = "tablinks" id ="aptekaTab" onclick="openTabs(event,'apteka')"> Info </button>
		<button class = "tablinks" id ="sprzedazTab" onclick="openTabs(event,'sprzedaz')"> Sprzedaż </button>
		<button class = "tablinks" id ="magazynTab" onclick="openTabs(event,'magazyn')"> Magazyn </button>
		<button class = "tablinks" id ="pracownicyTab" onclick="openTabs(event,'pracownicy')"> Pracownicy </button>
		<button class = "tablinks" id ="dyzuryTab" onclick="openTabs(event,'dyzury')"> Dyżury </button>
		<button class = "tablinks" id ="klienciTab" onclick="openTabs(event,'klienci')"> Klienci </button>
		<button class = "tablinks" onclick="openTabs(event,'statystyki')"> Statystyki </button>


		<a href = "wylogowanie.php">Wyloguj z bazy </a>
		<!-- <button class = "tablinks" id ="dataID" onclick="openTabs(event,'data')"> Dane </button> -->
	</div>
	
	<div id = "apteka"> 
		<?php include 'informacje.php'; ?>
	</div>
	<div id = "sprzedaz">
		<div class="funkcjeSprzedaz">
			<button id="noweZamowienie" onclick="start()"> Nowe Zamówienie </button>
			<button id="infoOZamowieniach" onclick="wypiszZamowienia()">Wypisz zamówienia na receptę</button>
			<button id="zamowieniaWszystkie" onclick="wypiszWszystkieZamowienia()">Wypisz wszystkie zamówienia</button>
		</div>
		<div class ="zawartoscSprzedaz" id="zawartoscSprzedaz">
			<div id="divSprzedaz"></div>
			<div id="divInfoLek"></div>
			<div id="divZamowienie"></div>
			<div id="divKlient"></div>
			<div id ="divZakoncz">
				<br/><br/><button id='zakoncz' onclick='anuluj_zamowienie()'>Anuluj zamówienie</button>
			</div>
			<!-- <div id="zamowieniaWidok"></div> -->
		</div>
		<div  class = "zawartoscSprzedaz" id="zamowieniaWidok"></div>
	</div>

	<div id = "magazyn">
		<div class="funkcjeMagazyn">
			<button id="obecnieMagazyn" onclick="obecnieMagazyn()">Stan magazynu </button>
			<button id="mniejNiz" onclick="magazyn_mniej_niz_podane()">Sprawdź ilość </button>
		</div>
		<div id = "obecnieWMagazynie"></div>
		<div id = "magazynMniejNiz"></div>
	</div>
	<div id = "pracownicy">
		<div class="funkcjePracownicy">
			<button onclick="sprawdzStanowisko()">Sprawdź kadrę</button>
			<button onclick="pracownicyApteki()">Wyświetl pracowników apteki</button>
		</div>
		<div id = "wszyscyPracownicy"></div>
		<div id = "stanowiska"></div>
		<div id = "wybraneStanowisko"></div>
	</div>	

	<div id = "dyzury">
		<div class="funkcjeDyzury">	
			<button onclick="osobyNaDyzurze()">Wyświetl pracowników na obecnym dyżurze </button>
			<button onclick="dyzuryDzien()">Wyświetl informacje o dzisiejszych dyżurach </button>
		</div>
		<div id="obecnyDyzur"></div>
		<div id="dyzuryDzisiaj"></div>

	</div>

	<div id = "klienci">
		<div class="funkcjeKlienci">
			<button onclick="klienciApteki()">Wyświetl klientów apteki</button>
		</div>
		<div id="wszyscyKlienci"></div>
	</div>

	 <div id = "statystyki">
                <div class="funkcjeStatystyki">
                        <button onclick="sprzedaneLeki()">Ilość sprzedanych leków</button>
			<button onclick="najlepsiKlienci()">Najlepsi klienci</button>
                </div>
                <div id="sprzedaneLeki"></div>
		<div id="najKlienci"></div>
        </div>


<script>

var zamowienie = new Object;

statystyki.style.display = 'none';
klienci.style.display = 'none';
dyzury.style.display = 'none';
pracownicy.style.display = 'none';
magazyn.style.display = 'none';
sprzedaz.style.display = 'none';
apteka.style.display = 'block';

divZakoncz.style.display = 'none';

function wypiszStanowisko()
{
	var x = document.getElementById('wyborStanowiska').value;

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("wybraneStanowisko").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "wypiszStanowisko.php?stanowisko="+x, true);
        xhttp.send();

}

function sprawdzStanowisko()
{
	
	wszyscyPracownicy.style.display='none';
	stanowiska.style.display='block';
        wybraneStanowisko.style.display='block';

	document.getElementById("stanowiska").innerHTML = "<?php include 'sprawdzStanowisko.php'; ?>";
}

function informacje()
{
	document.getElementById("apteka").innerHTML = "<?php include 'informacje.php'; ?>";
}


function sprzedaneLeki()
{
	najKlienci.style.display='none';
        
	document.getElementById("sprzedaneLeki").style.display = 'block';
 
       document.getElementById("sprzedaneLeki").innerHTML = "<?php include 'sprzedaneLeki.php'; ?>";
}


function najlepsiKlienci()
{
	najKlienci.style.display='block';
	document.getElementById("sprzedaneLeki").style.display = 'none';
 
       document.getElementById("najKlienci").innerHTML = "<?php include 'najlepsiKlienci.php'; ?>";
}


function obecnieMagazyn()
{
	//location.reload(true);
	//location.assign(Baza.php);
	obecnieWMagazynie.style.display = "block";
        magazynMniejNiz.style.display = "none";
	console.log("magazyn");
	document.getElementById("obecnieWMagazynie").innerHTML = "<?php include'stanMagazynu.php'; ?>";
}


function pracownicyApteki()
{
	wszyscyPracownicy.style.display="block";
        stanowiska.style.display='none';
        wybraneStanowisko.style.display='none';

	 document.getElementById("wszyscyPracownicy").innerHTML = "<?php include 'wszyscyPracownicy.php'; ?>";
}


function klienciApteki()
{
         document.getElementById("wszyscyKlienci").innerHTML = "<?php include 'wszyscyKlienci.php'; ?>";
}

function magazyn_mniej_niz_podane()
{
	obecnieWMagazynie.style.display = "none";
        magazynMniejNiz.style.display = "block";

	document.getElementById("magazynMniejNiz").innerHTML = "<?php include 'magazynMniejNiz.php'; ?>";
}


function znajdz_mniej_w_magazynie()
{
 	var x = document.getElementById('szukajMniej').value;
        
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("magazynMniejNiz").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "magazynMniejNizWypisz.php?mniej="+x, true);
        xhttp.send();
	
}

function osobyNaDyzurze()
{
	dyzuryDzisiaj.style.display = "none";
        obecnyDyzur.style.display = "block";

	document.getElementById("obecnyDyzur").innerHTML = "<?php include 'obecnyDyzur.php'; ?>";
}

function dyzuryDzien()
{
	dyzuryDzisiaj.style.display = "block";
        obecnyDyzur.style.display = "none";

	document.getElementById("dyzuryDzisiaj").innerHTML = "<?php include 'dyzuryDzisiaj.php'; ?>";

}

function wypiszZamowienia()
{
	//zawartoscSprzedaz.style.display = "none";
	divSprzedaz.style.display = "none";
        divInfoLek.style.display = "none";
        divZamowienie.style.display = "none";
        divKlient.style.display = "none";
	divZakoncz.style.display = "none";

	zamowieniaWidok.style.display = "block";

	document.getElementById("zamowieniaWidok").innerHTML = "<?php include 'zrealizowaneZamowienia.php';?>";
}

function wypiszWszystkieZamowienia()
{
	  divSprzedaz.style.display = "none";
        divInfoLek.style.display = "none";
        divZamowienie.style.display = "none";
        divKlient.style.display = "none";
        divZakoncz.style.display = "none";

        zamowieniaWidok.style.display = "block";

        document.getElementById("zamowieniaWidok").innerHTML = "<?php include 'wszystkieZamowienia.php';?>";

}

function start()
{
	//zawartoscSprzedaz.style.display = "block";
	divSprzedaz.style.display = "block";
        divInfoLek.style.display = "block";
        divZamowienie.style.display = "block";
        divKlient.style.display = "block";
	zamowieniaWidok.style.display = "none";



	//tablica na leki
	var tablica = [];
	for (var i = 0; i < 2 ; i++)
		tablica[i] = [];

	zamowienie.leki = tablica;
	zamowienie.licznik = 0;

	nowe_zamowienie();
}


function nowe_zamowienie()
{
	divZakoncz.style.display="block";	
	document.getElementById("divSprzedaz").innerHTML = "<?php include 'sprzedaz.php' ?>";
}

function anuluj_zamowienie()
{
	location.reload(true);
        //location.assign(Baza.php);

	
	document.getElementById("divSprzedaz").innerHTML = "";
	document.getElementById("divInfoLek").innerHTML = "";
	document.getElementById("divZamowienie").innerHTML = "";
	document.getElementById("divKlient").innerHTML = "";
	
	divZakoncz.style.display = "none";
	//divSprzedaz divInfoLek divKlient
}
function szczegolyOLeku()
{	
	var x = document.getElementById('wybierzLek').value;
        //document.getElementById("divSprzedaz").innerHTML += "<?php include 'szczegoly.php' ?>";
	
	var xhttp;
  	xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
      			document.getElementById("divInfoLek").innerHTML = this.responseText;
    		}
  	};
  	xhttp.open("GET", "szczegoly.php?q="+x, true);
  	xhttp.send();   
}




function dodajNastepnyLek()
{
//	console.log(id);
//	console.log(ilosc);

	var ile = document.getElementById('ileSztuk').value;
	var lek = document.getElementById("idLeku").value;

	zamowienie.leki[zamowienie.licznik][0] = lek;
	zamowienie.leki[zamowienie.licznik][1] = ile;
	
	console.log(zamowienie.leki[zamowienie.licznik][0]);

	console.log(zamowienie.leki[zamowienie.licznik][1]);

	zamowienie.licznik +=1;


	document.getElementById("divInfoLek").innerHTML = "";
        document.getElementById("divZamowienie").innerHTML = "";
	nowe_zamowienie();
}

function zakonczZamowienie()
{

	var ile = document.getElementById('ileSztuk').value;
        var lek = document.getElementById("idLeku").value;

        zamowienie.leki[zamowienie.licznik][0] = lek;
        zamowienie.leki[zamowienie.licznik][1] = ile;

        console.log(zamowienie.leki[zamowienie.licznik][0]);

        console.log(zamowienie.leki[zamowienie.licznik][1]);

        zamowienie.licznik +=1;


	var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("divZamowienie").innerHTML = this.responseText;
                }
        };

	var link = "infoOKliencie.php?licznik=" + zamowienie.licznik;
	for (var i = 0; i < zamowienie.licznik; i++)
		link += "&lek" + i + "=" + zamowienie.leki[i][0] + "&ile" + i + "=" + zamowienie.leki[i][1];

        
	console.log(link);
	
	xhttp.open("GET", link, true);
        xhttp.send();

}

function sprzedazBezKlienta()
{
	divZakoncz.style.display="none";

	
	var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("divZamowienie").innerHTML = this.responseText;
                }
        };

        var link = "sprzedazBezKlienta.php?licznik=" + zamowienie.licznik;
        for (var i = 0; i < zamowienie.licznik; i++)
                link += "&lek" + i + "=" + zamowienie.leki[i][0] + "&ile" + i + "=" + zamowienie.leki[i][1];


        console.log(link);

        xhttp.open("GET", link, true);
        xhttp.send();




}

function zatwierdzLek()
{ 	
	var lek = document.getElementById('wybierzLek').value;
        var postac = document.getElementById('postac').value;
        var ile = document.getElementById('ilosc').value;
	var sztuk = document.getElementById('ileSztuk').value;
 
       //document.getElementById("divSprzedaz").innerHTML += "<?php include 'szczegoly.php' ?>";

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("divZamowienie").innerHTML = this.responseText;
                }
        };
        xhttp.open("GET", "zatwierdzLek.php?lek="+lek+"&postac="+postac+"&ilosc="+ile+"&ilesztuk="+sztuk, true);
        xhttp.send();

}

function walidacjaKlient()
{
	divZakoncz.style.display="none";
	
	var imie = document.getElementById('imieKlienta').value;
        var nazwisko = document.getElementById('nazwiskoKlienta').value;
        var adres = document.getElementById('adresKlienta').value;
        var pesel = document.getElementById('peselKlienta').value;
        var nrTel = document.getElementById('nrtelKlienta').value;
	
	if (/*imie == null || nazwisko == null || adres == null || pesel == null || nrTel == null ||*/ imie == "" || nazwisko == "" || adres == "" || pesel == "" || nrTel == "")
		console.log("blad");
	else 
		infoKlient();	
}

function walidacja()
{
	 var imie = document.getElementById('imieKlienta').value;
        var nazwisko = document.getElementById('nazwiskoKlienta').value;
        var adres = document.getElementById('adresKlienta').value;
        var pesel = document.getElementById('peselKlienta').value;
        var nrTel = document.getElementById('nrtelKlienta').value;
	
	 if ((imie != "" && nazwisko != ""  && adres != "" && pesel != "" && nrTel != "") || (imie == "" && nazwisko == "" && adres == "" && pesel == "" && nrTel == ""))
		infoKlient();
	else console.log("błąd - zle wpisane dane klienta");
}

function infoKlient()
{
	var lek = document.getElementById('wybierzLek').value;
        var postac = document.getElementById('postac').value;
        var ile = document.getElementById('ilosc').value;
        var sztuk = document.getElementById('ileSztuk').value;

	var imie = document.getElementById('imieKlienta').value;
        var nazwisko = document.getElementById('nazwiskoKlienta').value;
        var adres = document.getElementById('adresKlienta').value;
        var pesel = document.getElementById('peselKlienta').value;
	var nrTel = document.getElementById('nrtelKlienta').value;

	var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("divKlient").innerHTML = this.responseText;
                }
        };
	
	 var link = "sprzedazZKlientem.php?licznik=" + zamowienie.licznik;
        for (var i = 0; i < zamowienie.licznik; i++)
                link += "&lek" + i + "=" + zamowienie.leki[i][0] + "&ile" + i + "=" + zamowienie.leki[i][1];

	link += "&imieK="+imie+"&nazwiskoK="+nazwisko+"&adresK="+adres+"&peselK="+pesel+"&nrTelK="+nrTel;
        console.log(link);



        xhttp.open("GET",link, true);
        xhttp.send();


}

</script>
</body>
</html>
