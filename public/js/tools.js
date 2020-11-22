var pasukon;
var latCyr = {"A":"А","B":"Б","C":"Ц","Č":"Ч","Ć":"Ћ","D":"Д","Đ":"ђ","E":"Е","F":"Ф","G":"Г","H":"Х","I":"И","J":"Ј","K":"К","L":"Л","M":"М","N":"Н","O":"О","P":"П","R":"Р","S":"С","Š":"Ш","T":"Т","U":"У","V":"В","Z":"З","Ž":"Ж","a":"а","b":"б","c":"ц","č":"ч","ć":"ћ","d":"д","đ":"ђ","e":"е","f":"ф","g":"г","h":"х","i":"и","j":"ј","k":"к","l":"л","m":"м","n":"н","o":"о","p":"п","r":"р","s":"с","š":"ш","t":"т","u":"у","v":"в","z":"з","ž":"ж"};

function setup (){
    pasukon = new Pasukon(grammar, {
        context: {
          latin: function (str) { return latinToCyr(str); },
          cyrl: function (str) { return str; }
        }
      });
}

function latinToCyr (str) {
    str = str
        .replace(/Lj/g, 'Љ')
        .replace(/lj/g, 'љ')
        .replace(/Nj/g, 'Њ')
        .replace(/nj/g, 'њ')
        .replace(/Dž/g, 'Џ')
        .replace(/Dž/g, 'џ');

    return str.split('').map(function (char) { 
        return latCyr[char] || char; 
      }).join("");
}

function transliterate() {
  try {
		p = pasukon.parse(document.getElementById("code").value);
	} catch (errorStr) {
		throw errorStr;
  }
    
  document.getElementById("code").value = p;
  updateResult();
}

function interpunction() {
  str = document.getElementById("code").value;
  str = str.replace(/\\\)\./g, ".\\)")
    .replace(/\\\]\./g, ".\\]")
    .replace(/\\\),/g, ",\\)")
    .replace(/[ ]+/g, " ");

  document.getElementById("code").value = str;
  updateResult();
}

function updateResult() {
    document.getElementById("result").innerHTML = document.getElementById("code").value;
    renderMathInElement(document.getElementById("result"), {throwOnError: false});
}