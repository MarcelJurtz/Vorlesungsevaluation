SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Datenbank: `veva`
--


--
-- Daten für Tabelle `vorlesung`
--

INSERT INTO vorlesung (VoID, VoBezeichnung) VALUES (1, 'Logik und Algebra');




--
-- Daten für Tabelle `kapitel`
--

INSERT INTO kapitel (KaID, KaBezeichnung, VoID) VALUES
(1, 'Mengenlehre', 1),
(2, 'Relationen', 1),
(3, 'Relationenalgebra', 1),
(4, 'Abbildungen', 1),
(5, 'Boolesche Algebra', 1);


--
-- Daten für Tabelle `fragepool`
--

INSERT INTO fragepool (FpID, KaID) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);



--
-- Daten für Tabelle `frage`
--


-- Mengenlehre
INSERT INTO frage (FrID, FrBezeichnung, FrText, FpID, FrTyp) VALUES
(1, 'Mengenlehre - Vereinigung 1', 'Sei X={a,b} und Y={b,a}. Was ergibt die Vereinigung von X und Y (X ∪ Y)?', 1, 'mchoic'),
(2, 'Mengenlehre - Differenz 1', 'Sei X={a,b,c} und Y={b,a}. Was ergibt die Differenz von X und Y (X - Y)?', 1, 'mchoic'),
(3, 'Mengenlehre - Durchschnitt 1', 'Sei X={a,b,c,d} und Y={c,d,e,f}. Was ergibt der Durschschnitt von X und Y(X ∩ Y)?', 1, 'mchoic'),
(4, 'Mengenlehre - Durchschnitt 2', 'Sei X={a,b,c} und Y={d,e,f}. Was ergibt der Durschschnitt von X und Y(X ∩ Y)?', 1, 'mchoic'),
(5, 'Mengenlehre - Differenz 2', 'Sei X={a,b,c,d} und Y={c,d,e,f}. Was ergibt die symmetrische Differenz von X und Y (X ∆ Y)?', 1, 'mchoic'),
(6, 'Mengenlehre - Potenzmenge 1', 'Sei X={a,b}. Was ist die Potenzmenge von X?', 1, 'mchoic'),
(7, 'Mächtigkeit', 'Sei R={{1,2,{}},{3,4}}. Wie groß ist die Mächtigkeit von R (|R|)?', 1, 'text'),
(8, 'Mengenlehre - Definition', 'Was ist eine Menge?', 1, 'mchoic');

-- Relationen
INSERT INTO frage (FrID, FrBezeichnung, FrText, FpID, FrTyp) VALUES
(9, 'Eigenschaften von Relationen 1', 'Sei  M = {1, 2} und R = {(1, 2),(2, 1)}. Welche Eigenschaften erfüllt R?', 2, 'mchoic'),
(10, 'Eigenschaften von Relationen 2', 'Sei  M = {1, 2, 3} und R = {(1, 2),(1, 3),(2, 3)}. Welche Eigenschaften erfüllt R?', 2, 'mchoic'),
(11, 'Eigenschaften von Relationen 3', 'Sei  M = {1, 2, 3} und R = {(1, 1),(2, 2),(3, 3),(1, 2),(2, 3),(1, 3)}. Welche Eigenschaften erfüllt R?', 2, 'mchoic'),
(12, 'Reflexivität 1', 'Sei  M = {1, 2, 3} und R = {(1, 1),(1, 2),(2, 3),(3,3)}. Was ist die reflexive Hülle der Relation R auf der Menge M?', 2, 'text'),
(13, 'Symmetrie 1', 'Sei  M = {1, 2, 3} und R = {(1, 1),(1, 2),(2, 3),(3,3)}. Was ist die symmetrische Hülle der Relation R auf der Menge M?', 2, 'text'),
(14, 'Transitivität 1', 'Sei  M = {1, 2, 3} und R = {(1, 1),(1, 2),(2, 3),(3,3)}. Was ist die transitive Hülle der Relation R auf der Menge M?', 2, 'text'),
(15, 'Eigenschaften von Relationen 4', 'Finden Sie eine Relation R auf der Menge M = {1,2,3}, die reflexiv und transitiv ist aber nicht symmetrisch', 2, 'mchoic'),
(16, 'Eigenschaften von Relationen 5', 'Finden Sie eine Relation R auf der Menge M = {1,2,3}, die reflexiv ist aber nicht symmetrisch und transitiv', 2, 'mchoic'),
(17, 'Totale Ordnungen 1', 'Welche der folgenden Relationen sind totale Ordnungen?', 2, 'mchoic'),
(18, 'Totale Ordnungen 2', 'Welche der folgenden Relationen ist eine totale Ordnung auf die Menge M = {1, 2, 3}', 2, 'mchoic'),
(19, 'Zerlegungen 1', 'Sei R = {a, b, c, d, e, f}. Welches der folgenden Relationen Z ist eine Zerlegung von R?', 2, 'mchoic');

-- Relationenalgebra
INSERT INTO frage (FrID, FrBezeichnung, FrText, FpID, FrTyp) VALUES
(20, 'Relationenalgebra 1', 'Gegeben sei das folgende Schema zur Verwaltung von Fußballvereinen: (PK_... := Primärschlüssel; FK_... := Fremdschlüssel)<br/>\r\n<br/>\r\nVerein (PK_Vname, Ort, Präsident)<br/>\r\nSpiel (PK_FK_Heim, PK_FK_Gast, Resultat, Zuschauer, Termin, Spieltag, FK_Heim-TrNr, FK_Gast-TrNr)<br/>\r\nSpieler (PK_SpNr, Name, Vorname, FK_Verein, Alter, Gehalt, Geburtsort)<br/>\r\nTrainer (PK_TrNr, Name, Vorname, FK_Verein, Gehalt)<br/>\r\nEinsatz ( PK_FK_Heim, PK_FK_Gast, PK_FK_SpNr, von, bis, Tore, Karte)<br/>\r\n<br/>\r\nFormulieren Sie folgende Anfrage mithilfe der Relationenalgebra. Welche Vereine befinden sich in Kiel?<br/>', 3, 'text'),
(21, 'Relationenalgebra 2', 'Gegeben sei das folgende Schema zur Verwaltung von Fußballvereinen: (PK_... := Primärschlüssel; FK_... := Fremdschlüssel)<br/>\r\n<br/>\r\nVerein (PK_Vname, Ort, Präsident)<br/>\r\nSpiel (PK_FK_Heim, PK_FK_Gast, Resultat, Zuschauer, Termin, Spieltag, FK_Heim-TrNr, FK_Gast-TrNr)<br/>\r\nSpieler (PK_SpNr, Name, Vorname, FK_Verein, Alter, Gehalt, Geburtsort)<br/>\r\nTrainer (PK_TrNr, Name, Vorname, FK_Verein, Gehalt)<br/>\r\nEinsatz ( PK_FK_Heim, PK_FK_Gast, PK_FK_SpNr, von, bis, Tore, Karte)<br/>\r\n<br/>\r\nFormulieren Sie folgende Anfrage mithilfe der Relationenalgebra. Welche Spiele am 11. Spieltag hatten weniger als 50000 Zuschauer?', 3, 'text'),
(22, 'Relationenalgebra 3', 'Gegeben sei das folgende Schema zur Verwaltung von Fußballvereinen: (PK_... := Primärschlüssel; FK_... := Fremdschlüssel)<br/>\r\n<br/>\r\nVerein (PK_Vname, Ort, Präsident)<br/>\r\nSpiel (PK_FK_Heim, PK_FK_Gast, Resultat, Zuschauer, Termin, Spieltag, FK_Heim-TrNr, FK_Gast-TrNr)<br/>\r\nSpieler (PK_SpNr, Name, Vorname, FK_Verein, Alter, Gehalt, Geburtsort)<br/>\r\nTrainer (PK_TrNr, Name, Vorname, FK_Verein, Gehalt)<br/>\r\nEinsatz ( PK_FK_Heim, PK_FK_Gast, PK_FK_SpNr, von, bis, Tore, Karte)<br/>\r\n<br/>\r\nFormulieren Sie folgende Anfrage mithilfe der Relationenalgebra. Welche Spiele sind mit dem Resultat 2:1 ausgegangen?', 3, 'text'),
(23, 'Relationenalgebra 4', 'Gegeben sei das folgende Schema zur Verwaltung von Fußballvereinen: (PK_... := Primärschlüssel; FK_... := Fremdschlüssel)<br/>\r\n<br/>\r\nVerein (PK_Vname, Ort, Präsident)<br/>\r\nSpiel (PK_FK_Heim, PK_FK_Gast, Resultat, Zuschauer, Termin, Spieltag, FK_Heim-TrNr, FK_Gast-TrNr)<br/>\r\nSpieler (PK_SpNr, Name, Vorname, FK_Verein, Alter, Gehalt, Geburtsort)<br/>\r\nTrainer (PK_TrNr, Name, Vorname, FK_Verein, Gehalt)<br/>\r\nEinsatz ( PK_FK_Heim, PK_FK_Gast, PK_FK_SpNr, von, bis, Tore, Karte)<br/>\r\n<br/>\r\nFormulieren Sie folgende Anfrage mithilfe der Relationenalgebra. In welchen Vereinen spielen Spieler, deren Geburtsort gleich dem Vereinsort ist?', 3, 'text'),
(24, 'Relationenalgebra 5', 'Gegeben sei das folgende Schema zur Verwaltung von Fußballvereinen: (PK_... := Primärschlüssel; FK_... := Fremdschlüssel)<br/>\r\n<br/>\r\nVerein (PK_Vname, Ort, Präsident)<br/>\r\nSpiel (PK_FK_Heim, PK_FK_Gast, Resultat, Zuschauer, Termin, Spieltag, FK_Heim-TrNr, FK_Gast-TrNr)<br/>\r\nSpieler (PK_SpNr, Name, Vorname, FK_Verein, Alter, Gehalt, Geburtsort)<br/>\r\nTrainer (PK_TrNr, Name, Vorname, FK_Verein, Gehalt)<br/>\r\nEinsatz ( PK_FK_Heim, PK_FK_Gast, PK_FK_SpNr, von, bis, Tore, Karte)<br/>\r\n<br/>\r\nFormulieren Sie folgende Anfrage mithilfe der Relationenalgebra. Welche Spieler (Name, Vorname) haben noch nie gespielt?', 3, 'text'),
(25, 'Relationenalgebra 6', 'Gegeben sei das folgende Schema zur Verwaltung von Fußballvereinen: (PK_... := Primärschlüssel; FK_... := Fremdschlüssel)<br/>\r\n<br/>\r\nVerein (PK_Vname, Ort, Präsident)<br/>\r\nSpiel (PK_FK_Heim, PK_FK_Gast, Resultat, Zuschauer, Termin, Spieltag, FK_Heim-TrNr, FK_Gast-TrNr)<br/>\r\nSpieler (PK_SpNr, Name, Vorname, FK_Verein, Alter, Gehalt, Geburtsort)<br/>\r\nTrainer (PK_TrNr, Name, Vorname, FK_Verein, Gehalt)<br/>\r\nEinsatz ( PK_FK_Heim, PK_FK_Gast, PK_FK_SpNr, von, bis, Tore, Karte)<br/>\r\n<br/>\r\nFormulieren Sie folgende Anfrage mithilfe der Relationenalgebra. Welche Spieler (Name, Vorname) haben schon mindestenz eine Karte bekommen?', 3, 'text');

-- Abbildungen
INSERT INTO frage (FrID, FrBezeichnung, FrText, FpID, FrTyp) VALUES
(26, 'Linksvollständigkeit 1', 'Sei R ⊆ N X M. Wann ist R linksvollständig?', 4, 'mchoic'),
(27, 'Rechtseindeutigkeit 1', 'Sei R ⊆ N X M. Wann ist R rechtseindeutig?', 4, 'mchoic'),
(28, 'Injektivität 1', 'Gegeben ist die Funktion f definiert durch f: ℤ -> ℤ mit f(x) = 1 + x. Ist die Funktion injektiv?', 4, 'mchoic'),
(29, 'Surjektivität 1', 'Gegeben ist die Funktion f definiert durch f: ℤ -> ℤ mit f(x) = 1 + x. Ist die Funktion surjektiv?', 4, 'mchoic'),
(30, 'Surjektivität 2', 'Gegeben ist die Funktion f definiert durch f: ℕ -> ℤ mit f(x) = 1 + x. Ist die Funktion surjektiv?', 4, 'mchoic'),
(31, 'Surjektivität 3', 'Gegeben ist die Funktion f definiert durch f: R -> R mit f(x) = 1 + x*x. Ist die Funktion surjektiv?', 4, 'mchoic'),
(32, 'Injektivität 2', 'Gegeben ist die Funktion f definiert durch f: R -> R mit f(x) = 1 + x*x. Ist die Funktion injektiv?', 4, 'mchoic'),
(33, 'Injektivität 3', 'Sei f eine Abbildung von Matrikelnummer auf Schuhgröße. Ist f injektiv?', 4, 'mchoic'),
(34, 'Surjektivität 4', 'Sei f eine Abbildung von Matrikelnummer auf Schuhgröße. Ist f surjektiv?', 4, 'mchoic');

-- Boolesche Algebra
INSERT INTO frage (FrID, FrBezeichnung, FrText, FpID, FrTyp) VALUES
(35, 'Disjunktive Normalform 1', 'Nennen Sie die disjunktive Normalform von (a + b)*(c + d).', 5, 'text'),
(36, 'Konjunktive Normalform 1', 'Nennen Sie die konjunktive Normalform von a + b*c.', 5, 'text'),
(37, 'Implikation 1', 'Lösen Sie in dem Booleschen Ausdruck (a + b) -> ¬(a + b) die Implikation auf.', 5, 'text'),
(38, 'Äquivalenz 1', 'Welcher Ausdruck ist äquivalent zu a*(¬(a*b))', 5, 'mchoic');





--
-- Daten für Tabelle `antwort`
--

-- Mengenlehre
INSERT INTO antwort (FrID, AwText, AwWahrheit, AwID) VALUES
(1, '{a,b}', 1, 0),
(1, '{}', 0, 1),
(1, '{a,b,b,a}', 0, 2),
(1, '{{a,b},{b,a}}', 0, 3),
(2, '{a,b}', 0, 0),
(2, '{c}', 1, 1),
(2, '{a,b,c}', 0, 2),
(2, '{}', 0, 3),
(3, '{a,b,e,f}', 0, 0),
(3, '{c,d}', 1, 1),
(3, '{e,f}', 0, 2),
(3, '{}', 0, 3),
(4, '{a,b,c,d,e,f}', 0, 0),
(4, '{c,d}', 0, 1),
(4, '{a,b,c}', 0, 2),
(4, '{}', 1, 3),
(5, '{a,b,e,f}', 1, 0),
(5, '{c,d}', 0, 1),
(5, '{e,f}', 0, 2),
(5, '{}', 0, 3),
(6, '{{a}, {b}, {a,b}}', 0, 0),
(6, '{{a}, {b}, {a,b}, {}}', 1, 1),
(6, '{a,b,{a,b},{}}', 0, 2),
(6, '2', 0, 3),
(7, '2', 0, 0),
(8, 'Menge an Studenten in der Vorlesung Logik und Algebra vom Jahrgang 2014', 1, 0),
(8, 'Menge der Torschützen bei einem Fußballspiel', 0, 1),
(8, 'Menge aller Natürlichen Zahlen', 1, 2),
(8, 'Menge der getrunkenen Maßkrüge beim Rutenfest', 0, 3);


-- Relationen
INSERT INTO antwort (FrID, AwText, AwWahrheit, AwID) VALUES
(9, 'reflexiv', 0, 0),
(9, 'symmetrisch', 1, 1),
(9, 'antisymmetrisch', 0, 2),
(9, 'asymetrisch', 0, 3),
(9, 'transitiv', 0, 4),
(10, 'reflexiv', 0, 0),
(10, 'symmetrisch', 0, 1),
(10, 'antisymmetrisch', 0, 2),
(10, 'asymetrisch', 0, 3),
(10, 'transitiv', 1, 4),
(11, 'reflexiv', 1, 0),
(11, 'symmetrisch', 0, 1),
(11, 'antisymmetrisch', 0, 2),
(11, 'asymetrisch', 0, 3),
(11, 'transitiv', 1, 4),
(12, '{(1, 1),(2, 2),(3, 3),(1, 2),(2, 3)}', 0, 0),
(13, '{(1, 1),(1, 2),(2, 1),(2, 3),(3, 2),(3, 3)}', 0, 0),
(14, '{(1, 1),(1, 2),(2, 3),(1, 3),(3, 3)}', 0, 0),
(15, 'R = {(1, 1),(2, 2),(3, 3),(1, 2),(2, 3),(1, 3)}', 1, 0),
(15, 'R = {(1, 1),(2, 2),(3, 3),(1, 2),(2, 3)}', 0, 1),
(15, 'R = {(1, 1),(2, 2),(3, 3)}', 0, 2),
(15, 'R = {(1, 2),(2, 3),(1, 3)}', 0, 3),
(16, 'R = {(1, 1),(2, 2),(3, 3),(1, 2),(2, 3),(1, 3)}', 0, 0),
(16, 'R = {(1, 1),(2, 2),(3, 3),(1, 2),(2, 3)}', 0, 1),
(16, 'R = {(1, 1),(2, 2),(3, 3)}', 0, 2),
(16, 'R = {(1, 1),(2, 2),(3, 3),(1, 2),(2, 3)}', 1, 3),
(17, '≤N auf N', 1, 0),
(17, '<N auf N', 0, 1),
(17, '≥Z auf Z', 1, 2),
(17, 'σ auf N', 0, 3),
(17, 'N × N auf N', 0, 4),
(18, 'R = {(1, 1),(2, 2),(3, 3),(1, 2),(3, 1),(3, 2),(1, 3)}', 0, 0),
(18, 'R = {(1, 1),(2, 2),(3, 3),(1, 2),(3, 1),(3, 2)}', 1, 1),
(18, 'R = {(1, 1),(2, 2),(3, 3),(1, 2),(3, 1)}', 0, 2),
(18, 'R = {(1, 1),(2, 2),(3, 3),(1, 2)}', 0, 3),
(18, 'R = {(1, 1),(2, 2),(3, 3)}', 0, 4),
(19, 'Z = {{a, c}, {e}, {f, d, b}}', 1, 0),
(19, 'Z = {{a, b, c}, {e}, {f, d, b}}', 0, 1),
(19, 'Z = {{a, c, e}, {f}, {d}}', 0, 2);

-- Relationenalgebra
INSERT INTO antwort (FrID, AwText, AwWahrheit, AwID) VALUES
(20, 'π PK_Vname(ϭ Ort= ''Kiel'' (Verein))', 0, 0),
(21, 'π PK_FK_Heim, PK_FK_Gast( ϭ Spieltag = 11 ∧ Zuschauer < 50000 (Spiel))', 0, 0),
(22, 'π PK_FK_Heim, PK_FK_Gast( ϭ Resultat = 2:1 (Spiel))', 0, 0),
(23, 'π PK_Vname(ϭ V.Ort= S.Geb-Ort (ρV(Verein)  ⋈ ρS(Spieler) ))', 0, 0),
(24, 'π PK_SpNr(π PK_SpNr(Spieler) - π PK_SpNr((Einsatz)  ⋈ (Spieler)))', 0, 0),
(25, 'π Name, Vorname (ϭ E.Karte > 0 (ρE(Einsatz)  ⋈ ρS(Spieler)))', 0, 0);

-- Abbildungen
INSERT INTO antwort (FrID, AwText, AwWahrheit, AwID) VALUES
(26, 'Wenn jedes Element von M in mindestens einem Paar in R vorkommt', 0, 0),
(26, 'Wenn jedes Element von N in mindestens einem Paar in R vorkommt', 1, 1),
(26, 'Kein Paar ein gleiches Element von N enthält', 0, 2),
(26, 'Kein Paar ein gleiches Element von M enthält', 0, 3),
(27, 'Wenn jedes Element von M in mindestens einem Paar in R vorkommt', 0, 0),
(27, 'Wenn jedes Element von N in mindestens einem Paar in R vorkommt', 0, 1),
(27, 'Kein Paar ein gleiches Element von N enthält', 1, 2),
(27, 'Kein Paar ein gleiches Element von M enthält', 0, 3),
(28, 'Ja', 1, 0),
(28, 'Nein', 0, 1),
(29, 'Ja', 1, 0),
(29, 'Nein', 0, 1),
(30, 'Ja', 0, 0),
(30, 'Nein', 1, 1),
(31, 'Ja', 1, 0),
(31, 'Nein', 0, 1),
(32, 'Ja', 0, 0),
(32, 'Nein', 1, 1),
(33, 'Ja', 0, 0),
(33, 'Nein', 1, 1),
(34, 'Ja', 0, 0),
(35, 'Nein', 1, 1);

-- Boolesche Algebra
INSERT INTO antwort (FrID, AwText, AwWahrheit, AwID) VALUES
(35, 'a*c + a *d + b*c + b*d', 0, 0),
(36, '(¬a + b)*(¬a + ¬ c)', 0, 0),
(37, '¬(a + b) + ¬(a*b)', 0, 0),
(38, 'b', 0, 0),
(38, '¬b', 0, 1),
(38, 'a*b', 0, 2),
(38, '¬a*b', 0, 3),
(38, 'a*¬b', 1, 4);


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
