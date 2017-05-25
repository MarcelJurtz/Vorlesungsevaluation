<?php
// Datenbank-Bezeichnungen
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

// Eigene Konstanten

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
?>
