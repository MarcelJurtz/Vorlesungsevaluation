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

Zu Testzwecken kann dies mit XAMPP erledigt werden.  
https://www.apachefriends.org/de/index.html

Bei der Verwendung von Xampp gibt es ein paar Kleinigkeiten zu beachten:  
Um die Datenbank mit einem Passwort zu beschützen, muss die Datei *PhpMyAdmin/config.inc.php* folgendermaßen angepasst werden:
```php
<?php
// ...
$cfg['Servers'][$i]['auth_type'] = 'cookie';
// ...
?>
```

Anschließend muss die Anwenderkonfiguration unter ```localhost:port/phpmyadmin``` angepasst werden. Nach der Anmeldung mit dem Benutzernamen *root* und leerem Kennwort kann dies in den Einstellungen gesetzt werden.


Öffnen Sie zuerst die Weboberfläche von PhpMyAdmin. Erstellen Sie eine neue Datenbank (Standardname: veva).  
Importieren Sie die sql-dateien *DB-Import/struktur.sql* und *DB-Import/inhalt.sql* in dieser Reihenfolge.
Hierdurch wird die benötigte Struktur angelegt und mit Beispieldaten des Kapitels *Logik und Algebra* befüllt.
Sobald der Import ohne Fehler abgeschlossen wurde, kann das Programm verwendet werden.  
Bitte passen Sie abschließend die Datenbank-Konfiguration in der Datei *functions/db.inc.php* an.

Es wurde ein Standard-Administrator angelegt, welcher das Kennwort *DHBW* besitzt.
Das Kennwort ist per SHA256-Hashing in der Datenbank hinterlegt und kann im Menüpunkt *Einstellungen* angepasst werden.

Kopieren Sie den Inhalt des Ordners in das Web-Verzeichnis des Apache-Servers.
Bei XAMPP ist dies */htdocs*.

Sobald der Inhalt übertragen wurde, ist die Administrationsseite unter ```localhost:port/admin```
und die Anwenderseite über ```localhost:port/student``` erreichbar. Bei Verwendung von lediglich ```localhost:port```
werden Sie auf die Studentenseite weitergeleitet.

<div class="page-break"></div>

## Anwendung

Nach erfolgreicher Anmeldung erhalten Sie eine Menüansicht mit den verschiedenen Funktionalitäten. Im Folgenden werden diese kurz beschrieben:

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

<div class="page-break"></div>

## Entwicklernotizen

Dieser Abschnitt beschreibt die Verteilung der Dateien, um zukünftige Anpassungen zu erleichtern.

Allgemein baut sich die Struktur folgendermaßen auf: Die Seiten in den Ordnern 'admin' und 'student' stellen die Teilfunktionen dar, welche über die Menüstruktur erreichbar sind. Die Funktionalität der Seiten, beispielsweise das Anlegen eines neuen Kurses gestaltet sich in der Form, dass der Administrator die gewünschten Daten eingibt, und das HTML-Formular auf die aktuelle Seite referenziert.
Auf der Seite selbst wird der Stand überprüft und entsprechende Steuerelemente ausgegeben.
Die eigentlichen Funktionen jedoch sind jeweils in den entsprechenden Dateien ausgelagert.

### Dateien

Ordner:

* ```admin```: Enthält alle Seiten des Administrationsbereichs (Funktionen sind ausgelagert)
* ```student```: Enthält alle Seiten des Anwenderbereichs (Funktionen sind ausgelagert)
* ```functions```: Enthält die ausgelagerten Funktionsdateien, getrennt für Admin und Student. Funktionen, die von beiden Parteien benötigt werden, befinden sich in der Datei ```mixed.inc.php```. Außerdem: ```logout.inc.php``` zur Ausführung der Abmeldung, ```db.inc.php``` zur Erstellung einer Datenbankverbindung, sowie ```constants.inc.php```, welche Konstanten enthält, um die verwendeten Zeichenketten zu zentralisieren. Dies beinhaltet auch Datenbank- und Tabellenbezeichnungen.

Dateien im Ordner *admin*:

* ```admin.php``` Startseite nach erfolgreicher Anmeldung
* ```adminFunctions.inc.php``` Inkludiert die Funktionsdateien für den Administrationsbereich.
* ```class_*.php``` Seiten der Menüpunkte zur Verwaltung von Kursen.
* ```lecture_*.php``` Seiten der Menüpunkte zur Verwaltung von Vorlesungen.
* ```question_*.php``` Seiten der Menüpunkte zur Verwaltung von Fragen.
* ```settings.php``` Einstellungsseite, enthält Funktionalität zur Änderung des Kennworts.
* ```statistics.php``` Übersichtsseite zur Auswertung von Fragebögen
* ```survey_*.php``` Seiten der Menüpunkte zur Verwaltung von Fragebögen.

Dateien im Ordner *student*:

* ```registerStudent.php```
* ```student.php``` Startseite nach erfolgreicher Anmeldung
* ```studFunctions.inc.php``` Inkludiert die Funktionsdateien für den Studentenbereich.
* ```survey_edit.php``` Seite zur Bearbeitung eines ausgewählten Fragebogens.
* ```survey_main.php``` Startseite zur Bearbeitung von Fragebögen (Übersicht und Auswahl).

Dateien im Ordner *functions/adminFunctions*:

* ```functions.inc.php``` Enthält grundlegende Funktionalitäten, DB-Verbindung, Logout, Verlinkung auf die anderen Includes
* ```functions-admin.inc.php``` Enthält Konfigurations-Funktionalitäten, wie das Ändern des Passworts
* ```functions-chapter.inc.php``` Enthält Funktionalitäten zur Verwaltung von Kapiteln (einer Vorlesung)
* ```functions-lecture.inc.php``` Enthält Funktionalitäten zur Verwaltung von Kursen
* ```functions-question.inc.php``` Enthält Funktionalitäten zur Verwaltung von Vorlesungen
* ```functions-student.inc.php``` Enthält Funktionalitäten zur Verwaltung von Fragen
* ```functions-student.inc.php``` Enthält Funktionalitäten zur Verwaltung von Studenten

Dateien im Ordner *functions/studentFunctions*:

* ```functions-class.inc.php``` Enthält Funktion zum Bezug des Kurses eines Studenten
* ```functions-info.inc.php``` Enthält Funktion zum Laden eines Info-Texts für die Startseite des Studenten
* ```functions-login.inc.php``` Enthält Funktionalitäten zur Registrierung und Anmeldung
* ```functions-survey.inc.php``` Enthält Funktionalitäten zur Bearbeitung von Fragebögen
* ```survey.php``` Klassen ```survey``` und ```question```

### Boolean-Notationen:

Aufgrund fehlender Unterstützung des Datentyps *Boolean* wurde intern mit der Notation *0* für *false* und *1* für *true* gearbeitet. In der Datei ```functions/constants.inc.php``` sind Konstanten hierfür definiert.
