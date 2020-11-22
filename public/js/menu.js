var menuStatus = 0;
var problems = 0;

var problemEntryTemplate = "<section class=\"problemEntry\" id=\"pK\">\
<header>\
<div>Задатак K</div>\
<div style=\"margin-left: auto\"></div>\
<div class=\"button smallButton\" onclick=\"renderProblem(K,true)\">Прегледај</div>\
<div class=\"button smallButton\" onclick=\"deleteProblemEntry(K)\">Обриши</div>\
</header>\
<div id=\"problemDivK\"></div>\
<textarea id=\"problemEntryK\" name=\"problems[]\" rows=\"5\" placeholder=\"Текст задатка\"></textarea>\
<div class=\"formRow\">\
<label class=\"formRowElement\">Поена:</label>\
<input type=\"number\" name=\"points[]\" style=\"-webkit-appearance: none; -moz-appearance: textfield;\">\
</div>\
</section>";

function swichMenu() {
	var items = document.getElementsByClassName("menuItem");

	if (menuStatus == 1) {
		for (var i = 1; i < items.length; i++) {
			items[i].removeAttribute("style");
		}
		document.getElementById("menuSwitch").style.backgroundColor = "transparent";
		menuStatus = 0;
	} else {
		for (var i = 1; i < items.length; i++) {
			items[i].style.display = "inline-block";
		}
		document.getElementById("menuSwitch").style.backgroundColor = "var(--color-blue-2)";
		menuStatus = 1;
	}
}

function setControlPanel(panel) {
	for (let i = 0; i < 3; i++) {
		if (i == panel) {
			document.getElementById('controlPanelItem' + i).style.display = "block";
		} else {
			document.getElementById('controlPanelItem' + i).removeAttribute("style");
		}
	}
}

function confirmDelete(url) {
	if (confirm('Да ли сте сигурни да желите да обришете овај рок?')) {
		window.location.href = url;
	} else {
		console.log('Rok nije obrisan.');
	}
}

function newProblemEntry() {
	var template = createElementFromHTML(problemEntryTemplate.replace(/K/g, "" + (problems + 1)));
	document.getElementById('form').insertBefore(template, document.getElementById('insertProblemEntry'));
	problems++;
}

function deleteProblemEntry(i) {
	if (confirm('Да ли сте сигурни да желите да обришете овај задатак?')) {
		document.getElementById('p' + i).remove();
		relabel();
		problems--;
	} 
}

function createElementFromHTML(htmlString) {
	var div = document.createElement('div');
	div.innerHTML = htmlString.trim();
	return div.firstChild; 
}

function relabel(){
	var elements = document.getElementsByClassName('problemEntry');

	for (let i = 0; i < elements.length; i++) {
		var children = elements[i].children;
		children[0].children[0].innerHTML = "Задатак " + (i + 1);
		renderProblem(parseInt(elements[i].id.slice(1)), false);
		children[0].children[2].onclick = () => { renderProblem(i + 1, true); };
		children[0].children[3].onclick = () => { deleteProblemEntry(i + 1); };
		children[1].id = "problemDiv" + (i + 1);
		children[2].id = "problemEntry" + (i + 1);
		elements[i].id = "p" + (i + 1);
	}
}

function renderProblem(i, render){
	if (render) {
		document.getElementById('problemDiv' + i).style.display = "block";
		document.getElementById('problemEntry' + i).style.display = "none";
		document.getElementById('problemDiv' + i).innerHTML = document.getElementById('problemEntry' + i).value;
		document.getElementById('p' + i).children[0].children[2].innerHTML = "Измени";
		document.getElementById('p' + i).children[0].children[2].onclick = () => {renderProblem(i, false);}
		renderMathInElement(document.getElementById('problemDiv' + i), {throwOnError: false});
	} else {
		document.getElementById('problemDiv' + i).style.display = "none";
		document.getElementById('problemEntry' + i).style.display = "block";
		document.getElementById('p' + i).children[0].children[2].innerHTML = "Прегледај";
		document.getElementById('p' + i).children[0].children[2].onclick = () => {renderProblem(i, true);}
	}
}

function createProblems(data) {
	for (let i = 0; i < data.length; i++) {
		var template = createElementFromHTML(problemEntryTemplate.replace(/K/g, "" + (i + 1)));
		document.getElementById('form').insertBefore(template, document.getElementById('insertProblemEntry'));
		var pi = document.getElementById('p' + (i + 1));
		pi.children[2].value = data[i].text;
		pi.children[3].children[1].value = data[i].points;
	}
}