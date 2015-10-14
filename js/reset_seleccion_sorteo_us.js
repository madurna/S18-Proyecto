function reset_seleccion_sorteo_us(tipo,contenido){
	$.ajax(
		{
		dataType: "html",
		type: "POST",

		// ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
		url: "reset_seleccion_sorteo_usuarios.php?tabla=" + tipo,

		error: function(requestData, strError, strTipoError){
			alert("Error " + strTipoError +': ' + strError); //En caso de error mostraremos un alert
			},

		//fin de la llamada ajax.
		complete: function(requestData, exito){
			// En caso de usar una gif (cargando...) aqui quitas la imagen
                $("#contenido p").html("<img src='../img/ajax-loader.gif'>");
                $("#contenido p").load("contenidous.php?marca="+ now + "&tabla=" + contenido +"&popup=1",function(){
                    $("#cargando").css("display", "none");
                });
			}
		}
	);
}