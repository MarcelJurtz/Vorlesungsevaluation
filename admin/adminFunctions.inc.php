<script>
function addAnswerContainer() {
    div = document.getElementById("questionMCAnswerContainer");

	  div.innerHTML = div.innerHTML + '<div>'
    +  'Lösungstext: <input type="text" size="80" name="txtAnswers[]" />'
    +  '<label><input type="checkbox" name="cbAnswerCorrect[]" onchange="toggleTextBox(this)"/>Antwort korrekt</label>'
    +  '<input type="button" name="cmdDeleteAnswer" value="Antwort löschen" onClick="deleteAnswerContainer(this)"/>'
    +  '<input class="hid" type="hidden" name="txtTrueFalse[]" value="false" />'
    +  '<br />'
    +  '</div>';
}

function deleteAnswerContainer(item) {
	item.parentElement.parentElement.removeChild(item.parentElement);
}

function toggleQuestionType(rbutton) {
	if(rbutton.value == 'text') {
		// Textfragen-Infos anzeigen
		document.getElementById('questionMCContainer').style.display = "none";
		document.getElementById('questionTextContainer').style.display = "block";
	} else {
		document.getElementById('questionMCContainer').style.display = "block";
		document.getElementById('questionTextContainer').style.display = "none";
	}
}

function toggleTextBox(item) {
  var status = item.parentElement.parentElement.getElementsByClassName("hid")[0].value;

  if(status == "false") {
    status = "true";
  } else {
    status = "false";
  }

  item.parentElement.parentElement.getElementsByClassName("hid")[0].value = status;
}

</script>
<?php
  // Includes
  include "../functions/adminFunctions/functions-admin.inc.php";
  include "../functions/adminFunctions/functions-chapter.inc.php";
  include "../functions/adminFunctions/functions-class.inc.php";
  include "../functions/adminFunctions/functions-lecture.inc.php";
  include "../functions/adminFunctions/functions-question.inc.php";
  include "../functions/adminFunctions/functions-survey.inc.php";
  
  include "../functions/db.inc.php";
  include "../functions/logout.inc.php";
  
  include "../functions/mixed.inc.php";
  
  require_once("../functions/constants.inc.php");
?>
