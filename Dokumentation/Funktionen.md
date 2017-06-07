# Funktionen

* ./admin/adminFunctions.inc.php:
  * addAnswerContainer()
  * deleteAnswerContainer(item)
  * toggleQuestionType(rbutton)
  * toggleTextBox(item)

* ./functions/adminFunctions/functions-admin.inc.php:
  * changePassword($oldPassword, $newPassword, $newPasswordConfirmed)
  
* ./functions/adminFunctions/functions-chapter.inc.php:
  * getChapterId($lectureDescription, $chapterDescription)
  * getAllChaptersOfLecture($lectureDescription)
  * addLectureChapter($lectureDescription, $chapterDescription)

* ./functions/adminFunctions/functions-class.inc.php:
  * toggleClassRegistration($classID, $regStatus)
  * createClass($kDescription, $kShort)
  * deleteClass($classID)

* ./functions/adminFunctions/functions-lecture.inc.php:getAllLectures()
  * createLecture($description)
  * renameLecture($lectureDescriptionOld, $lectureDescriptionNew)
  * deleteLecture($lectureDescription)
  
* ./functions/adminFunctions/functions-menu.inc.php
  * printAdminMenu($current)
  * printAdminMenuBottom()
  
* ./functions/adminFunctions/functions-question.inc.php:
  * deleteQuestion($chapterID,$questionText)
  * getAllQuestionsOfChapter($lectureDescription,$chapterDescription, $returnOptionTags = true)
  * getAllQuestions($chapterID, $unusedOnly = false)
  * getAllQuestionsOfChapterArray($chapterID)
  * addQuestionContainer()
  * saveQuestion($questionType)
  * getQuestionPoolId($chapterID)

* ./functions/adminFunctions/functions-survey.inc.php
  * fbExisting($fb)
  * createFb($fb, $lecture, $chapter)
  * saveQuestionToFb($fb, $question)
  * deleteSurveyQuestions($fb)
  * saveQuestionToFbV2($fb, $question)
  * getAllSurveys()
  * deleteSurvey($surveyName)
  * getSurveyID($surveyName)
  * enableSurvey($survey, $class)
  * getEnabledSurveys()
  * getSurveyChapterID($survey)
  * getSurveyQuestions($survey)
  * getSubmittedStudents($surveyID, $classID)
  * getTotalStudents($surveyID, $classID)
  * GetAmountOfVotes($questionName, $surveyName)
  
* ./functions/db.inc.php:
  * getDBConnection()
  
* ./functions/js/chartFunctions.js
  * DrawChart(canvasID, remoteFields, remoteData, remoteColors, remoteBorderColors)

* ./functions/logout.inc.php:
  * logoutAdmin()
  
* ./functions/mixed.inc.php:
  * getAllClasses($subsetOnly = false, $subsetIndicator = -1)
  * getAllClassesArray()
  * GetClassSurveys($class)
  * getAllRegEnabledClasses()
  * getClassIdFromCbString($cbString)
  
* ./functions/studentFunctions/functions-class.inc.php:  
  * GetClassFromStudent($username)
  
* ./functions/studentFunctions/functions-info.inc.php:
  * GetInfotext()
  
* ./functions/studentFunctions/functions-login.inc.php:
  * registerStudent($username, $class)
  * ValidateUsername($username)
  * SetSessionUsername($username)
  * GetSessionUsername()
  * printClassTitle()
  * printSidebarMenuBegin($entry)
  * printSidebarMenuEnd()
  
* ./functions/studentFunctions/functions-survey.inc.php:
  * GetNewSurveys($class)
  * GetEditedSurveys($class)
  * GetCompletedSurveys($student)
  * ValidateUserSurveyEdit($student,$survey)
  * getSurveyID($surveyName)
  * EditSurvey()
  * GetOwnSolution($surveyID, $questionID, $studName)
  * GetTextQuestionSolution($questionID)
  * GetMCQuestionAnswer($fbID, $questionID, $answerID)
  
* ./functions/studentFunctions/survey.php
  * public __construct($fbName)
  * private SetSurveyQuestions()
  * public GetQuestions()
  * public GetQuestionCount()
  * public GetSurveyName()
  * public GetQuestionAt($index)
  * public GetID()
  * public __construct($name)
  * private SetQuestionDetails()
  * public GetQuestionAnswers()
  * public GetQuestionAnswersWithTruths()
  * public GetAnswerText($awid)
  * public GetName()
  * public GetText()
  * public GetType()
  * public GetID()