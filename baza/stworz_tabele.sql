CREATE SCHEMA projekt;

--TWORZENIE TABEL ORAZ SEKWENCJI DO KLUCZY G£ÓWNYCH
CREATE SEQUENCE projekt.klient_id_klienta_seq;

CREATE TABLE projekt.Klient (
                id_klienta INTEGER NOT NULL DEFAULT nextval('projekt.klient_id_klienta_seq'),
                imie VARCHAR NOT NULL,
                nazwisko VARCHAR NOT NULL,
                adres VARCHAR NOT NULL,
                PESEL VARCHAR NOT NULL,
                nr_telefonu VARCHAR,
                CONSTRAINT klient_pk PRIMARY KEY (id_klienta)
);


ALTER SEQUENCE projekt.klient_id_klienta_seq OWNED BY projekt.Klient.id_klienta;

CREATE SEQUENCE projekt.produkt_id_produktu_seq;

CREATE TABLE projekt.Produkt (
                id_produktu INTEGER NOT NULL DEFAULT nextval('projekt.produkt_id_produktu_seq'),
                nazwa VARCHAR NOT NULL,
                ilosc_w_opakowaniu INTEGER NOT NULL,
                cena DOUBLE PRECISION NOT NULL,
                postac VARCHAR NOT NULL,
                producent VARCHAR NOT NULL,
                czy_refundowane BOOLEAN NOT NULL,
                czy_na_recepte BOOLEAN NOT NULL,
                CONSTRAINT produkt_pk PRIMARY KEY (id_produktu)
);


ALTER SEQUENCE projekt.produkt_id_produktu_seq OWNED BY projekt.Produkt.id_produktu;

CREATE SEQUENCE projekt.miasta_id_miasto_seq_1;

CREATE TABLE projekt.Miasta (
                id_miasto INTEGER NOT NULL DEFAULT nextval('projekt.miasta_id_miasto_seq_1'),
                nazwa VARCHAR NOT NULL,
                CONSTRAINT miasta_pk PRIMARY KEY (id_miasto)
);


ALTER SEQUENCE projekt.miasta_id_miasto_seq_1 OWNED BY projekt.Miasta.id_miasto;

CREATE SEQUENCE projekt.apteki_id_apteka_seq;

CREATE TABLE projekt.Apteki (
                id_apteka INTEGER NOT NULL DEFAULT nextval('projekt.apteki_id_apteka_seq'),
                adres VARCHAR NOT NULL,
                id_miasto INTEGER NOT NULL,
                nr_telefonu VARCHAR NOT NULL,
                przychody REAL,
                koszty REAL,
                CONSTRAINT apteki_pk PRIMARY KEY (id_apteka)
);

ALTER SEQUENCE projekt.apteki_id_apteka_seq OWNED BY projekt.Apteki.id_apteka;

CREATE SEQUENCE projekt.zamowienie_id_zamowienia_seq;

CREATE TABLE projekt.Zamowienie (
                id_zamowienia INTEGER NOT NULL DEFAULT nextval('projekt.zamowienie_id_zamowienia_seq'),
                id_klienta INTEGER references projekt.Klient(id_klienta),
                id_apteka INTEGER NOT NULL,
		data_sprzedazy TIMESTAMP,
                CONSTRAINT zamowienie_pk PRIMARY KEY (id_zamowienia)


);


ALTER SEQUENCE projekt.zamowienie_id_zamowienia_seq OWNED BY projekt.Zamowienie.id_zamowienia;

CREATE TABLE projekt.zamowienie_produkt (
                id_zamowienia INTEGER NOT NULL,
                id_produktu INTEGER NOT NULL,
                ilosc INTEGER NOT NULL,
                CONSTRAINT zamowienie_produkt_pk PRIMARY KEY (id_zamowienia, id_produktu)
);


CREATE TABLE projekt.Magazyn (
                id_apteka INTEGER NOT NULL,
                id_produktu INTEGER NOT NULL,
                ilosc INTEGER NOT NULL,
                CONSTRAINT magazyn_pk PRIMARY KEY (id_apteka, id_produktu)
);


CREATE SEQUENCE projekt.pracownicy_id_pracownika_seq;

CREATE TABLE projekt.Pracownicy (
                id_pracownika INTEGER NOT NULL DEFAULT nextval('projekt.pracownicy_id_pracownika_seq'),
                imie VARCHAR NOT NULL,
                nazwisko VARCHAR NOT NULL,
                stanowisko VARCHAR NOT NULL,
                id_apteka INTEGER NOT NULL,
                pensja INTEGER NOT NULL,
                nr_telefonu VARCHAR NOT NULL,
                PESEL VARCHAR NOT NULL,
                CONSTRAINT pracownicy_pk PRIMARY KEY (id_pracownika)
);


ALTER SEQUENCE projekt.pracownicy_id_pracownika_seq OWNED BY projekt.Pracownicy.id_pracownika;

CREATE SEQUENCE projekt.dyzur_id_dyzuru_apteki_seq;

-- TIMESTAMP zmienione na domeny
CREATE TABLE projekt.Dyzur (
                id_dyzuru_apteki INTEGER NOT NULL DEFAULT nextval('projekt.dyzur_id_dyzuru_apteki_seq'),
                id_apteka INTEGER NOT NULL,
                godzina_rozpoczecia dom_dyzur_start NOT NULL,
                godzina_zakonczenia dom_dyzur_stop NOT NULL,
                czy_specjalny BOOLEAN NOT NULL,
                CONSTRAINT dyzur_pk PRIMARY KEY (id_dyzuru_apteki)
);


ALTER SEQUENCE projekt.dyzur_id_dyzuru_apteki_seq OWNED BY projekt.Dyzur.id_dyzuru_apteki;

CREATE TABLE projekt.dyzur_pracownik (
                id_dyzuru_apteki INTEGER NOT NULL,
                id_pracownika INTEGER NOT NULL,
                CONSTRAINT dyzur_pracownik_pk PRIMARY KEY (id_dyzuru_apteki, id_pracownika)
);


ALTER TABLE projekt.Magazyn ADD CONSTRAINT produkt_magazyn_fk
FOREIGN KEY (id_produktu)
REFERENCES projekt.Produkt (id_produktu)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.zamowienie_produkt ADD CONSTRAINT produkt_zamowienie_produkt_fk
FOREIGN KEY (id_produktu)
REFERENCES projekt.Produkt (id_produktu)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Apteki ADD CONSTRAINT miasta_apteki_fk
FOREIGN KEY (id_miasto)
REFERENCES projekt.Miasta (id_miasto)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Dyzur ADD CONSTRAINT apteki_dyzur_apteki_fk
FOREIGN KEY (id_apteka)
REFERENCES projekt.Apteki (id_apteka)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Pracownicy ADD CONSTRAINT apteki_pracownicy_fk
FOREIGN KEY (id_apteka)
REFERENCES projekt.Apteki (id_apteka)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Magazyn ADD CONSTRAINT apteki_magazyn_fk
FOREIGN KEY (id_apteka)
REFERENCES projekt.Apteki (id_apteka)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.Zamowienie ADD CONSTRAINT apteki_zamowienie_fk
FOREIGN KEY (id_apteka)
REFERENCES projekt.Apteki (id_apteka)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.zamowienie_produkt ADD CONSTRAINT zamowienie_zamowienie_produkt_fk
FOREIGN KEY (id_zamowienia)
REFERENCES projekt.Zamowienie (id_zamowienia)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.dyzur_pracownik ADD CONSTRAINT pracownicy_dyzur_pracownik_fk
FOREIGN KEY (id_pracownika)
REFERENCES projekt.Pracownicy (id_pracownika)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE projekt.dyzur_pracownik ADD CONSTRAINT dyzur_dyzur_pracownik_fk
FOREIGN KEY (id_dyzuru_apteki)
REFERENCES projekt.Dyzur (id_dyzuru_apteki)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

SET search_path TO projekt;
--ustawienie pola PESEL dla klienta i pracownika na unikalny
ALTER TABLE klient ADD CONSTRAINT unikalny_pesel UNIQUE(pesel);
ALTER TABLE pracownicy ADD CONSTRAINT unikalny_pesel_pracownik UNIQUE(pesel);
--TRIGGERY
--trigger do wstawienia odpowiedniego numeru telefonu klienta (funkcja + trigger poni¿ej)
CREATE OR REPLACE FUNCTION wstawianie_klient_nr() RETURNS TRIGGER AS '
DECLARE
--dlugosc integer;
id integer;
BEGIN
IF (TG_OP = ''UPDATE'') THEN
	id :=old.id_klienta;
ELSIF (TG_OP = ''INSERT'') THEN
	id :=new.id_klienta;
END IF;
IF (character_length(new.nr_telefonu) <> 9) THEN
	Raise notice ''nieprawidlowa ilosc cyfr'';
	return null;
ELSE
	Raise notice ''nr ok'';
	return new;
END IF;
END;
' LANGUAGE 'plpgsql';

CREATE TRIGGER nr_telefonu_klient BEFORE INSERT OR UPDATE ON projekt.klient FOR EACH ROW EXECUTE PROCEDURE wstawianie_klient_nr();

--trigger do odpowiedniego wpisywania nr PESEL klienta (funkcja + trigger poni¿ej)
CREATE OR REPLACE FUNCTION wstawianie_klient_pesel() RETURNS TRIGGER AS '
DECLARE
--dlugosc integer;
id integer;
BEGIN
IF (TG_OP = ''UPDATE'') THEN
	id :=old.id_klienta;
ELSIF (TG_OP = ''INSERT'') THEN
	id :=new.id_klienta;
END IF;
IF (character_length(new.pesel) <> 11) THEN
	Raise notice ''nieprawidlowa ilosc cyfr'';
	return null;
ELSE
	Raise notice ''pesel ok'';
	return new;
END IF;
END;
' LANGUAGE 'plpgsql';

CREATE TRIGGER pesel_klient BEFORE INSERT OR UPDATE ON projekt.klient FOR EACH ROW EXECUTE PROCEDURE wstawianie_klient_pesel();

--DOMENY
--domena sprawdzaj¹ca czy dy¿ur zaczyna siê w godzinach 7-16
CREATE DOMAIN  dom_dyzur_start AS timestamp CONSTRAINT dyzur_rozpoczecie CHECK (EXTRACT(hour FROM VALUE) >= 7 AND EXTRACT(hour FROM VALUE) <= 16);

--domena sprawdzaj¹ca czy dy¿ur koñczy siê w godzinach 14-23
CREATE DOMAIN  dom_dyzur_stop AS timestamp CONSTRAINT dyzur_zakonczenie CHECK (EXTRACT(hour FROM VALUE) >= 14 AND EXTRACT(hour FROM VALUE) <= 23);
--domena sprawdzajaca czy numer telefonu ma 9 cyfr
CREATE DOMAIN  dom_numer_tel AS varchar CONSTRAINT nr_tel CHECK (CHARACTER_LENGTH(VALUE) = 9);
--domena sprawdzajaca czy numer PESEL ma 11 cyfr
CREATE DOMAIN  dom_numer_pesel AS varchar CONSTRAINT nr_pesel CHECK (CHARACTER_LENGTH(VALUE) = 11);



