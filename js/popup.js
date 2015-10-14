messageObj = new DHTML_modalMessage();		
function mostrarDialogo(url) {
	aleat = Math.random() * 1000;
	aleat = Math.round(aleat);
	messageObj.setSource(url+"&uid="+aleat);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(700,450);
	messageObj.setShadowDivVisible(true);	// Enable shadow for these boxes
	messageObj.display();
}

function cerrarDialogo() {
	messageObj.close();
}