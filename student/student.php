<!DOCTYPE html>
<html>
<head>
	<link href="../global.css" rel="stylesheet" type="text/css">
	<title>Admin - Übersicht</title>
	<meta charset="UTF-8">
</head>
<body>
	<div id="toast">NO CONTENT</div>
<?php

  include "studFunctions.inc.php";

	if(isset($_SESSION['toaster']) && $_SESSION['toaster'] != "") {
		if($_SESSION['toaster'] == TOAST_SURVEY_SAVED || $_SESSION['toaster'] == TOAST_SURVEY_SUBMITTED) {
			makeToast($_SESSION['toaster']);
			$_SESSION['toaster'] = "";
		}
	}


  if(!ValidateUsername(GetSessionUsername())) {
   logout();
 } else {
  printSidebarMenuBegin("overview");

	echo'
	<h1>Übersicht</h1>
	<p>
		Diese Anwendung dient der Bearbeitung von Fragebögen, die durch den Dozenten erstellt und freigegeben werden.<br />
		Die freigegebenen Fragebögen sind unter dem Menüpunkt <i>Fragebogen beantworten</i> ersichtlich.
	</p>
	<p>
		Bei der Beantwortung einer Frage und dem anschließenden Drücken der Schaltfläche <i>Weiter</i> wird die Antwort bereits gespeichert,
		kann jedoch noch geändert werden.
	<br />
		Fragebögen können somit zu einem späteren Zeitpunkt beendet werden.
		Bereits abgeschlossene Fragebögen können außerdem inklusive der Musterlösung eingesehen werden.
	</p>
	';

  printSidebarMenuEnd();
   }
?>
</body>
</html>
