
function delentry(id) {
	// submit deletion request to database
	xhReq =createXMLHttpRequest();
	var url = "delentry.php?taskid="+id;
	xhReq.open("get", url, true);
	xhReq.onreadystatechange = function () {
		if (xhReq.readyState != 4) {return;}
		var serverResponse = xhReq.responseText;
		if (serverResponse) {
		// hide the row in the table
			var obj = document.getElementById("entrytag"+id);
//			var tbody = document.getElementById("tbodytag");
			obj.style.display = 'none';
			obj.parentElement.removeChild(obj);
		}
	}
	xhReq.send(null);
	
}

function delrunning(id) {

}

function download(id) {
	location.href = "download.php?resid=" + id;
	return
}

function updateprogress(id) {

	// submit task progress request to database
	xhReq =createXMLHttpRequest();
	var url = "progress.php?taskid="+id;
	xhReq.open("get", url, true);
	xhReq.onreadystatechange = function () {
		if (xhReq.readyState != 4) {return;}
		var serverResponse = xhReq.responseText;
		if (serverResponse && serverResponse != "") {
		// hide the row in the table
		    if (serverResponse[0] == "%") {
			window.location.reload();
		    } else {
			document.getElementById("bid" + id).innerHTML = serverResponse + "% complete";
//			setTimeout("updateprogress(" + id + ");", 60000);
		    }
		}
	}
	xhReq.send(null);
}
