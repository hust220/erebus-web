function htesc(str)
{
    if (str) return str.split("&").join("&amp;").split( "<").join("&lt;").split(">").join("&gt;").substr(0,100);
    else return "";
}

function info_show(evt)
{
//    var elem = evt.target.parentNode.getElementsByTagName('span');
    var elem = this.getElementsByTagName('span');
    var info = "";
//    var dbg = "<strong>Target:</strong><br>" + htesc(evt.target.outerHTML);
//    dbg += "<br><strong>This:</strong><br>" + htesc(this.outerHTML);
//    dbg += "<br><strong>Target parent:</strong><br>" + htesc(evt.target.parentNode.outerHTML);
    for (var i = 0; i < elem.length; i++) {
//	if (elem[i].className == "info") dbg += "<br><strong>SP" + i + ":</strong> " + htesc(elem[i].parentNode.outerHTML);
	if ((elem[i].parentNode == evt.target.parentNode || elem[i].parentNode == this ) && elem[i].className == "info") {
	    info = elem[i].innerHTML;
	    if (info[0] == '#') {
		var src = document.getElementById(info.substr(1));
		if (src) info = src.innerHTML;
	    }
//	    dbg += "<br><strong>Source:</strong><br>" + htesc(elem[i].outerHTML);
//	    dbg += "<br><strong>Source parent:</strong><br>" + htesc(elem[i].parentNode.outerHTML);
	    break;
	}
    }
    if (info != "") document.getElementById("infotext").innerHTML = info;
//    document.getElementById("infodebug").innerHTML = dbg;
}

function info_hide()
{
    document.getElementById("infotext").innerHTML = document.getElementById("definfotext").innerHTML;
//    document.getElementById("infodebug").innerHTML = "";
}

var cl = "info";
var myclass = new RegExp('\\b'+cl+'\\b');
var elem = document.getElementsByTagName('span');
for (var i = 0; i < elem.length; i++) {
    var classes = elem[i].className;
//    if (myclass.test(classes)) {
    if (classes == "info") {
	if (elem[i].parentNode.addEventListener) {
	    elem[i].parentNode.addEventListener("mouseover", info_show , true);
	    elem[i].parentNode.addEventListener("mouseout", info_hide , false);
	} else if (elem[i].parentNode.attachEvent) {
	    elem[i].parentNode.attachEvent("onmouseover", info_show );
	    elem[i].parentNode.attachEvent("onmouseout", info_hide );
	}
    }
}

info_hide();
