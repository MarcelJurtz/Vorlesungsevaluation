# Kurzanleitung Vorlesungsevaluation

Dieses Dokument liefert eine Vorabbeschreibung der Webanwendung zur Vorlesungsevaluation.

**Hinweis**

Bitte beachten Sie, dass die aktuelle Version nicht dem finalen Stand entspricht.  
Die Administrator-Funktionalitäten sind zwar weitestgehend abgedeckt,
jedoch werden vor allem an der Struktur der PHP-Dateien noch Änderungen vorgenommen,
um die Wartung besser zu gestalten und die allgemeine Übersichtlichkeit zu verbessern.

Zusätzlich wurde die gestalterische Tätigkeit durch ein weiteres Teammitglied realisiert und bisher noch nicht übernommen.

## Installation

Folgende Services werden benötigt:
* Apache
* PHP
* MySQL
* PhpMyAdmin

Zu Testzwecken kann diese Vorgehensweise gut mit XAMPP erledigt werden.  
https://www.apachefriends.org/de/index.html


Öffnen Sie zuerst die Weboberfläche von PhpMyAdmin. Importieren Sie die die Datenbank
durch die Datei TODO.sql.
Sobald der Import ohne Fehler abgeschlossen wurde, kann das Programm verwendet werden.

Es wurde ein Standard-Administrator angelegt, welcher das Kennwort *DHBW* besitzt.
Sie können dies später per Menüpunkt *Passwort ändern* anpassen.

Kopieren Sie den Inhalt des Ordners *TODO* in das Web-Verzeichnis des Apache-Servers.
Bei XAMPP ist dies */htdocs*.

Sobald der Inhalt übertragen wurde, ist die Administrationsseite unter ````localhost:port/admin```
und die Anwenderseite über ```localhost:port/student``` erreichbar. Bei Verwendung von lediglich ```localhost:port```
werden Sie auf die Studentenseite weitergeleitet.

## Entwicklernotizen

Dieser Abschnitt beschreibt die Verteilung der Dateien, um Anpassungen zu erleichtern.

Ordner:
* ```admin```: Enthält alle Seiten des Administrationsbereichs (Funktionen sind ausgelagert)
* ```student```: Enthält alle Seiten des Anwenderbereichs (Funktionen sind ausgelagert)

Dateien im Hauptverzeichnis:
* ```constants.inc.php``` Enthält Konstanten-Definitionen, u.a. zur Tabellenbeschreibung
* ```functions.inc.php``` Enthält grundlegende Funktionalitäten, DB-Verbindung, Logout, Verlinkung auf die anderen Includes
* ```functions-chapter.inc.php``` Enthält Funktionalitäten zur Verwaltung von Kapiteln (einer Vorlesung)
* ```functions-lecture.inc.php``` Enthält Funktionalitäten zur Verwaltung von Kursen
* ```functions-question.inc.php``` Enthält Funktionalitäten zur Verwaltung von Vorlesungen
* ```functions-student.inc.php``` Enthält Funktionalitäten zur Verwaltung von Fragen
* ```functions-student.inc.php``` Enthält Funktionalitäten zur Verwaltung von Studenten
* ```global.css``` Enthält allgemeine Stylesheets (noch zu implementieren)
* ```index.php``` Startseite, leitet auf Studenten-Login weiter
* ```logout.php``` Logout-Seite, kann sowohl für Studenten, als auch Administratoren verwendet werden

Allgemein baut sich die Struktur folgendermaßen auf: Die Seiten in den Ordnern 'admin' und 'student' stellen die Teilfunktionen dar, welche über die Menüstruktur erreichbar sind. Die Funktionalität der Seiten, beispielsweise das Anlegen eines neuen Kurses gestaltet sich in der Form, dass der Administrator die gewünschten Daten eingibt, und das HTML-Formular auf die aktuelle Seite referenziert.
Auf der Seite selbst wird der Stand überprüft und entsprechende Steuerelemente ausgegeben.
Die eigentlichen Funktionen jedoch sind jeweils in den entsprechenden Dateien ausgelagert.
