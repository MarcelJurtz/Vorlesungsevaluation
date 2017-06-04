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

INSERT INTO kapitel (KaID, KaBezeichnung, VoID) VALUES (1, 'Mengenlehre', 1);



--
-- Daten für Tabelle `fragepool`
--

INSERT INTO fragepool (FpID, KaID) VALUES (1, 1);



--
-- Daten für Tabelle `frage`
--



INSERT INTO frage (FrID, FrBezeichnung, FrText, FpID, FrTyp) VALUES
(1, 'Mengenlehre - Vereinigung 1', 'Sei X={a,b} und Y={b,a}. Was ergibt die Vereinigung von X und Y (X ∪ Y)?', 1, 'mchoic'),
(2, 'Mengenlehre - Differenz 1', 'Sei X={a,b,c} und Y={b,a}. Was ergibt die Differenz von X und Y (X - Y)?', 1, 'mchoic'),
(3, 'Mengenlehre - Durchschnitt 1', 'Sei X={a,b,c,d} und Y={c,d,e,f}. Was ergibt der Durschschnitt von X und Y(X ∩ Y)?', 1, 'mchoic'),
(4, 'Mengenlehre - Durchschnitt 2', 'Sei X={a,b,c} und Y={d,e,f}. Was ergibt der Durschschnitt von X und Y(X ∩ Y)?', 1, 'mchoic'),
(5, 'Mengenlehre - Differenz 2', 'Sei X={a,b,c,d} und Y={c,d,e,f}. Was ergibt die symmetrische Differenz von X und Y (X ∆ Y)?', 1, 'mchoic'),
(6, 'Mengenlehre - Potenzmenge 1', 'Sei X={a,b}. Was ist die Potenzmenge von X?', 1, 'mchoic'),
(7, 'Mächtigkeit', 'Sei R={{1,2,{}},{3,4}}. Wie groß ist die Mächtigkeit von R (|R|)?', 1, 'text'),
(8, 'Mengenlehre - Definition', 'Was ist eine Menge?', 1, 'mchoic');



--
-- Daten für Tabelle `antwort`
--

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



COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
