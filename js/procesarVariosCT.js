function procesarVariosCT(check){
	$.ajax(
		{
		dataType: "html",
		type: "POST",

		// ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
		url: "proc_sorteo_manual_varios_ct.php?check=" + check,

		error: function(requestData, strError, strTipoError){
			alert("Error " + strTipoError +': ' + strError); //En caso de error mostraremos un alert
			},

		//fin de la llamada ajax.
		complete: function(requestData, exito){
			// En caso de usar una gif (cargando...) aqui quitas la imagen
			}
		}
	);
}