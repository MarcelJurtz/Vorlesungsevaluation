# Kurzanleitung Vorlesungsevaluation

Dieses Dokument liefert eine Vorabbeschreibung der Webanwendung zur Vorlesungsevaluation.

**Hinweis**

Bitte beachten Sie, dass die aktuelle Version nicht dem finalen Stand entspricht.  
Die Administrator-Funktionalitäten sind zwar weitestgehend abgedeckt,
jedoch werden vor allem an der Struktur der PHP-Dateien noch Änderungen vorgenommen,
um die Wartung besser zu gestalten und die allgemeine Übersichtlichkeit zu verbessern.

Zusätzlich wurde die gestalterische Tätigkeit durch ein weiteres Teammitglied realisiert und bisher noch nicht übernommen.

Diese Dokumentation stellt eine kurze Zusammenfassung der Installation sowie der Anwendung dar und
entspricht ebenfalls nicht dem finalen Stand.

## Installation

Folgende Services werden benötigt:
* Apache
* PHP
* MySQL
* PhpMyAdmin

Zu Testzwecken kann diese Vorgehensweise gut mit XAMPP erledigt werden.  
https://www.apachefriends.org/de/index.html


Öffnen Sie zuerst die Weboberfläche von PhpMyAdmin. Importieren Sie die die Datenbank
durch die Datei *DB-BACKUP/import.sql*.
Sobald der Import ohne Fehler abgeschlossen wurde, kann das Programm verwendet werden.  
Bitte passen Sie hierzu die Datenbank-Konfiguration in der Datei *functions.inc.php* an (Zeile 44).

Es wurde ein Standard-Administrator angelegt, welcher das Kennwort *DHBW* besitzt.
Sie können dies später per Menüpunkt *Einstellungen* anpassen.

Kopieren Sie den Inhalt des Ordners in das Web-Verzeichnis des Apache-Servers.
Bei XAMPP ist dies */htdocs*.

Sobald der Inhalt übertragen wurde, ist die Administrationsseite unter ````localhost:port/admin```
und die Anwenderseite über ```localhost:port/student``` erreichbar. Bei Verwendung von lediglich ```localhost:port```
werden Sie auf die Studentenseite weitergeleitet.


## Anwendung

Nach erfolgreicher Anmeldung erhalten Sie eine Menüansicht mit den verschiedenen Funktionalitäten. Im Folgenden werden diese kurz Beschrieben:

* ```Übersicht```
  * Startseite / Landing-Page
* ```Kurse```
  * Anlegen und Löschen von Kursen.
  * das Kürzel entspricht der Kurzschreibweise in Form von fünf Zeichen, beispielsweise ```WI214```.
  * Unter *Kursfreigabe verwalten* können Kurse zur Registrierung freigeschaltet werden, Studenten können sich nur für Kurse registrieren, die freigeschaltet sind.
* ```Fragen```
  * Anlegen und Löschen von Fragen (Bearbeitungsfunktion wird noch implementiert).
  * Auswahl von Vorlesung und Kapitel, anschließend Anlegen einer Frage. Auswahlmöglichkeit zwischen Textfrage (mit Musterlösung) sowie Multiple-Choice-Fragen mit beliebig vielen (korrekten) Antworten.
* ```Fragebögen```
  * Zu jedem Kapitel können mehrere Fragebögen erstellt werden. Diese werden anschließend von den Studenten bearbeitet.
  * Momentan noch nicht implementiert.
* ```Vorlesungen```
  * Anlegen und Löschen von Vorlesungen.
  * Unter *Vorlesung bearbeiten* können Kapitel hinzugefügt, sowie Vorlesungen umbenannt werden.
* ```Statistiken```
  * Übersicht über die Beantwortung der Fragebögen durch die Studenten.
  * Momentan noch nicht implementiert.
* ```Einstellungen```
  * Administrations-Konfiguration, enthält bisher lediglich die Passwort-Änderung des Administrators.
* ```Abmelden```
  * Logout und Leiten auf die Startseite (Student).

## Entwicklernotizen

Dieser Abschnitt beschreibt die Verteilung der Dateien, um Anpassungen zu erleichtern.

Ordner:
* ```admin```: Enthält alle Seiten des Administrationsbereichs (Funktionen sind ausgelagert)
* ```student```: Enthält alle Seiten des Anwenderbereichs (Funktionen sind ausgelagert)

Dateien im Hauptverzeichnis:
* ```constants.inc.php``` Enthält Konstanten-Definitionen, u.a. zur Tabellenbeschreibung, enthält aber auch interne Boolean-Notationen
* ```functions.inc.php``` Enthält grundlegende Funktionalitäten, DB-Verbindung, Logout, Verlinkung auf die anderen Includes
* ```functions-admin.inc.php``` Enthält Konfigurations-Funktionalitäten, wie das Ändern des Passworts
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
