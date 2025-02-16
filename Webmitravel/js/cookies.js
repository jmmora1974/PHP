
function validarCookies() {
	var checkboxgalleta = document.getElementById('chkgalleta');
	if (!checkboxgalleta.checked) {
		alert('Debes aceptar los términos y condiciones.');
		document.getElementById("btngalleta").disabled = true;
		return false;
	}
	document.getElementById("btngalleta").disabled = false;
	

	return true;
}