--WIDOKI I WYWOLUJACE JE FUNKCJE

--widok zamowienia_info
CREATE VIEW zamowienia_info AS SELECT z.id_apteka, z.id_zamowienia, p.nazwa AS nazwa_leku, p.producent, p.postac, p.ilosc_w_opakowaniu, p.cena, zp.ilosc, k.imie, k.nazwisko, k.pesel FROM zamowienie z, zamowienie_produkt zp, produkt p, klient k WHERE k.id_klienta=z.id_klienta, z.id_zamowienia=zp.id_zamowienia, zp.id_produktu=p.id_produktu;

CREATE OR REPLACE FUNCTION wypisz_zamowienia(integer) RETURNS setof zamowienia_info AS '
	SELECT * from projekt.zamowienia_info WHERE id_apteka=$1;
' LANGUAGE sql;

--widok wszystkie_zamowienia
CREATE VIEW wszystkie_zamowienia AS SELECT z.id_apteka,
    z.id_zamowienia,
    p.nazwa AS nazwa_leku,
    p.producent,
    p.postac,
    p.ilosc_w_opakowaniu,
    p.cena,
    zp.ilosc,
    k.imie,
    k.nazwisko,
    k.pesel,
    k.nr_telefonu
   FROM zamowienie_produkt zp,
    produkt p,
    zamowienie z
     FULL JOIN klient k ON k.id_klienta = z.id_klienta
  WHERE z.id_zamowienia = zp.id_zamowienia AND zp.id_produktu = p.id_produktu;

CREATE OR REPLACE FUNCTION wypisz_wszystkie_zamowienia(integer) RETURNS setof zamowienia_info AS '
	SELECT * from projekt.wszystkie_zamowienia WHERE id_apteka=$1;
' LANGUAGE sql;

--apteka_info
CREATE VIEW apteka_info AS SELECT a.id_apteka AS id,
    a.adres,
    m.nazwa AS miasto,
    a.nr_telefonu
   FROM apteki a,
    miasta m
  WHERE a.id_miasto = m.id_miasto;

--POZOSTALE FUNKCJE
CREATE OR REPLACE FUNCTION podaj_id_produktu(varchar,varchar,integer) RETURNS integer AS'
DECLARE
lek ALIAS FOR $1;
postacLeku ALIAS FOR $2;
ilosc ALIAS FOR $3;
id integer;
BEGIN
SELECT id_produktu INTO id FROM projekt.produkt WHERE nazwa=lek AND postacLeku=postac AND ilosc=ilosc_w_opakowaniu;
RETURN id;
END;
' LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION sprawdz_czy_lek_na_recepte(integer) RETURNS boolean AS '
DECLARE
id ALIAS FOR $1;
sprawdz boolean;
BEGIN
SELECT czy_na_recepte INTO sprawdz FROM projekt.produkt WHERE id_produktu=id;
RETURN sprawdz;
END;
' LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION sprawdz_ile_sztuk_w_magazynie(integer,integer) RETURNS integer AS '
DECLARE
id ALIAS FOR $1;
apteka ALIAS FOR $2;
ile integer;
BEGIN
SELECT ilosc INTO ile FROM projekt.magazyn WHERE id_produktu=id AND id_apteka=apteka;
RETURN ile;
END;
' LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION czy_klient_jest_w_bazie(varchar) RETURNS boolean AS '
DECLARE
nr_pesel ALIAS FOR $1;
id integer;
wynik boolean;
BEGIN
SELECT id_klienta INTO id FROM projekt.klient WHERE pesel=nr_pesel;
IF NOT FOUND THEN
	wynik=false;
ELSE
	wynik=true;
END IF;
RETURN wynik;
END;
' LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION dodaj_klienta(varchar,varchar,varchar,varchar,varchar) RETURNS void AS'
DECLARE
nowe_imie ALIAS FOR $1;
nowe_nazwisko ALIAS FOR $2;
nowy_adres ALIAS FOR $3;
nowy_pesel ALIAS FOR $4;
nowy_tel ALIAS FOR $5;
BEGIN
INSERT INTO projekt.klient VALUES(DEFAULT,nowe_imie,nowe_nazwisko,nowy_adres,nowy_pesel,nowy_tel);
RETURN;
END;
' LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION sprawdz_id_klienta(varchar) RETURNS integer AS'
DECLARE
nr_pesel ALIAS FOR $1;
id integer;
BEGIN
SELECT id_klienta INTO id FROM projekt.klient WHERE pesel=nr_pesel;
RETURN id;
END;
' LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION podaj_id_zamowienia(integer,integer,timestamp) RETURNS integer AS '
DECLARE
id integer;
BEGIN
SELECT id_zamowienia INTO id FROM projekt.zamowienie WHERE id_klienta=$1 AND id_apteka=$2 AND data_sprzedazy=$3;
RETURN id;
END;
' LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION podaj_id_zamowienia_bez_klienta(integer,timestamp) RETURNS integer AS '
DECLARE
id integer;
BEGIN
SELECT id_zamowienia INTO id FROM projekt.zamowienie WHERE id_apteka=$1 AND data_sprzedazy=$2;
RETURN id;
END;
' LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION aktualizuj_stan_magazynu(integer, integer, integer) RETURNS void AS '
DECLARE
id_a ALIAS FOR $1;
id_p ALIAS FOR $2;
ile ALIAS FOR $3;
BEGIN
UPDATE projekt.magazyn SET ilosc=ilosc-ile WHERE id_produktu=id_p AND id_apteka=id_a;
RETURN;
END;
' LANGUAGE plpgsql;




CREATE OR REPLACE FUNCTION aktualizuj_przychody(integer, integer, integer) RETURNS void AS '
DECLARE
id_a ALIAS FOR $1;
id_p ALIAS FOR $2;
ile ALIAS FOR $3;
c float;
BEGIN
SELECT cena INTO c FROM projekt.produkt WHERE id_produktu=id_p;
c = c*ile;
UPDATE projekt.apteki SET przychody=c+przychody WHERE id_apteka=id_a;
RETURN;
END;
' LANGUAGE plpgsql;

CREATE OR REPLACE function wypisz_postacie_leku(varchar) RETURNS setof varchar AS '
DECLARE
lek ALIAS FOR $1;
arg record;
BEGIN
	FOR arg IN SELECT DISTINCT postac FROM projekt.produkt WHERE nazwa=lek LOOP
		RETURN NEXT arg.postac;
	END LOOP;
RETURN;
END;
' LANGUAGE plpgsql;


CREATE OR REPLACE function wypisz_ilosc_leku(varchar) RETURNS setof integer AS '
DECLARE
lek ALIAS FOR $1;
arg record;
BEGIN
	FOR arg IN SELECT DISTINCT ilosc_w_opakowaniu FROM projekt.produkt WHERE nazwa=lek LOOP
		RETURN NEXT arg.ilosc_w_opakowaniu;
	END LOOP;
RETURN;
END;
' LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION min_magazyn(integer) RETURNS integer AS'
DECLARE
id_a ALIAS FOR $1;
ilosc_min integer;
BEGIN
SELECT min(ilosc) INTO ilosc_min FROM projekt.magazyn WHERE id_apteka=id_a;
RETURN ilosc_min;
END;
' LANGUAGE plgpsql;

create type ilosc_sprzedanych_produktow AS (produkt int, suma bigint);
CREATE OR REPLACE FUNCTION sprzedane_produkty(integer) RETURNS setof ilosc_sprzedanych_produktow AS'
select zp.id_produktu, sum(zp.ilosc) from projekt.zamowienie_produkt zp, projekt.zamowienie z WHERE zp.id_zamowienia=z.id_zamowienia AND z.id_apteka=$1 group by zp.id_produktu order by zp.id_produktu;
' LANGUAGE sql;

create type naj_10_klientow AS (klient int, ilosc bigint);
CREATE OR REPLACE FUNCTION najlepszych_10_klientow(integer) RETURNS setof naj_10_klientow AS'
select id_klienta, count(*) from projekt.zamowienie  where id_klienta is not NULL AND id_apteka=$1 group by  id_klienta order by count desc limit 10;
' LANGUAGE sql;

