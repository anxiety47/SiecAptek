// funkcja otwierajaca zakladki
function openTabs(e, tab) {
	var a = document.getElementById('apteka');
	var s = document.getElementById('sprzedaz');
	var m = document.getElementById('magazyn');
	var p = document.getElementById('pracownicy');
	var d = document.getElementById('dyzury');
	var k = document.getElementById('klienci');
	var stat = document.getElementById('statystyki');


	a.style.display = 'none';
	s.style.display = 'none';
	m.style.display = 'none';
	p.style.display = 'none';
	d.style.display = 'none';
	k.style.display = 'none';
	stat.style.display = 'none';


	if (tab == 'apteka')
		a.style.display = 'block';
	if (tab == 'sprzedaz')
		s.style.display = 'block';		
	if (tab == 'magazyn')
                m.style.display = 'block';
	if (tab == 'pracownicy')
                p.style.display = 'block';
	if (tab == 'dyzury')
                d.style.display = 'block';
	if (tab == 'klienci')
                k.style.display = 'block';
	if (tab == 'statystyki')
                stat.style.display = 'block';

}

function openTabsA(e, tab) {
        var a = document.getElementById('aptekaA');
        var ma = document.getElementById('miastaA');
        var m = document.getElementById('magazynA');
        var p = document.getElementById('pracownicyA');
        var d = document.getElementById('dyzuryA');
        var pa = document.getElementById('produktyA');

        a.style.display = 'none';
        ma.style.display = 'none';
        m.style.display = 'none';
        p.style.display = 'none';
        d.style.display = 'none';
        pa.style.display = 'none';

        if (tab == 'apteki')
                a.style.display = 'block';
        if (tab == 'miasta')
                ma.style.display = 'block';
        if (tab == 'magazyn')
                m.style.display = 'block';
        if (tab == 'pracownicy')
                p.style.display = 'block';
        if (tab == 'dyzury')
                d.style.display = 'block';
        if (tab == 'produkty')
                pa.style.display = 'block';


}

