# Funktionen

* ./admin/adminFunctions.inc.php:
  * function addAnswerContainer()
  * function deleteAnswerContainer(item)
  * function toggleQuestionType(rbutton)
  * function toggleTextBox(item)

* ./functions/adminFunctions/functions-admin.inc.php:
  * function changePassword($oldPassword, $newPassword, $newPasswordConfirmed)
  
* ./functions/adminFunctions/functions-chapter.inc.php:
  * function getChapterId($lectureDescription, $chapterDescription)
  * function getAllChaptersOfLecture($lectureDescription)
  * function addLectureChapter($lectureDescription, $chapterDescription)

* ./functions/adminFunctions/functions-class.inc.php:
  * function toggleClassRegistration($classID, $regStatus)
  * function createClass($kDescription, $kShort)
  * function deleteClass($classID)

* ./functions/adminFunctions/functions-lecture.inc.php:function getAllLectures()
  * function createLecture($description)
  * function renameLecture($lectureDescriptionOld, $lectureDescriptionNew)
  * function deleteLecture($lectureDescription)
  
* ./functions/adminFunctions/functions-menu.inc.php
  * function printAdminMenu($current)
  * function printAdminMenuBottom()
  
* ./functions/adminFunctions/functions-question.inc.php:
  * function deleteQuestion($chapterID,$questionText)
  * function getAllQuestionsOfChapter($lectureDescription,$chapterDescription, $returnOptionTags = true)
  * function getAllQuestions($chapterID, $unusedOnly = false)
  * function getAllQuestionsOfChapterArray($chapterID)
  * function addQuestionContainer()
  * function saveQuestion($questionType)
  * function getQuestionPoolId($chapterID)

* ./functions/adminFunctions/functions-survey.inc.php
  * function fbExisting($fb)
  * function createFb($fb, $lecture, $chapter)
  * function saveQuestionToFb($fb, $question)
  * function deleteSurveyQuestions($fb)
  * function saveQuestionToFbV2($fb, $question)
  * function getAllSurveys()
  * function deleteSurvey($surveyName)
  * function getSurveyID($surveyName)
  * function enableSurvey($survey, $class)
  * function getEnabledSurveys()
  * function getSurveyChapterID($survey)
  * function getSurveyQuestions($survey)
  * function getSubmittedStudents($surveyID, $classID)
  * function getTotalStudents($surveyID, $classID)
  * function GetAmountOfVotes($questionName, $surveyName)
  
* ./functions/db.inc.php:
  * function getDBConnection()
  
* ./functions/js/chartFunctions.js
  * function DrawChart(canvasID, remoteFields, remoteData, remoteColors, remoteBorderColors)

* ./functions/logout.inc.php:
  * function logoutAdmin()
  
* ./functions/mixed.inc.php:
  * function getAllClasses($subsetOnly = false, $subsetIndicator = -1)
  * function getAllClassesArray()
  * function GetClassSurveys($class)
  * function getAllRegEnabledClasses()
  * function getClassIdFromCbString($cbString)
  
* ./functions/studentFunctions/functions-class.inc.php:  
  * function GetClassFromStudent($username)
  
* ./functions/studentFunctions/functions-info.inc.php:
  * function GetInfotext()
  
* ./functions/studentFunctions/functions-login.inc.php:
  * function registerStudent($username, $class)
  * function ValidateUsername($username)
  * function SetSessionUsername($username)
  * function GetSessionUsername()
  * function printClassTitle()
  * function printSidebarMenuBegin($entry)
  * function printSidebarMenuEnd()
  
* ./functions/studentFunctions/functions-survey.inc.php:
  * function GetNewSurveys($class)
  * function GetEditedSurveys($class)
  * function GetCompletedSurveys($student)
  * function ValidateUserSurveyEdit($student,$survey)
  * function getSurveyID($surveyName)
  * function EditSurvey()
  * function GetOwnSolution($surveyID, $questionID, $studName)
  * function GetTextQuestionSolution($questionID)
  * function GetMCQuestionAnswer($fbID, $questionID, $answerID)
  
* ./functions/studentFunctions/survey.php
  * public function __construct($fbName)
  * private function SetSurveyQuestions()
  * public function GetQuestions()
  * public function GetQuestionCount()
  * public function GetSurveyName()
  * public function GetQuestionAt($index)
  * public function GetID()
  * public function __construct($name)
  * private function SetQuestionDetails()
  * public function GetQuestionAnswers()
  * public function GetQuestionAnswersWithTruths()
  * public function GetAnswerText($awid)
  * public function GetName()
  * public function GetText()
  * public function GetType()
  * public function GetID()