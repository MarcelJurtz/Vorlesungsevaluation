<?php
// Enthält Funktionen zur Verarbeitung von Fragen und Fragenpools

// Löschen von Fragen und dazugehörigen Antworten
function deleteQuestion($chapterID,$questionText) {
  include_once("constants.inc.php");
  $conn = getDBConnection();

  $chapterID = mysqli_real_escape_string($conn,$chapterID);
  $questionText = mysqli_real_escape_string($conn,$questionText);
  $query = "SELECT " . FRAGE_FrID . " FROM " . FRAGE . " WHERE " . FRAGE_FPID . " = (SELECT " . FRAGEPOOL_FpID . " FROM " . FRAGEPOOL . " WHERE " . FRAGEPOOL_KaID . " = '$chapterID') AND " . FRAGE_FrBezeichnung . " = '$questionText';";

  $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));
  $ID = $getID[FRAGE_FrID];

  // Frage und Antworten löschen
  $query = "DELETE FROM " . ANTWORT . " WHERE " . ANTWORT_FrID . " = $ID;";
  if(mysqli_query($conn,$query)) {
    $query = "DELETE FROM " . FRAGE . " WHERE " . FRAGE_FrID . " = $ID;";
    if(mysqli_query($conn,$query)) {
      echo "Frage '$questionText' und dazugehörige Antworten erfolgreich gelöscht.";
    } else {
      // TODO
    }
  } else {
    //TODO
  }
  mysqli_close($conn);
}

// Rückgabe aller Fragen eines Kapitels
// Zur Verwendung in ComboBoxen
// Muster: <option>Bezeichnung</option>
function getAllQuestionsOfChapter($lectureDescription,$chapterDescription) {
  include_once("constants.inc.php");
  $conn = getDBConnection();

  $chapterID = getChapterId($lectureDescription, $chapterDescription);
  $_SESSION['chapterIDtoDelete'] = $chapterID;


  $query = "SELECT " . FRAGE_FrBezeichnung . " FROM " . FRAGE . " fr INNER JOIN " . FRAGEPOOL . " fp ON fr." .FRAGE_FPID . " = fp." . FRAGEPOOL_FpID . " WHERE " . FRAGEPOOL_KaID . " = $chapterID;";
  //$query = "SELECT FrBezeichnung FROM frage fr INNER JOIN fragepool fp ON fr.FpID = fp.FpID WHERE KaID = $chapterID";
  $rows = mysqli_query($conn, $query);
  if($rows) {
    $returnString = '';
    while($entry = mysqli_fetch_assoc($rows))
    {
       $returnString .= "<option>" . $entry[FRAGE_FrBezeichnung] . "</option>";
    }
    mysqli_close($conn);
    return $returnString;
  }
}

// Aufbau der Frageboxen
function addQuestionContainer() {
  echo '<form action="question_create.php" method="POST">';

  // Auswahl Text / Multiple Choice
  echo '<div class="questionTypeSelection">
  <p><b>Fragentyp auswählen:</b></p>
    <label><input type="radio" name="rbQuestionType" value="'.FRAGENTYP_MULTIPLE_CHOICE.'" onClick="toggleQuestionType(this)" checked />Multiple Choice</label><br />
    <label><input type="radio" name="rbQuestionType" value="'.FRAGENTYP_TEXTFRAGE.'" onClick="toggleQuestionType(this)" />Textfrage</label>
  </div>';

  // Container für Multiple Choice Fragen
  echo '<div id="questionMCContainer">
  <p>
    <b>Frage bearbeiten:</b><br /><br />
    Fragetitel:<br /><input type="text" name="txtQuestionTitleMC" size="80" /><br /><br />
    Fragetext: <br /><textarea rows="5" name="txtQuestionTextMC" cols="125"></textarea>
  </p>
  <p>
    <b>Lösungsmöglichkeiten bearbeiten:</b><br /><br />
    <input type="button" name="cmdAddNewAnswer" value="Neue Antwort hinzufügen" onClick="addAnswerContainer()"/>
    <br />
    <div id="questionMCAnswerContainer">
    <div>
      Lösungstext: <input type="text" size="80" name="txtAnswers[]" />
      <label><input type="checkbox" name="cbAnswerCorrect[]" onchange="toggleTextBox(this)"/>Antwort korrekt</label>
      <input type="button" name="cmdDeleteAnswer" value="Antwort löschen" onClick="deleteAnswerContainer(this)"/>
      <input class="hid" type="hidden" name="txtTrueFalse[]" value="false" />
        <br />
      </div>
    </div>
    </p>
  </div>';

  // Container für Textfragen
  echo '<div id="questionTextContainer" style="display: none">
  <div>
    <b>Frage bearbeiten:</b><br /><br />
    Fragetitel:<br /><input type="text" name="txtQuestionTitle" size="80" /><br /><br />
    Fragetext: <br /><textarea name="txtQuestionText" rows="5" cols="125"></textarea><br /><br />
    Musterlösung: <br / /><textarea name="txtAnswer" rows="5" cols="125"></textarea>
  </div>
  </div>';

  echo '<input type="submit" name="cmdSaveQuestion" value="Speichern" />';

  echo '</form>';
}

// Frage Speichern
// Fragetyp ist entweder Multiple Choice oder Textfrage
function saveQuestion($questionType) {
  include_once("constants.inc.php");
  $conn = getDBConnection();

  if($questionType == FRAGENTYP_TEXTFRAGE) {
    // Textfrage speichern
    $title = mysqli_real_escape_string($conn,$_POST['txtQuestionTitle']);
    $text = mysqli_real_escape_string($conn,$_POST['txtQuestionText']);
    $answer = mysqli_real_escape_string($conn,$_POST['txtAnswer']);

    $poolId = getQuestionPoolId(getChapterId($_SESSION['lectureToAddQuestion'], $_SESSION['chapterToAddQuestion']));

    $queryQuestion = "INSERT INTO " . FRAGE . " VALUES (NULL, '$title','$text',$poolId,'$questionType');";
    if(mysqli_query($conn, $queryQuestion)) {

      $query = "SELECT " . FRAGE_FrID . " FROM " . FRAGE . " WHERE " . FRAGE_FrBezeichnung . " = '$title' AND " . FRAGE_FPID . " = $poolId";
      $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));
      $FrID = $getID[FRAGE_FrID];

      $queryAnswer = "INSERT INTO " . ANTWORT . " VALUES ($FrID, '$answer', " . SHORT_FALSE . ", 0);";
      if(mysqli_query($conn, $queryAnswer)) {
        echo "Frage '$title' erfolgreich zum Kapitel '" . $_SESSION['chapterToAddQuestion'] . "' hinzugefügt!";
      }
    } else {
      echo "Fehler beim Speichern der Frage. Der Eintrag wurde rückgängig gemacht.";
    }

  } else if ($questionType == FRAGENTYP_MULTIPLE_CHOICE) {
    // Multiple Choice Frage speichern
    $title = $_POST['txtQuestionTitleMC'];
    $text = $_POST['txtQuestionTextMC'];
    //$answers[] = $_POST['txtAnswers'];

    $answers = $_POST['txtAnswers'];

    $poolId = getQuestionPoolId(getChapterId($_SESSION['lectureToAddQuestion'], $_SESSION['chapterToAddQuestion']));
    $queryQuestion = "INSERT INTO " . FRAGE . " VALUES (NULL, '$title','$text',$poolId,'$questionType');";

    // Kontrolle, ob alle Antworten eingefügt wurden
    $failedQuestions = 0;

    if(mysqli_query($conn, $queryQuestion)) {
      for($i = 0; $i < count($answers); $i++) {
        $text = mysqli_real_escape_string($conn,$_POST['txtAnswers'][$i]);
        $bool = mysqli_real_escape_string($conn,$_POST['txtTrueFalse'][$i]);

        if($bool == STRING_TRUE) {
          $bool = SHORT_TRUE;
        } else {
          $bool = SHORT_FALSE;
        }

        $query = "SELECT " . FRAGE_FrID . " FROM " . FRAGE . " WHERE " . FRAGE_FrBezeichnung . " = '$title' AND " . FRAGE_FPID . " = $poolId";
        $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));
        $FrID = $getID[FRAGE_FrID];

        $queryAnswer = "INSERT INTO " . ANTWORT . " VALUES ($FrID, '$text', '$bool', $i);";

        if(mysqli_query($conn, $queryAnswer)) {
          echo "Antwort '$text' wurde der Frage hinzugefügt.<br />";
        } else {
          $failedQuestions++;
        }
        if($failedQuestions > 0 && $i == count($answers) -1) {
          echo "Fehler beim Speichern aufgetreten. Die Änderungen werden rückgängig gemacht.";
          //TODO: Einträge wieder löschen (?)
        } else {
          if($i == count($answers) -1) {
            echo "Frage '$title' erfolgreich zum Kapitel '" . $_SESSION['chapterToAddQuestion'] . "' hinzugefügt!";
          }
        }
      }
    } else {
      echo "Fehler beim Speichern der Frage. Der Eintrag wurde rückgängig gemacht.";
    }
  } else {
    echo 'Ungültiger Fragentyp!';
  }
}

function getQuestionPoolId($chapterID) {
  include_once("constants.inc.php");
  $conn = getDBConnection();

  $query = "SELECT " . FRAGEPOOL_FpID . " FROM " . FRAGEPOOL . " WHERE " . FRAGEPOOL_KaID . " = $chapterID";
  $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));

  mysqli_close($conn);
  return $getID[FRAGEPOOL_FpID];
}
?>
