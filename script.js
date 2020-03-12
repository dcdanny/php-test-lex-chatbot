function ajaxReq(url, callback) {
	console.log("Request: " + url);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && (this.status == 200 || this.status == 500) ){
			callback(this.responseText, this.status);
		}
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}

function runCommand(command, botName, arg1, arg2) {
	console.log("Run command: " + command);
	var extraArgs = "";
	if (botName) {
		extraArgs += "&botName=" + botName;
	}
	if (arg1) {
		extraArgs += "&arg1=" + arg1;
	}
	if (arg2) {
		extraArgs += "&arg2=" + arg2;
	}
	var requestUrl = "lexSDKTest.php?runFunction=" + command + extraArgs;
	ajaxReq(requestUrl, dispResult);

}

function dispResult(content, status) {
	var errorEle = document.getElementById("results-error");
	document.getElementById("results").innerText = content;
	if(status != 200){
		errorEle.innerText = "HTTP Error: " + status;
	} else {
		errorEle.innerText = "";
	}
}

function submit() {
	runCommand(
		document.getElementById("commandInput").value,
		document.getElementById("botNameInput").value,
		document.getElementById("arg1Input").value,
		document.getElementById("arg2Input").value
	);
}

function setValue(id,value){
	document.getElementById(id).value = value;
}
function clearValues(){
	setValue('commandInput','');
	setValue('botNameInput','');
	setValue('arg1Input','');
	setValue('arg2Input', '');
}