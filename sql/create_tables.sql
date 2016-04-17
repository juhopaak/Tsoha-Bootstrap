CREATE TABLE Esite (
	tunnus SERIAL PRIMARY KEY,
	luomisaika timestamp NOT NULL
);

CREATE TABLE Meklari(
	tunnus SERIAL PRIMARY KEY,
	nimi varchar(120) NOT NULL,
	osoite varchar(200),
	puhelin varchar(20),
	sahkoposti varchar(30) NOT NULL
);

CREATE TABLE Asiakas(
	tunnus SERIAL PRIMARY KEY,
	nimi varchar(120) NOT NULL,
	henkilotunnus varchar(20) NOT NULL,
	osoite varchar(200),
	puhelin varchar(20),
	sahkoposti varchar(30) NOT NULL
);

CREATE TABLE Kauppa (
	tunnus SERIAL PRIMARY KEY,
	lahtohinta decimal,
	alkaminen timestamp,
	sulkeutuminen timestamp,
	tila boolean,
	esite INTEGER REFERENCES Esite(tunnus),
	meklari INTEGER REFERENCES Meklari(tunnus)
);

CREATE TABLE Tuote (
	tunnus SERIAL PRIMARY KEY,
	nimi varchar(120) NOT NULL,
	ika INTEGER,
	sijainti varchar(120),
	kuvaus varchar(250) NOT NULL,
	tuotekuva varchar(120),
	kauppa INTEGER REFERENCES Kauppa(tunnus)
);

CREATE TABLE Tuoteluokka (
	tunnus SERIAL PRIMARY KEY,
	nimi varchar(120) NOT NULL,
	kuvaus varchar(350)
);

CREATE TABLE TuotteenLuokat (
	tuote INTEGER REFERENCES Tuote(tunnus),
	tuoteluokka INTEGER REFERENCES Tuoteluokka(tunnus)
);

CREATE TABLE Seurantalista (
	luomisaika timestamp NOT NULL,
	kauppa INTEGER REFERENCES Kauppa(tunnus)
);

CREATE TABLE Tarjous (
	tunnus SERIAL PRIMARY KEY,
	aika timestamp NOT NULL,
	maara decimal NOT NULL,
	kauppa INTEGER REFERENCES Kauppa(tunnus),
	asiakas INTEGER REFERENCES Asiakas(tunnus)
);

CREATE TABLE Lasku (
	maksutili varchar(30) NOT NULL,
	viitenumero varchar(30) NOT NULL,
	lahetysaika timestamp NOT NULL,
	erapaiva timestamp NOT NULL,
	tarjous INTEGER REFERENCES Tarjous(tunnus)
);

CREATE TABLE Kayttaja(
	tunnus SERIAL PRIMARY KEY,
	kayttajatunnus varchar(120) NOT NULL,
	salasana varchar(20) NOT NULL
);