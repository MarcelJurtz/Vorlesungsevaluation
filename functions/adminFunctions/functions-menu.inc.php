<?php
  function printAdminMenu($current) {
    $overview = '<a href="admin.php">'.MENU_OVERVIEW.'</a>';

    $classCreate = '<a href="class_create.php">'.MENU_CLASS_CREATE.'</a>';
    $classDelete = '<a href="class_delete.php">'.MENU_CLASS_DELETE.'</a>';
    $classEnable = '<a href="class_enable.php">'.MENU_CLASS_ENABLE.'</a>';

    $questionCreate = '<a href="question_create.php">'.MENU_QUESTION_CREATE.'</a>';
    $questionDelete = '<a href="question_delete.php">'.MENU_QUESTION_DELETE.'</a>';
    $questionModify = '<a href="question_modify.php">'.MENU_QUESTION_MODIFY.'</a>';

    $surveyCreate = '<a href="survey_create.php">'.MENU_SURVEY_CREATE.'</a>';
    $surveyDelete = '<a href="survey_delete.php">'.MENU_SURVEY_DELETE.'</a>';
    $surveyModify = '<a href="survey_modify.php">'.MENU_SURVEY_MODIFY.'</a>';
    $surveyEnable = '<a href="survey_enable.php">'.MENU_SURVEY_ENABLE.'</a>';

    $lectureCreate = '<a href="lecture_create.php">'.MENU_LECTURE_CREATE.'</a>';
    $lectureDelete = '<a href="lecture_delete.php">'.MENU_LECTURE_DELETE.'</a>';
    $lectureEnable = '<a href="lecture_modify.php">'.MENU_LECTURE_MODIFY.'</a>';

    $statistics = '<a href="statistics.php">'.MENU_STATISTICS.'</a>';

    $settings = '<a href="settings.php">'.MENU_SETTINGS.'</a>';

    $logout = '<a href="../logout.php">'.MENU_LOGOUT.'</a>';

    switch($current) {
      case MENU_OVERVIEW:
        $overview = '<b>'.MENU_OVERVIEW.'</b>';
        break;
      case MENU_CLASS_CREATE:
        $classCreate = '<b>'.MENU_CLASS_CREATE.'</b>';
        break;
      case MENU_CLASS_DELETE:
        $classDelete = '<b>'.MENU_CLASS_DELETE.'</b>';
        break;
      case MENU_CLASS_ENABLE:
        $classEnable = '<b>'.MENU_CLASS_ENABLE.'</b>';
        break;
      case MENU_QUESTION_CREATE:
        $questionCreate = '<b>'.MENU_QUESTION_CREATE.'</b>';
        break;
      case MENU_QUESTION_DELETE:
        $questionDelete = '<b>'.MENU_QUESTION_DELETE.'</b>';
        break;
      case MENU_QUESTION_MODIFY:
        $questionModify = '<b>'.MENU_QUESTION_MODIFY.'</b>';
        break;
      case MENU_SURVEY_CREATE:
        $surveyCreate = '<b>'.MENU_SURVEY_CREATE.'</b>';
        break;
      case MENU_SURVEY_DELETE:
        $surveyDelete = '<b>'.MENU_SURVEY_DELETE.'</b>';
        break;
      case MENU_SURVEY_MODIFY:
        $surveyModify = '<b>'.MENU_SURVEY_MODIFY.'</b>';
        break;
      case MENU_SURVEY_ENABLE:
        $surveyEnable = '<b>'.MENU_SURVEY_ENABLE.'</b>';
        break;
      case MENU_LECTURE_CREATE:
        $lectureCreate = '<b>'.MENU_LECTURE_CREATE.'</b>';
        break;
      case MENU_LECTURE_DELETE:
        $lectureDelete = '<b>'.MENU_LECTURE_DELETE.'</b>';
        break;
      case MENU_LECTURE_MODIFY:
        $lectureEnable = '<b>'.MENU_LECTURE_MODIFY.'</b>';
        break;
      case MENU_STATISTICS:
        $statistics = '<b>'.MENU_STATISTICS.'</b>';
        break;
      case MENU_SETTINGS:
        $settings = '<b>'.MENU_SETTINGS.'</b>';
        break;
      case MENU_LOGOUT:
        $logout = '<b>'.MENU_LOGOUT.'</b>';
        break;
      default:
        break;
    }

    echo'<div id="cWrapper">';
  	echo'<div id="cMenu">';
    echo '<ul id="lMenu">';
      echo '<li>'.$overview.'</li>';
      echo 'Kurse<ul>';
        echo '<li>'.$classCreate.'</li>';
        echo '<li>'.$classDelete.'</li>';
        echo '<li>'.$classEnable.'</li>';
        echo '</ul>';
      echo 'Fragen<ul>';
        echo '<li>'.$questionCreate.'</li>';
        echo '<li>'.$questionDelete.'</li>';
        echo '<li>'.$questionModify.'</li>';
        echo '</ul>';
      echo 'Fragebögen<ul>';
        echo '<li>'.$surveyCreate.'</li>';
        echo '<li>'.$surveyDelete.'</li>';
        echo '<li>'.$surveyModify.'</li>';
        echo '<li>'.$surveyEnable.'</li>';
        echo '</ul>';
      echo 'Vorlesungen<ul>';
        echo '<li>'.$lectureCreate.'</li>';
        echo '<li>'.$lectureDelete.'</li>';
        echo '<li>'.$lectureEnable.'</li>';
        echo '</ul>';
      echo '<li>'.$statistics.'</li>';
      echo '<li>'.$settings.'</li>';
      echo '<li>'.$logout.'</li>';
    echo '</ul>';
    echo'</div>';
    echo'<div id="cFrame">';
    /* Content */
  }

  function printAdminMenuBottom() {
    echo'</div>';
  	echo'<br class="clear" />';
  	echo'</div>';
  }
?>
