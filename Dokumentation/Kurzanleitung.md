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

Siehe hierzu: [Entwicklernotizen](Entwicklung.md)
