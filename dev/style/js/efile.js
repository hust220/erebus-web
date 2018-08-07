//upload_target is the name of the iframe
function inituplform() {
//    document.forms['querysub'].onsubmit=function() {
//	return deftaskname(true,false);
//    }
    document.getElementById("subInnerTableBody").addEventListener("mouseover", atomtablein , false);
//    document.getElementById("subInnerTableBody").addEventListener("mouseout", atomtableout , false);
}

function onsubquerychange(obj) {
//    obj.form.target = 'sub_upload_target';
    if (obj.value == "") return;
    document.getElementById("uploadIndicator").style.visibility = "visible";
//    var handler = obj.form.filename.onchange;
//    obj.form.filename.onchange = null;
//    obj.form.query.onchange = null;
    obj.form.querymod.value = "";
//    obj.form.filename.value = "";
//    obj.form.filename.onchange = handler;
//    obj.form.query.onchange = handler;
    obj.form.target = 'sub_upload_target';
    obj.form.submit();
}

function uploadcomplete(obj) {
    document.getElementById("uploadIndicator").style.visibility = "hidden";
//    var text = document.getElementById('querytext');
//    var text = document.querysub.query;
    var tblbody = document.getElementById('subInnerTableBody');
    var frame = window.frames["sub_upload_target"];
    var src = frame.document.getElementById("subInnerTableBody");
    if (src) {
	tblbody.innerHTML = src.innerHTML;
//	text.value = "";
	frame.document.write("");
	document.getElementById("subformerrorline").innerHTML = "";
	document.forms['querysub'].target = "";
    } else {
	src = frame.document.getElementById("error");
	if (src) document.getElementById("subformerrorline").innerHTML = src.innerHTML;
    }
}

function queryformsubmit() {
    var querymod = document.getElementById('querymod');
    var tblbody = document.getElementById('subInnerTableBody');
    querymod.value = tblbody.innerHTML;
}

function reslistchange(obj, c) {
    obj.onchange = null;
    obj.onblur = null;
    var cell = obj.parentNode;
    if (c) cell.innerHTML = obj.options[obj.selectedIndex].text;
    else cell.innerHTML = cell.title;
    cell.title = "";
}

function atomtableout(evt)
{
    var obj = evt.target;
    obj.innerHTML = obj.title;
    obj.title = "";
}

function atomtablein(evt)
{
    var cell = evt.target;
    var s = cell.tagName;
    var alist = [ "ANY", "ALA", "ARG", "ASN", "ASP", "CYS", "GLN", "GLU", "GLY", "HIS", "ILE", "LEU", "LYS", "MET", "PHE", "PRO", "SER", "THR", "TRP", "TYR", "VAL" ];
        
    if (s == "TD") {
	if (cell.className == 'iresname' && cell.firstChild.tagName != 'SELECT') {
	    var text = cell.innerHTML;
	    var selindex = -1;
	    var str = "";
	    for (a in alist) {
	        if (text == alist[a]) selindex = a;
	        str += "<option>" + alist[a] + "</option>";
	    }
	    if (selindex < 0) { str = "<option>" + text + "</option>" + str; selindex = 0; }
	    str = '<select size=1 onchange="reslistchange(this, 1);" onblur="reslistchange(this, 0);" style="width:' + (cell.clientWidth-8) + 'px;height:' + cell.clientHeight + 'px;">' + str;
	    str += "</select>"
	    cell.title = cell.innerHTML;
	    cell.innerHTML = str;
	    cell.firstChild.focus();
	    cell.firstChild.selectedIndex = selindex;
	}
    }
}

function deftaskname(focus,def) {
    var v=document.getElementById('taskname');
    var ret = true;
    if (v.value.length==0||v.value==null||v.value.search(/^\s{1,}$/g)>-1) {
	var d=new Date();
	var x=d.getMonth() + 1;
	var mon = (x < 10) ? '0' + x : x;
	x = d.getDate();
	var day = (x < 10) ? '0' + x : x;
	x = d.getHours() + 1;
	var hour = (x < 10) ? '0' + x : x;
	x = d.getMinutes() + 1;
	var min = (x < 10) ? '0' + x : x;
	x = d.getSeconds() + 1;
	var sec = (x < 10) ? '0' + x : x;
	var str = "My task " + d.getFullYear() + "/" + mon + "/" + day + " " + hour + ":" + min + ":" + sec;
	if (def) v.defaultValue=str; else v.value=str; 
	ret = false;
    }
    if (focus) v.focus();
    return ret;
}
