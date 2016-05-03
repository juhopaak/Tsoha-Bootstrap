CREATE TABLE Kayttaja(
	tunnus SERIAL PRIMARY KEY,
	kayttajatunnus varchar(120) NOT NULL,
	salasana varchar(20) NOT NULL,
	yhteystiedot varchar(250) NOT NULL,
	tyyppi INTEGER NOT NULL
);

CREATE TABLE Tuote (
	tunnus SERIAL PRIMARY KEY,
	nimi varchar(120) NOT NULL,
	ika INTEGER,
	sijainti varchar(120),
	lahtohinta decimal,
	sulkeutuminen date,
	tila boolean NOT NULL,
	kuvaus varchar(250) NOT NULL,
	tuotekuva varchar(120),
	meklari INTEGER REFERENCES Kayttaja(tunnus)
);

CREATE TABLE Tuoteluokka (
	tunnus SERIAL PRIMARY KEY,
	nimike varchar(120) NOT NULL,
	kuvaus varchar(350)
);

CREATE TABLE TuotteenLuokat (
	tuote INTEGER REFERENCES Tuote(tunnus),
	tuoteluokka INTEGER REFERENCES Tuoteluokka(tunnus)
);

CREATE TABLE Tarjous (
	tunnus SERIAL PRIMARY KEY,
	aika timestamp NOT NULL,
	maara decimal NOT NULL,
	yhteystiedot varchar(200) NOT NULL,
	tuote INTEGER REFERENCES Tuote(tunnus)
);