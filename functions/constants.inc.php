<?php
/*************************************************/
/*                   DATENBANK                   */
/*************************************************/

define("ADMINISTRATOR","administrator");
define("ADMINISTRATOR_AKennwort","AKennwort");
define("ADMINISTRATOR_AName","AName");

define("ANTWORT","antwort");
define("ANTWORT_AWTEXT", "AwText");
define("ANTWORT_FrID", "FrID");
define("ANTWORT_AwWahrheit", "AwWahrheit");
define("ANTWORT_AwID", "AwID");

define("BEANTWORTET","beantwortet");
define("BEANTWORTET_STUD","StName");
define("BEANTWORTET_FRID","FrID");
define("BEANTWORTET_AWID","AwID");
define("BEANTWORTET_AWTEXT","StAntwort");
define("BEANTWORTET_FBID","FbID");

define("FBABGABE","fbabgabe");
define("FBABGABE_STUD","StName");
define("FBABGABE_FBID","FbID");

define("FBFREIGABE","fbfreigabe");
define("FBFREIGABE_FBID","FbId");
define("FBFREIGABE_KUID","KuID");

define("FRAGE","frage");
define("FRAGE_FrTyp","FrTyp");
define("FRAGE_FrID", "FrID");
define("FRAGE_FrBezeichnung","FrBezeichnung");
define("FRAGE_FrText","FrText");
define("FRAGE_FPID", "FpID");

define("FRAGEBOGEN","fragebogen");
define("FRAGEBOGEN_FbBezeichnung","FbBezeichnung");
define("FRAGEBOGEN_Kapitel","KaID");
define("FRAGEBOGEN_FbID","FbId");

define("FRAGEPOOL","fragepool");
define("FRAGEPOOL_FpID","FpID");
define("FRAGEPOOL_KaID","KaID");

define("KAPITEL","kapitel");
define("KAPITEL_KAID","KaID");
define("KAPITEL_KABEZEICHNUNG","KaBezeichnung");
define("KAPITEL_VOID","VoID");

define("KURS","kurs");
define("KURS_KUID","KuID");
define("KURS_KUBEZEICHNUNG","KuBezeichnung");
define("KURS_KUFREIGESCHALTET","KuFreigeschaltet");

define("STUDENT","student");
// TODO: Änderung Bez -> Kürzel
define("STUDENT_KUID","KuBezeichnung");
define("STUDENT_BENUTZERNAME","StName");

define("VORLESUNG","vorlesung");
define("VORLESUNG_VOID","VoID");
define("VORLESUNG_VOBEZEICHNUNG","VoBezeichnung");

define("FR_IN_FB","FrageInFragebogen");
define("FR_IN_FB_FBID","fbID");
define("FR_IN_FB_FRBEZ","frBezeichnung");


/*************************************************/
/*                  MENÜSTRUKTUR                 */
/*************************************************/

define("MENU_OVERVIEW","Übersicht");
define("MENU_CLASS_CREATE","Kurs anlegen");
define("MENU_CLASS_DELETE","Kurs löschen");
define("MENU_CLASS_ENABLE","Kursfreigabe verwalten");
define("MENU_QUESTION_CREATE","Frage anlegen");
define("MENU_QUESTION_DELETE","Frage löschen");
define("MENU_QUESTION_MODIFY","Frage bearbeiten");
define("MENU_SURVEY_CREATE","Fragebogen anlegen");
define("MENU_SURVEY_DELETE","Fragebogen löschen");
define("MENU_SURVEY_MODIFY","Fragebogen bearbeiten");
define("MENU_SURVEY_ENABLE","Fragebogen freigeben");
define("MENU_LECTURE_CREATE","Vorlesung anlegen");
define("MENU_LECTURE_DELETE","Vorlesung löschen");
define("MENU_LECTURE_MODIFY","Vorlesung bearbeiten");
define("MENU_STATISTICS","Statistiken");
define("MENU_SETTINGS","Einstellungen");
define("MENU_LOGOUT","Abmelden");




/*************************************************/
/*                    DIVERSE                    */
/*************************************************/

define("REGFREIGABE_TRUE",1);
define("REGFREIGABE_FALSE",0);

define("SHORT_TRUE", 1);
define("SHORT_FALSE", 0);

define("STRING_TRUE","true");
define("STRING_FALSE","false");

define("ADMIN_DEFAULT_USERNAME","root");

// Achtung! Zusätzlich definiert in JS in functions.inc.php
define("FRAGENTYP_MULTIPLE_CHOICE","mchoice");
define("FRAGENTYP_TEXTFRAGE","text");

// Prüfen:
define("FRAGENTYP_MULTIPLE_CHOICE_DB","mchoic");
define("FRAGENTYP_TEXTFRAGE_DB","text");

/*************************************************/
/*                FARBEN STATISTIK               */
/*************************************************/

define("COLOR_TRUE_A","rgba(105,168,84,0.4)");
define("COLOR_TRUE_BORDER_A","rgba(83,171,61,0.8)");
define("COLOR_FALSE_A","rgba(217,93,91,0.4)");
define("COLOR_FALSE_BORDER_A","rgba(196,61,57,0.8)");

define("COLOR_TRUE_B","rgba(76,141,137,0.4)");
define("COLOR_TRUE_BORDER_B","rgba(59,128,125,0.8)");
define("COLOR_FALSE_B","rgba(223,153,94,0.4)");
define("COLOR_FALSE_BORDER_B","rgba(204,124,63,0.8)");

/*************************************************/
/*                      TOASTS                   */
/*************************************************/

define("TOAST_DUPLICATE_USER","TOAST_DUPL_USER");
define("TOAST_ILLEGAL_COURSE","TOAST_ILLGL_COURSE");
define("TOAST_UNKNOWN_USERNAME","TOAST_UNKN_USER");
define("TOAST_WRONG_PASSWORD","TOAST_WRONG_PASSWORD");
define("TOAST_NO_PERMISSION","TOAST_NO_PERMISSION");

?>
