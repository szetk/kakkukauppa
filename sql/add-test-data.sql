INSERT INTO Kayttaja (sahkoposti, salasana, etunimi, sukunimi, puhelin, osoite, postinumero, posti, kayttajaTyyppi) VALUES ('sami.korhonen@helsinki.fi', '32b24a689b835ffb835dd14ef048a93b9c9d6a95f2410f67ae0e72fc9d9c2664ddef8d47d11755cd8be4124ce4fda8d82951e9c835f5a10e33566a2ee7f85466', 'Sami', 'Korhonen', '+358666', 'Kaivotie 23B 3', '03412', 'Paikka', 'admin');
INSERT INTO Kayttaja (sahkoposti, salasana, etunimi, sukunimi, puhelin, osoite, postinumero, posti, kayttajaTyyppi) VALUES ('kopponen@kakku.fi', '32b24a689b835ffb835dd14ef048a93b9c9d6a95f2410f67ae0e72fc9d9c2664ddef8d47d11755cd8be4124ce4fda8d82951e9c835f5a10e33566a2ee7f85466', 'Minttu', 'Kopponen', '040666', 'Vaasankatu 17', '00600', 'Helsinki', 'asiakas');
INSERT INTO Tuoteryhma (nimi) VALUES ('Hääkakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Erikoiskakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Voileipäkakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Perinteiset täytekakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Kuivakakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Muut tuotteet');
INSERT INTO Tuote (nimi, hinta, tuoteryhmaId, kuvaus, kuva) VALUES ('kakku', '123.32', '0', 'Geneerinen kakku', 'kakku.png');
INSERT INTO Tuote (nimi, hinta, tuoteryhmaId, kuvaus) VALUES ('Mansikkakakku', '32','1', 'Ei sisällä pähkinää tä anjovista');
INSERT INTO Tuote (nimi, hinta, tuoteryhmaId, kuvaus) VALUES ('Autokakku', '23','2', 'Autossa on neljä rengasta. Auto on punainen. Auto on Jaguaari.');
INSERT INTO Tuote (nimi, hinta, tuoteryhmaId, kuvaus) VALUES ('Mutakakku', '24.90','3', 'Semitavallinen mutakakku, vähän toffeeta silleen kivasti');
-- INSERT INTO Tilaus (kayttajaId, toimituspaiva, tilauspaiva, toimitustapa) VALUES (1, '2014-04-24', '2014-04-21');
-- tuotteita paljon, tuoteryhmineen
-- käyttäjiä
-- tilauksia