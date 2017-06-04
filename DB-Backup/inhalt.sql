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
(2, 'Relationen', 1);;


--
-- Daten für Tabelle `fragepool`
--

INSERT INTO fragepool (FpID, KaID) VALUES
(1, 1),
(2, 2);



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


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
