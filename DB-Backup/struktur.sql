SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



CREATE TABLE administrator (
  AName varchar(25) NOT NULL PRIMARY KEY,
  AKennwort char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Default Values: PW "DHBW"
-- Change this under 'Einstellungen'
INSERT INTO administrator(AName, AKennwort) VALUES
('root', 'ef764729df8c93a3b6648e229434c2ce');



CREATE TABLE vorlesung (
  VoID smallint(6) AUTO_INCREMENT PRIMARY KEY,
  VoBezeichnung varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE kapitel (
  KaID smallint(6) AUTO_INCREMENT PRIMARY KEY,
  KaBezeichnung varchar(100) DEFAULT NULL,
  VoID smallint(6),
  FOREIGN KEY(VoID) REFERENCES vorlesung(VoID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE kapitel ADD KEY `VoID` (VoID);



CREATE TABLE fragepool (
  FpID smallint(6) AUTO_INCREMENT PRIMARY KEY,
  KaID smallint(6),
  FOREIGN KEY (KaID) REFERENCES kapitel(KaID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE fragepool ADD KEY `KaID` (KaID);



CREATE TABLE frage (
  FrID int(11) NOT NULL AUTO_INCREMENT,
  FrBezeichnung varchar(50) UNIQUE NOT NULL,
  FrText varchar(1000) DEFAULT NULL,
  FpID smallint(6),
  FrTyp char(6) DEFAULT NULL,
  PRIMARY KEY(FrID,FpID),
  FOREIGN KEY (FpID) REFERENCES fragepool(FpID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE frage ADD KEY `FpID` (FpID);



CREATE TABLE antwort (
  FrID int(11),
  AwText varchar(500) DEFAULT NULL,
  AwWahrheit tinyint(1) unsigned DEFAULT NULL,
  AwID tinyint(4) unsigned NOT NULL,
  PRIMARY KEY(FrID,AwID),
  FOREIGN KEY(FrID) REFERENCES Frage(FrID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE antwort ADD KEY `FrID` (FrID), ADD KEY `AwID` (AwID);



CREATE TABLE kurs (
  KuID char(5) PRIMARY KEY,
  KuBezeichnung varchar(100) DEFAULT NULL,
  KuFreigeschaltet tinyint(4) unsigned DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE student (
  StName varchar(25) PRIMARY KEY,
  KuBezeichnung char(5),
  FOREIGN KEY(KuBezeichnung) REFERENCES kurs(KuID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE student ADD KEY `KuBezeichnung` (KuBezeichnung), ADD KEY `StName` (StName);



CREATE TABLE fragebogen (
  FbId mediumint(9) AUTO_INCREMENT PRIMARY KEY,
  FbBezeichnung varchar(100) NOT NULL UNIQUE,
  KaID smallint(6),
  FOREIGN KEY(KaID) REFERENCES kapitel(KaID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE fragebogen ADD KEY `KaID` (KaID);



CREATE TABLE fbabgabe (
  StName varchar(25),
  FbID mediumint(9),
  PRIMARY KEY(StName, FbID),
  FOREIGN KEY(StName) REFERENCES student(StName),
  FOREIGN KEY(FbID) REFERENCES fragebogen(FbId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE fbabgabe ADD KEY `FbID` (FbID);



CREATE TABLE fbfreigabe (
  KuID char(5),
  FbID mediumint(9),
  PRIMARY KEY(KuID,FbID),
  FOREIGN KEY(FbID) REFERENCES fragebogen(FbId),
  FOREIGN KEY(KuID) REFERENCES kurs(KuID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE fbfreigabe ADD KEY `FbID` (FbID);



CREATE TABLE beantwortet (
  StName varchar(25),
  FrID int(11),
  AwID tinyint(4) unsigned,
  StAntwort varchar(500) DEFAULT NULL,
  FbID mediumint(9),
  PRIMARY KEY(StName,FrID,AwID,FbID),
  FOREIGN KEY(FrID) REFERENCES frage(FrID),
  FOREIGN KEY(AwID) REFERENCES antwort(AwID),
  FOREIGN KEY(StName) REFERENCES student(StName),
  FOREIGN KEY(FbID) REFERENCES fragebogen(FbId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 ALTER TABLE beantwortet ADD KEY FrID (FrID), ADD KEY `AwID` (AwID);

 CREATE TABLE frageinfragebogen (
   fbID mediumint(9),
   frBezeichnung varchar(50),
   PRIMARY KEY(fbID, frBezeichnung),
   FOREIGN KEY(fbID) REFERENCES fragebogen(FbId),
   FOREIGN KEY(frBezeichnung) REFERENCES frage(FrBezeichnung)

 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 ALTER TABLE frageinfragebogen
   ADD KEY `frBezeichnung` (frBezeichnung);
