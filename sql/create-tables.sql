CREATE TABLE Kayttaja
(
kayttajaId INTEGER NOT NULL AUTO_INCREMENT,
etunimi varchar(80) NOT NULL,
sukunimi varchar(80) NOT NULL,
sahkoposti varchar(80) NOT NULL,
puhelin varchar(15),
osoite varchar(80),
postinumero varchar(5),
paikkakunta varchar(30),
salasana varchar(120) NOT NULL,
kayttajaTyyppi varchar(15) NOT NULL,
PRIMARY KEY (kayttajaId)
);

CREATE TABLE Tuoteryhma
(
tuoteryhmaId INTEGER NOT NULL AUTO_INCREMENT,
nimi varchar(50) NOT NULL,
PRIMARY KEY (tuoteryhmaId)
);

CREATE TABLE Tuote
(
tuoteId INTEGER NOT NULL AUTO_INCREMENT,
tuoteryhmaId INTEGER,
nimi varchar(80) NOT NULL,
hinta DECIMAL(10,2) NOT NULL,
kuvaus varchar(3000),
PRIMARY KEY (tuoteId),
FOREIGN KEY (tuoteryhmaId) REFERENCES Tuoteryhma(tuoteryhmaId)
);

CREATE TABLE Tilaus
(
tilausId INTEGER NOT NULL AUTO_INCREMENT,
kayttajaId INTEGER,
tilausvaihe varchar(50),
tilauspaiva timestamp,
toimituspaiva date,
toimitustapa varchar(20),
maksutapa varchar(20),
PRIMARY KEY (tilausId),
FOREIGN KEY (kayttajaId) REFERENCES Kayttaja(kayttajaId)
);

CREATE TABLE TilausTuote
(
maara INTEGER NOT NULL,
tilausId INTEGER NOT NULL,
tuoteId INTEGER NOT NULL,
FOREIGN KEY (tilausId) REFERENCES Tilaus(tilausId),
FOREIGN KEY (tuoteId) REFERENCES Tuote(tuoteId)
);



