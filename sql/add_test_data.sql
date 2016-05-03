INSERT INTO Kayttaja (kayttajatunnus, salasana, yhteystiedot, tyyppi) VALUES ('testikäyttäjä', 'testi', 'asiakas@kayttaja.fi', 1);
INSERT INTO Kayttaja (kayttajatunnus, salasana, yhteystiedot, tyyppi) VALUES ('Mikko Meklari', 'meklari', 'mikko@meklari.fi', 2);
INSERT INTO Tuote (nimi, ika, sijainti, lahtohinta, sulkeutuminen, tila, kuvaus, meklari) VALUES ('Iphone', 2, 'Helsinki', 100, '2016-04-04', 'true', 'Loistava puhelin halvalla!', 2);
INSERT INTO Tuoteluokka (nimike, kuvaus) VALUES ('Puhelimet', 'Lähinnä älypuhelimia nykyään.');
INSERT INTO TuotteenLuokat (tuote, tuoteluokka) VALUES (1, 1);
INSERT INTO Tarjous (aika, maara, yhteystiedot, tuote) VALUES (TIMESTAMP '2016-04-04 16:21:00', 102.20, 'tarjoaja@asiakas.fi', 1);