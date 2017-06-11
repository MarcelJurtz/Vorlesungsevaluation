<?php
// Löschen von Fragen und dazugehörigen Antworten
function deleteQuestion($chapterID,$questionText) {
  $conn = getDBConnection();

  $chapterID = mysqli_real_escape_string($conn,$chapterID);
  $questionText = mysqli_real_escape_string($conn,$questionText);
  $query = "SELECT " . FRAGE_FrID . " FROM " . FRAGE . " WHERE " . FRAGE_FPID . " = (SELECT " . FRAGEPOOL_FpID . " FROM " . FRAGEPOOL . " WHERE " . FRAGEPOOL_KaID . " = '$chapterID') AND " . FRAGE_FrBezeichnung . " = '$questionText';";

  $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));
  $ID = $getID[FRAGE_FrID];

  // Löschen nur erlaubt, wenn nicht in Fragebogen enthalten
  $query = "SELECT COUNT(*) as CNT FROM " . FR_IN_FB . " WHERE " . FR_IN_FB_FRBEZ . " = '$ID'";
  $getCount = mysqli_fetch_assoc(mysqli_query($conn,$query));
  $count = $getCount['CNT'];

  if($count == 0) {
    $query = "DELETE FROM " . FRAGE . " WHERE " . FRAGE_FrID . " = $ID;";
    if(mysqli_query($conn,$query)) {
      echo "<p>Frage '$questionText' und dazugehörige Antworten erfolgreich gelöscht.</p>";
    } else {
      echo "<p>Fehler beim Löschen der Frage '$questionText'.</p>";
    }
  } else {
    echo "<p>Die gewählte Frage kann nicht gelöscht werden, da sie bereits in einem Fragebpogen verwendet wird.</p>";
  }
  mysqli_close($conn);
}

function getAllQuestionsOfChapter($chapterID) {
  $conn = getDBConnection();
  $chapterID = mysqli_real_escape_string($conn,$chapterID);

  $query = "SELECT " . FRAGE_FrBezeichnung . " FROM " . FRAGE . " fr INNER JOIN " . FRAGEPOOL . " fp ON fr." .FRAGE_FPID . " = fp." . FRAGEPOOL_FpID . " WHERE " . FRAGEPOOL_KaID . " = $chapterID;";

  $rows = mysqli_query($conn, $query);
  if($rows) {
    $questions = array();
    while($entry = mysqli_fetch_assoc($rows))
    {
      $questions[] = $entry[FRAGE_FrBezeichnung];
    }
    mysqli_close($conn);
    return $questions;
  }
}
// Rückgabe aller Fragen als Array
// zweiter Parameter kann als 'true' übergeben werden
// um nur Fragen zurückzugeben, die noch in keinem Fragebogen enthalten sind
function getAllQuestions($chapterID, $unusedOnly = false) {
  $conn = getDBConnection();

  $query = "SELECT " . FRAGE_FrBezeichnung .
            " FROM " . FRAGE . " fr INNER JOIN " . FRAGEPOOL . " fp ON fr." .FRAGE_FPID . " = fp." . FRAGEPOOL_FpID .
            " WHERE " . FRAGEPOOL_KaID . " = $chapterID;";

  if($unusedOnly) {
    $query = "SELECT " . FRAGE_FrBezeichnung .
              " FROM " . FRAGE . " fr INNER JOIN " . FRAGEPOOL . " fp ON fr." .FRAGE_FPID . " = fp." . FRAGEPOOL_FpID .
              " WHERE " . FRAGEPOOL_KaID . " = $chapterID AND fr." . FRAGE_FrBezeichnung . " NOT IN (SELECT " . FR_IN_FB_FRBEZ . " FROM " . FR_IN_FB . ");";
  }

  $rows = mysqli_query($conn, $query);
  $questions = array();
  if($rows) {
    while($entry = mysqli_fetch_assoc($rows))
    {
      $questions[] = $entry[FRAGE_FrBezeichnung];
    }
  }
  mysqli_close($conn);
  return $questions;
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
    Fragetext: <br /><textarea rows="5" name="txtQuestionTextMC" cols="125" ></textarea>
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
    Fragetext: <br /><textarea name="txtQuestionText" rows="5" cols="125" ></textarea><br /><br />
    Musterlösung: <br / /><textarea name="txtAnswer" rows="5" cols="125" ></textarea>
  </div>
  </div>';

  echo '<input type="submit" name="cmdSaveQuestion" value="Speichern" />';

  echo '</form>';
}

// Frage Speichern
// Fragetyp ist entweder Multiple Choice oder Textfrage
function saveQuestion($questionType) {
  $conn = getDBConnection();
  mysqli_autocommit($conn,FALSE);

  if($questionType == FRAGENTYP_TEXTFRAGE) {
    // Textfrage speichern
    $title = mysqli_real_escape_string($conn,$_POST['txtQuestionTitle']);
    $text = mysqli_real_escape_string($conn,$_POST['txtQuestionText']);
    $answer = mysqli_real_escape_string($conn,$_POST['txtAnswer']);

    if($title != "" && $text != "" && $answer != "") {
      $poolId = getQuestionPoolId(getChapterId($_SESSION['lectureToAddQuestion'], $_SESSION['chapterToAddQuestion']));

      $queryQuestion = "INSERT INTO " . FRAGE . " VALUES (NULL, '$title','$text',$poolId,'$questionType');";
      mysqli_query($conn, $queryQuestion);

      $queryID = "SELECT " . FRAGE_FrID . " FROM " . FRAGE . " WHERE " . FRAGE_FrBezeichnung . " = '$title' AND " . FRAGE_FPID . " = $poolId";
      $getID = mysqli_fetch_assoc(mysqli_query($conn, $queryID));
      $FrID = $getID[FRAGE_FrID];

      $queryAnswer = "INSERT INTO " . ANTWORT . " VALUES ($FrID, '$answer', " . SHORT_FALSE . ", 0);";
      mysqli_query($conn, $queryAnswer);

      if($queryAnswer && $queryID) {
        echo "<p>Frage '$title' erfolgreich zum Kapitel '" . $_SESSION['chapterToAddQuestion'] . "' hinzugefügt!</p>";
        mysqli_commit($conn);
      } else {
        echo "<p>Fehler beim Speichern der Frage. Die Änderungen werden rückgängig gemacht.</p>";
        mysqli_rollback($conn);
      }
    } else {
      echo "<p>Unvollständige Angaben. Die Frage wurde nicht gespeichert.</p>";
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
          echo "<p>Antwort '$text' wurde der Frage hinzugefügt.</p>";
        } else {
          $failedQuestions++;
        }
        if($failedQuestions > 0 && $i == count($answers) -1) {
          echo "<p>Fehler beim Speichern aufgetreten. Die Änderungen werden rückgängig gemacht.</p>";
          mysqli_rollback($conn);
        } else {
          if($i == count($answers) -1) {
            echo "<p>Frage '$title' erfolgreich zum Kapitel '" . $_SESSION['chapterToAddQuestion'] . "' hinzugefügt!</p>";
          }
          mysqli_commit($conn);
        }
      }
    } else {
      echo "<p>Fehler beim Speichern der Frage. Der Eintrag wurde rückgängig gemacht.</p>";
    }
  } else {
    echo '<p>Ungültiger Fragentyp!</p>';
  }
}

function getQuestionPoolId($chapterID) {
  $conn = getDBConnection();

  $query = "SELECT " . FRAGEPOOL_FpID . " FROM " . FRAGEPOOL . " WHERE " . FRAGEPOOL_KaID . " = $chapterID";
  $getID = mysqli_fetch_assoc(mysqli_query($conn, $query));

  mysqli_close($conn);
  return $getID[FRAGEPOOL_FpID];
}
?>
