INSERT INTO Kayttaja (sahkoposti, salasana, etunimi, sukunimi, puhelin, osoite, postinumero, posti, kayttajaTyyppi) VALUES ('sami.korhonen@helsinki.fi', '32b24a689b835ffb835dd14ef048a93b9c9d6a95f2410f67ae0e72fc9d9c2664ddef8d47d11755cd8be4124ce4fda8d82951e9c835f5a10e33566a2ee7f85466', 'Sami', 'Korhonen', '+358666', 'Kaivotie 23B 3', '03412', 'Paikka', 'admin');
INSERT INTO Kayttaja (sahkoposti, salasana, etunimi, sukunimi, puhelin, osoite, postinumero, posti, kayttajaTyyppi) VALUES ('admin@kakku.fi', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'Adiktiivinen', 'Miniä', '040666', 'Vaasankatu 15', '00600', 'Helsinki', 'admin');
INSERT INTO Kayttaja (sahkoposti, salasana, etunimi, sukunimi, puhelin, osoite, postinumero, posti, kayttajaTyyppi) VALUES ('jobbari@kakku.fi', '75d1a770db2876c27fe8ef5e9bb9ca8f6243f1ba63efc793058d087e86a9b7533172117a35a20221c6c8232ab2ec82e098f52aa623f8a2e977c3a999c239da86', 'Jobbari', 'Jobimies', '040661', 'Vaasankatu 17', '00600', 'Helsinki', 'tyontekija');
INSERT INTO Kayttaja (sahkoposti, salasana, etunimi, sukunimi, puhelin, osoite, postinumero, posti, kayttajaTyyppi) VALUES ('asiakas@kakku.fi', '8cce0a118f59e6f3f4c768a48863c37196b61f5205cccde9eb6daf1931d9ef45a666626a413852148a6a6da1401166b94577721e602027e6d8674b679f862b5f', 'Asiakas', 'Kasperi', '040626', 'Vaasankatu 19', '00600', 'Helsinki', 'asiakas');
INSERT INTO Tuoteryhma (nimi) VALUES ('Hääkakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Erikoiskakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Voileipäkakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Perinteiset täytekakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Kuivakakut');
INSERT INTO Tuoteryhma (nimi) VALUES ('Muut tuotteet');
INSERT INTO Tuote (nimi, hinta, tuoteryhmaId, kuvaus, kuva) VALUES ('kakku', '123.32', '4', 'Geneerinen kakku', 'kakku.png');
INSERT INTO Tuote (nimi, hinta, tuoteryhmaId, kuvaus) VALUES ('Mansikkakakku', '32','1', 'Ei sisällä pähkinää tä anjovista');
INSERT INTO Tuote (nimi, hinta, tuoteryhmaId, kuvaus) VALUES ('Autokakku', '23','2', 'Autossa on neljä rengasta. Auto on punainen. Auto on Jaguaari.');
INSERT INTO Tuote (nimi, hinta, tuoteryhmaId, kuvaus) VALUES ('Mutakakku', '24.90','3', 'Semitavallinen mutakakku, vähän toffeeta silleen kivasti');
INSERT INTO Tuote (nimi, hinta, tuoteryhmaId, kuvaus) VALUES ('Pitkä kakku', '47.90','3', 'Kokeillaanpas tehdä vähän pidempi kuvaus ja katotaan, että miten mun softa handlaa sellaisen. Olis tarkotus saada näkymään koko teksti tuote sivulla, ja kaikissa listaussivuilla vaan semmonen järkevän kokonen pala tätä kuvausta, jotta kaikki muoto ei täysin rikkoonnu. Tästä kakusta nyt ei sen kummempaa ole sanottavaksi, paitsi että hyvä on!');
INSERT INTO Tilaus (kayttajaId, toimituspaiva, tilauspaiva, tilausvaihe) VALUES ('1', '2014-04-24', '2014-04-21', 'avoin');
INSERT INTO TilausTuote (tilausId, tuoteId, maara) VALUES ('1', '1', '1');
INSERT INTO TilausTuote (tilausId, tuoteId, maara) VALUES ('1', '3', '3');
