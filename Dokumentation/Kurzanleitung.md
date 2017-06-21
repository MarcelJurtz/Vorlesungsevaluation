# Benutzerhandbuch Vorlesungsevaluation

**Stand: 21.06.2017, Version 1.0.2**

Diese Dokumentation vermittelt Inhalte zur Installation der Software, sowie zur Inbetriebnahme aus Sicht des Administrators sowie der Studenten als Anwender.

<div class="page-break"></div>

## Installation

Folgende Dienste werden benötigt:
* Apache2
* PHP
* MySQL
* PhpMyAdmin

Dies kann mit XAMPP erledigt werden.  
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


1. Öffnen Sie zuerst die Weboberfläche von PhpMyAdmin.
2. Erstellen Sie eine neue Datenbank (Standardname: veva).  
3. Importieren Sie die sql-dateien *DB-Import/struktur.sql* und *DB-Import/inhalt.sql* in dieser Reihenfolge.
Hierdurch wird die benötigte Struktur angelegt und mit Beispieldaten des Kapitels *Logik und Algebra* befüllt.
4. Sobald der Import ohne Fehler abgeschlossen wurde, kann das Programm verwendet werden.  
5. Bitte passen Sie abschließend die Datenbank-Konfiguration in der Datei *functions/db.inc.php* an.

Es wurde ein Standard-Administrator angelegt, welcher das Kennwort *DHBW* besitzt.
Das Kennwort ist per SHA256-Hash in der Datenbank hinterlegt und kann im Menüpunkt *Einstellungen* geändert werden.

Kopieren Sie den Inhalt des Ordners in das Web-Verzeichnis des Apache-Servers.
Bei XAMPP ist dies *./htdocs*.

Sobald der Inhalt übertragen wurde, ist die Administrationsseite unter ```localhost:port/admin```
und die Anwenderseite über ```localhost:port/student``` erreichbar. Bei Verwendung von lediglich ```localhost:port```
werden Sie auf die Studentenseite weitergeleitet.

<div class="page-break"></div>

## Anwendung auf Seite des Administrators

Nach erfolgreicher Anmeldung erhalten Sie eine Menüansicht mit den verschiedenen Funktionalitäten. Im Folgenden werden diese kurz beschrieben:

* ```Übersicht```
  * Startseite / Landing-Page
* ```Kurse```
  * Anlegen und Löschen von Kursen.
  * das Kürzel entspricht der Kurzschreibweise in Form von fünf Zeichen, beispielsweise ```WI214```.
  * Unter *Kursfreigabe verwalten* können Kurse zur Registrierung freigeschaltet werden, Studenten können sich nur für Kurse registrieren, die freigeschaltet sind. Dies verhindert unberechtigte Registrierung.
* ```Fragen```
  * Anlegen und Löschen von Fragen (Bearbeitungsfunktion wird noch implementiert).
  * Auswahl von Vorlesung und Kapitel, anschließend Anlegen einer Frage. Auswahlmöglichkeit zwischen Textfrage (mit Musterlösung) sowie Multiple-Choice-Fragen mit beliebig vielen (korrekten) Antworten.
  * Um Fragen übersichtlicher anlegen zu können, besteht die Möglichkeit, HTML-Tags in den Eingabefeldern zu verwenden. Benutzen Sie beispielsweise ```<br />``` für einen Zeilenumbruch, sowie ```<b>``` für **fett** und ```<i>``` für *kursiv* gedruckten Text.
* ```Fragebögen```
  * Zu jedem Kapitel können mehrere Fragebögen erstellt werden. Diese werden anschließend von den Studenten bearbeitet.
* ```Vorlesungen```
  * Anlegen und Löschen von Vorlesungen.
  * Unter *Vorlesung bearbeiten* können Kapitel hinzugefügt, sowie Vorlesungen umbenannt werden.
* ```Statistiken```
  * Übersicht über die Beantwortung der Fragebögen durch die Studenten.
  * Lediglich abgegebene Fragebögen werden beachtet.
  * Es existieren momentan zwei verschiedene Möglichkeiten zur Einsicht: Ansicht der Beantwortung eines Kurses, oder Vergleich zweier Kurse.
  Die Umsetzung beider ist recht ähnlich, die verschiedenen Multiple-Choice-Fragen werden in Form von Balkendiagrammen visualisiert, wobei jede Antwortmöglichkeit jeder Frage mit den entsprechenden Beantwortungsanzahlen sowie einer farblichen Kennzeichnung als wahr bzw. falsch abgebildet wird.
  Beim Vergleich zweier Kurse werden die Beantwortungen jeweils (innerhalb desselben Diargamms) nebeneinander abgebildet.
* ```Einstellungen```
  * Administrations-Konfiguration, enthält bisher lediglich die Passwort-Änderung des Administrators.
* ```Abmelden```
  * Logout und Leiten auf die Startseite (Student).

<div class="page-break"></div>

## Anwendung auf Seite des Studenten

Zu Beginn muss jeder Student einen Account erstellen. Dies ist unter Angabe des Kürzels eines Kurses möglich, welchen der Administrator zuvor erstellt und freigegeben haben muss. Anschließend meldet sich der Student mit seinem Benutzernamen (gemäß der Anforderungsbeschreibung wird kein Kennwort benötigt) an.

Nachdem der Student siche erfolgreich angemeldet hat, befindet er sich auf einer minimalistischen Oberfläche,
die dem grafischen Stil des Administrationsbereichs angepasst ist.

Die verfügbaren Menüpunkte sind:

* Übersicht
* Fragebogen beantworten
* Abmelden

Die Übersicht entspricht der Landingpage und beschreibt stichwortartig die Verwendung der Software.

Unter *Fragebogen beantworten* findet der Student eine Übersicht der für den entsprechenden Kurs freigegebenen Fragebögen,
die in drei Gruppen unterteilt sind:

* Neue Fragebögen
  * Auflistung von Fragebögen, die zur Beantwortung freigegeben wurden, aber noch nicht durch den Studenten bearbeitet wurden
* Angefangene Fragebögen
  * Auflistung von Fragebögen, die bereits durch den Studenten bearbeitet, aber noch nicht abgegeben wurden. Der Student erhält hier die Möglichkeit zur Korrektur seiner Antworten.
* Abgeschlossene Fragebögen
  * Auflistung aller abgegebenen Fragebögen, Studenten erhalten hier die Möglichkeit zur Einsicht der Frage, der eigenen Lösung, sowie der Musterlösung.

Die Bearbeitung der Fragen gestaltet sich einfach, durch Schaltflächen *Zurück* / *Vorwärts* wird zwischen den Fragen navigiert. Bei Bestätigung einer der beiden Schaltflächen wird die Eingabe automatisch gespeichert. Die letzte Frage verfügt über eine zusätzliche Schalftläche *Fragebogen abgeben*, durch deren Betätigung der Fragebogen abgegeben wird, nicht mehr editierbar ist und inklusive der Musterlösung eingesehen werden kann.
