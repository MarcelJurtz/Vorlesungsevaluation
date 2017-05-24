<?php

class survey {
  private $fbID;
  // TODO benötigt? private $kaID;
  private $fbName;
  private $questions;

  public function __construct($fbName) {
    $conn = getDBConnection();

    // Setze Eigenschaften anhand Datenbank
    $this->fbID = getSurveyID($fbName);
    $this->fbName = $fbName;


    $this->SetSurveyQuestions();
  }

  private function SetSurveyQuestions() {
    $fbID = $this->fbID;
    $conn = getDBConnection();
    $this->questions = array();

    $query = "SELECT " . FR_IN_FB_FRBEZ . " FROM " . FR_IN_FB . " WHERE " . FR_IN_FB_FBID . " = '$fbID';";
    $result = mysqli_query($conn,$query);
    while($entry = mysqli_fetch_assoc($result))
    {
      // $questions[] = $entry[FR_IN_FB_FRBEZ];
      // echo "Lade Frage " . $entry[FR_IN_FB_FRBEZ] . " (survey.php 30)<br />";
      $this->questions[] = new question($entry[FR_IN_FB_FRBEZ]);
    }
    mysqli_close($conn);
  }

  public function GetQuestionCount() {
    return count($this->questions);
  }

  public function GetSurveyName() {
    return $this->fbName;
  }

  public function GetQuestionAt($index) {
    return $this->questions[$index];
  }
}


class question {
  private $id;
  private $name;
  private $text;
  private $type;

  // Textfrage: 1 Element, Multiple Choice mehr TODO: Umsetzung prüfen
  private $answers;

  public function __construct($name) {
    // echo "Construct $name <br />";
    $this->name = $name;
    // echo "Lade Frage: '$name'<br />";
    // Details laden
    $this->SetQuestionDetails();
  }

  private function SetQuestionDetails() {
    $conn = getDBConnection();

    $query = "SELECT " . FRAGE_FrID . ", " . FRAGE_FrTyp . ", " . FRAGE_FrText . " FROM " . FRAGE . " WHERE " . FRAGE_FrBezeichnung . " = '$this->name' ORDER BY " . FRAGE_FrID;
    $details = mysqli_fetch_assoc(mysqli_query($conn, $query));

    $this->id = $details[FRAGE_FrID];
    $this->type = $details[FRAGE_FrTyp];
    $this->text = $details[FRAGE_FrText];

    //echo "<br />ID: " . $this->id;
    //echo "<br />Typ: " . $this->type;
    //echo "<br />Text: " . $this->text;

    mysqli_close($conn);
  }

  public function GetQuesionAnswers() {
    $conn = getDBConnection();

    $answers = array();

    $query = "SELECT " . ANTWORT_AWTEXT . " FROM " . ANTWORT . " WHERE " . ANTWORT_FrID . " = $this->id";
    $result = mysqli_query($conn,$query);
    while($entry = mysqli_fetch_assoc($result))
    {
      $answers[] = $entry[ANTWORT_AWTEXT];
    }

    mysqli_close($conn);
    return $answers;
  }

  public function GetName() {
    return $this->name;
  }

  public function GetText() {
    return $this->text;
  }

  public function GetType() {
    return $this->type;
  }
}

?>
