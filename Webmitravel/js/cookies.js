
function validarCookies() {
	var checkboxgalleta = document.getElementById('chkgalleta');
	if (!checkboxgalleta.checked) {
		alert('Debes aceptar los términos y condiciones.');
		document.getElementById("btngalleta").disabled = true;
		document.cookie = "consentimiento=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
		return false;
	}
	document.getElementById("btngalleta").disabled = false;
	document.cookie ="consentimiento=true";

	return true;
}