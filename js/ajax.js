// based on http://rajshekhar.net/blog/archives/85-Rasmus-30-second-AJAX-Tutorial.html
function createXMLHttpRequest() {
	var ua;
	if(window.XMLHttpRequest) {
		try {
			ua = new XMLHttpRequest();
		} catch(e) {
			ua = false;
		}
	} else if(window.ActiveXObject) {
		try {
			ua = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e) {
			ua = false;
		}
	}
	return ua;
}
var req = createXMLHttpRequest();
function sendRequest(id,params) {
	if(params) params = '&'+params; else var params = '';
	req.open('get', tikiRootUrl+'themes/ajax.php?ajaxid='+id+params);
	req.onreadystatechange = handleResponse;
	req.send(null);
}
function handleResponse() {
	if(req.readyState == 4){
		var response = req.responseText;
		var update = new Array();

		if(response.indexOf('||' != -1)) {
			update = response.split('||');
			document.getElementById(update[0]).innerHTML = update[1];
		}
	}
}