# Entwicklungsdokumentation

**Stand: 21.06.2017, Version 1.0.2**

Dieses Dokument beinhaltet sämtliche Informationen, die zur Weiterentwicklung dieses Projekts notwendig sind.

Allgemein baut sich die Struktur folgendermaßen auf: Die Seiten in den Ordnern *admin* und *student* stellen die Teilfunktionen dar, welche über die Menüstruktur erreichbar sind. Die Funktionalität der Seiten, beispielsweise das Anlegen eines neuen Kurses gestaltet sich in der Form, dass der Administrator die gewünschten Daten eingibt, und das HTML-Formular auf die aktuelle Seite referenziert.
Auf der Seite selbst wird der Stand überprüft und entsprechende Steuerelemente ausgegeben.
Die eigentlichen Funktionen jedoch sind jeweils in den entsprechenden Dateien ausgelagert.

Konstanten sind in der Datei ```functions/constants.inc.php``` aufgeführt.

<div class="page-break"></div>

## 1 Dateistruktur

Ordner:

* ```admin```: Enthält alle Seiten des Administrationsbereichs (Funktionen sind ausgelagert)
* ```student```: Enthält alle Seiten des Anwenderbereichs (Funktionen sind ausgelagert)
* ```functions```: Enthält die ausgelagerten Funktionsdateien, getrennt für Admin und Student. Funktionen, die von beiden Parteien benötigt werden, befinden sich in der Datei ```mixed.inc.php```. Außerdem: ```logout.inc.php``` zur Ausführung der Abmeldung, ```db.inc.php``` zur Erstellung einer Datenbankverbindung, sowie ```constants.inc.php```, welche Konstanten enthält, um die verwendeten Zeichenketten zu zentralisieren. Dies beinhaltet auch Datenbank- und Tabellenbezeichnungen. Die Datei ```toaster.inc.php``` erzeugt Benachrichtungen, wie sie beispielsweise von Android bekannt sind.

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

<div class="page-break"></div>

## 2 Funktionen

Dieses Kapitel liefert einen Überblick über die verschiedenen verfügbaren Funktionen.

### 2.1 PHP

Einige der Funktionen besitzen einen Parameter ```$deletable = false```.
Dieser kann mit dem Wert ```true``` verwendet werden, um nicht die gesamte Menge der Einträge (beispielsweise Kurse) abzufragen, sondern lediglich diejenigen,
die noch keine von Studenten beantwortete Fragen enthalten. Der Parameter findet in den Funktionalitäten zum Löschen und Ändern von Einträgen Anwendung.

* ./functions/adminFunctions/functions-admin.inc.php
  * ```changePassword($oldPassword, $newPassword, $newPasswordConfirmed)```: Ändern des Admin-Passworts

* ./functions/adminFunctions/functions-chapter.inc.php:
  * ```getChapterId($lectureDescription, $chapterDescription)```: Bezug der ID eines Kapitels anhand Vorlesungs- und Kapitelbezeichnung
  * ```getAllChaptersOfLecture($lectureDescription, $deletable = false)```: Bezug aller Kapitel einer Vorlesung anhand deren Bezeichnung
  * ```addLectureChapter($lectureDescription, $chapterDescription)```: Hinzufügen eines Kapitels zu einer Vorlesung
  * ```deleteChapter($lecture, $chapter)```: Löschen eines Kapitels

* ./functions/adminFunctions/functions-class.inc.php
  * ```toggleClassRegistration($classID, $regStatus)```: Umschalten der Freigabe eines Kurses zur Registrierung
  * ```createClass($kDescription, $kShort)```: Erstellen eines Kurses
  * ```deleteClass($classID)```: Löschen eines Kurses
  * ```getClassesForSurvey($surveyID)```: Rückgabe aller Kurse, die für eine Vorlesung freigeschaltet sind

* ./functions/adminFunctions/functions-lecture.inc.php:
  * ```getAllLectures($deletable = false)```: Rückgabe aller Vorlesungen
  * ```createLecture($description)```: Erstellen einer Vorlesung
  * ```renameLecture($lectureDescriptionOld, $lectureDescriptionNew)```: Umbenennen einer Vorlesung
  * ```deleteLecture($lectureDescription)```: Löschen einer Vorlesung

* ./functions/adminFunctions/functions-menu.inc.php:
  * ```printAdminMenu($current)```: Ausgabe des Beginns der Admin-Menüstruktur, Parameter zur Angabe des aktuellen Pfads (siehe constants.inc.php)
  * ```printAdminMenuBottom()```: Ausgabe des Endes der Admin-Menüstruktur

* ./functions/adminFunctions/functions-question.inc.php:
  * ```deleteQuestion($chapterID,$questionText)```: Löschen eines Kapitels
  * ```getAllQuestionsOfChapter($chapterID, $deletable = false)```: Rückgabe aller Fragen eines Kapitels.
  * ```addQuestionContainer()```: Aufbau der Frageboxen
  * ```saveQuestion($questionType)```: Speichern einer Frage (Multiple Choice oder Textfrage)
  * ```getQuestionPoolId($chapterID)```: Bezug der ID des Fragepools eines Kapitels

* ./functions/adminFunctions/functions-survey.inc.php:
  * ```fbExisting($fb)```: Rückgabe, ob Fb-Bezeichnung bereits vergeben ist (true/false)
  * ```createFb($fb, $lecture, $chapter)```: Erstellen eines Fragebogens
  * ```saveQuestionToFb($fb, $question)```: Hinzufügen einer Frage zu einem Fragebogen
  * ```saveQuestionToFbV2($fb, $question)```: S.o.
  * ```deleteSurveyQuestions($fb)```: Löschen der Fragen eines Fragebogens
  * ```getAllSurveys($deletable = false)```: Rückgabe aller Fragebögen
  * ```getComparableSurveys()```: Rückgabe aller Fragebögen, die für mindestens zwei Kurse freigeschaltet sind
  * ```deleteSurvey($surveyName)```: Löschen eines Fragebogens
  * ```getSurveyID($surveyName)```: Rückgabe der ID eines Fragebogens anhand dessen Bezeichnung
  * ```enableSurvey($survey, $class)```: Freigabe eines Fragebogens für einen Kurs
  * ```getEnabledSurveys()```: Rückgabe aller Fragebögen, die bereits für einen Kurs freigeschalten sind
  * ```getSurveyChapterID($survey)```: Rückgabe der ID eines Kapitels anhand eines Fragebogens
  * ```getSurveyQuestions($survey)```: Rückgabe der Fragen eines Fragebogens
  * ```getSubmittedStudents($surveyID, $classID)```: Rückgabe der Anzahl an Studenten eines Kurses, die einen bestimmten Fragebogen bereits abgegeben haben
  * ```getTotalStudents($surveyID, $classID)```: Rückgabe der Anzahl an Studenten eines Kurses
  * ```GetAmountOfVotes($questionName, $surveyName, $classID)```: Rückgabe der Anzahl an Stimmen für eine Frage innerhalb eines Fragebogens je Kurs

* ./functions/db.inc.php:
  * ```getDBConnection()```: Aufbau der Verbindung zur Datenbank

* ./functions/logout.inc.php
  * ```logoutAdmin()```; Durchführen des Logout-Vorgangs

* ./functions/mixed.inc.php
  * ```getAllClasses($deletable = false)```: Bezug aller Kurse
  * ```getAllRegEnabledClasses($enabled = SHORT_TRUE)```: Bezug aller Kurs, die (nicht) freigeschalten sind
  * ```GetClassSurveys($class)```: Bezug aller Fragebögen, die für einen Kurs freigeschalten sind
  * ```getClassIdFromCbString($cbString)```: Konversion der Schreibweise 'WI214 - Wirtschaftsinformatik 2 2014' in 'WI214'

* ./functions/studentFunctions/functions-class.inc.php
  * ```GetClassFromStudent($username)```: Rückgabe des Kurses eines Studenten

* ./functions/studentFunctions/functions-login.inc.php
  * ```registerStudent($username, $class)```: Student registrieren
  * ```ValidateUsername($username)```: Student anmelden
  * ```SetSessionUsername($username)```: Sessionvariablen setzen
  * ```GetSessionUsername()```: Sessionvariablen prüfen (Anmeldung legitimieren)
  * ```printClassTitle()```: Ausgabe des Kurses in der Überschrift
  * ```printSidebarMenuBegin($entry)```: Beginn Menüstruktur Student
  * ```printSidebarMenuEnd()```: Ende Menüstruktur Student

* ./functions/studentFunctions/functions-survey.inc.php
  * ```GetNewSurveys($class)```: Rückgabe aller neuen (unbearbeiteten) Fragebögen
  * ```GetEditedSurveys($class)```: Rückgabe aller angefangenen Fragebögen
  * ```GetCompletedSurveys($student)```: Rückgabe aller abgegebenen Fragebögen
  * ```ValidateUserSurveyEdit($student,$survey)```: Prüfung, ob Anwender zur Bearbeitung des Fragebogens berechtigt ist
  * ```getSurveyID($surveyName)```: Rückgabe der ID des Fragebogens anhand der Bezeichnung
  * ```EditSurvey()```: Bearbeiten einer Umfrage
  * ```GetOwnSolution($surveyID, $questionID, $studName)```: Rückgabe der Lösung des Studenten
  * ```GetTextQuestionSolution($questionID)```: Rückgabe der Musterlösung einer Textfrage
  * ```GetMCQuestionAnswer($fbID, $questionID, $answerID)```: Rückgabe der Korrektheit einer Antwort in einer Multiple Choice Frage
  * ```saveLastQuestion()```: Speichern der letzten Frage, wird auf Studentenseite bei Klick auf *Weiter*, *Speichern* und *Fragebogen abgeben* ausgelöst

* ./functions/studentFunctions/survey.php: Klassen 'survey', 'question', sowie entsprechende Methoden
  * ```SetSurveyQuestions()```
  * ```GetQuestions()```
  * ```GetQuestionCount()```
  * ```GetSurveyName()```
  * ```GetQuestionAt($index)```
  * ```GetID()```
  * ```SetQuestionDetails()```
  * ```GetQuestionAnswers()```
  * ```GetQuestionAnswersWithTruths()```
  * ```GetAnswerText($awid)```
  * ```GetName()```
  * ```GetText()```
  * ```GetType()```
  * ```GetID()```

### 2.2 JavaScript

* ./functions/js/chartFunctions.js:
  * ```DrawChart(canvasID, remoteFields, remoteData, remoteColors, remoteBorderColors)```: Zeichnen der Canvas-Statistik für einen Kurs
  * ```DrawComparisonChart(canvasID, remoteFields, remoteData, remoteColors, remoteBorderColors, remoteLabel)```: Zeichnen der Canvas-Statistik für zwei Kurse zum Vergleich
  * canvasID bezieht sich auf die ID des HTML-Elements, remoteFields auf die Beschriftungen auf der X-Achse, also hier den Antwortmöglichkeiten der Frage, remoteData auf die jeweilige Anzahl an Beantwortungen, remoteColors und remoteBorderColors auf die Farbgebung der Balken und remoteLabel auf das Kürzel des Kurses zur Differenzierung bei paralleler Anzeige zweier Kurse.

* ./functions/js/question.js:
  * ```addAnswerContainer()```: Hinzufügen eines Antwort-Containers für Multiple-Choice-Fragen
  * ```deleteAnswerContainer(item)```: Löschen eines Antwort-Containers für Multiple-Choice-Fragen
  * ```toggleQuestionType(rbutton)```: Umschalten des Fragentyps (Multiple Choice / Textfrage) mittels RadioButton
  * ```toggleTextBox(item)```: Umschalten der RadioButton-Hilfsstruktur zur Übermittlung von Wahrheitswerten

<div class="page-break"></div>

## 3 Toasts

 Toasts werden verwendet, um dem Anwender Benachrichtungen anzuzeigen, beispielsweise bei Eingabe eines ungültigen Kennworts. Die Methode ```makeToast($text)``` benötigt hierzu ein HTML-Element vom Typ ```div``` mit der ID *toast*. Toasts werden wie folgt verwendet:

 ```PHP
<div id="toast">NO CONTENT</div>
<?php
  include "adminFunctions.inc.php";
  if(isset($_SESSION['toaster']) && $_SESSION['toaster'] != "") {
    $toast = $_SESSION['toaster'];
    if($toast == TOAST_WRONG_PASSWORD || $toast == TOAST_NO_PERMISSION) {
      makeToast($toast);
    }
    session_destroy();
  }
?>
 ```

<div class="page-break"></div>

## 4 Notation

* Textboxen (auch Textarea): txtBezeichnung
* Radiobuttons: rbBezeichnung
* Checkboxen: chkBezeichnung
* Buttons: cmdBezeichnung

Aufgrund fehlender Unterstützung des Datentyps *Boolean* wurde intern mit der Notation *0* für *false* und *1* für *true* gearbeitet. In der Datei ```functions/constants.inc.php``` sind Konstanten hierfür definiert.

<div class="page-break"></div>

## 5 Gestaltung

Die Farbgebung richtet sich nach den Farben der Website der DHBW Ravensburg.

Schrift (grau): #161616  
Schrift (weiß): #FFFFFF  
Buttons und Hintergründe (rot): #E2001A  

Die verwendete Schriftart ist Open Sans (In Verwendung: Regular und Bold):  
https://fonts.google.com/specimen/Open+Sans  
Open Sans ist unter der Apache License 2.0 verfügbar.

<div class="page-break"></div>

## 6 Dependencies

[Chart.js](http://www.chartjs.org/) wird für die Darstellung von Diagrammen zur Auswertung verwendet.  
Die eingebundene Skript-Datei liegt unter ```functions/js/Chart.bundle.min.js```.

Chart.js ist auf [GitHub](https://github.com/chartjs/Chart.js) unter MIT-Lizenz verfügbar, und kann somit auch für kommerzielle Projekte verwendet werden.
