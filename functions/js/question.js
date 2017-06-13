function addAnswerContainer() {
    div = document.getElementById("questionMCAnswerContainer");

	  div.innerHTML = div.innerHTML + '<div>'
    +  'Lösungstext: <input type="text" size="80" name="txtAnswers[]" class="txtAnswerMC" required="required" /> '
    +  '<label><input type="checkbox" name="cbAnswerCorrect[]" onchange="toggleTextBox(this)"/>Antwort korrekt</label> '
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

    // Required-Felder umschalten
    document.getElementById('txtQuestionTitleMC').removeAttribute("required");
    document.getElementById('txtQuestionTextMC').removeAttribute("required");

    var elements = document.getElementsByClassName('txtAnswerMC');
    for (var i=0;i<elements.length; i++) {
      elements[i].removeAttribute("required");
    }

    document.getElementById('txtQuestionTitle').setAttribute("required", "required");
    document.getElementById('txtQuestionText').setAttribute("required", "required");
    document.getElementById('txtAnswer').setAttribute("required", "required");

	} else {
		document.getElementById('questionMCContainer').style.display = "block";
		document.getElementById('questionTextContainer').style.display = "none";

    // Required-Felder umschalten
    document.getElementById('txtQuestionTitleMC').setAttribute("required", "required");
    document.getElementById('txtQuestionTextMC').setAttribute("required", "required");

    var elements = document.getElementsByClassName('txtAnswerMC');
    for (var i=0;i<elements.length; i++) {
      elements[i].setAttribute("required","required");
    }

    document.getElementById('txtQuestionTitle').removeAttribute("required");
    document.getElementById('txtQuestionText').removeAttribute("required");
    document.getElementById('txtAnswer').removeAttribute("required");
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
