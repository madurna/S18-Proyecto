var campos = 1;

function agregarCampo(){
	var hidden_ids = document.getElementById("hidden_ids").value;
	var hidden_valores = document.getElementById("hidden_valores").value;
	var hidden_cantidad_tipo_adjuntos = document.getElementById("hidden_cantidad_tipo_adjuntos").value;
	var cantidad = parseFloat(hidden_cantidad_tipo_adjuntos) + parseFloat(1);
	
	var arreglo_ids = hidden_ids.split("-");
	var arreglo_valores = hidden_valores.split("-");
	select = '';
	for (var i=1;i<cantidad;i++) {
		select = select + "<option value=" + arreglo_ids[i] + ">" + arreglo_valores[i] + "</option>";
	}
	
	campos = campos + 1;
	var NvoCampo= document.createElement("div");
	NvoCampo.id= "divcampo_"+(campos);
	NvoCampo.innerHTML= 
		"<table>" +
		"   <tr>" +
		"		<td style='border:0' >" +
		"			<div style='padding:0.2em ; background:white'><strong><u></u></strong></div>" +
		"			<div style='padding:0.5em ; background:lightgray'><strong><u>Nuevo Adjunto</u></strong></div>" +
		"			<div style='padding:0.1em ; background:white'><strong><u></u></strong></div>" +
		"     		<select name='tipo_adjunto_" + campos + "' id='tipo_adjunto_" + campos + "'>" + select + 
		"		</td>" +
		"   </tr>" +
		"   <tr>" +
		"		<td style='border:0'>" +
		"			<div style='border:10; padding:0.3em ; background:white'></div>" +		
		"     		<input type='file' size='50' name='adjunto_" + campos + "' id='adjunto_" + campos + "'>" +
		"     		<a href='JavaScript:quitarCampo(" + campos +");'>Quitar</a>" +
		"		</td>" +
		"   </tr>" +
		"   <tr>" +
		"		<td style='border:0'>" +
		"			<div style='padding:0.3em ; background:white'></div>" +		
		"			<strong><u>Descripci&oacute;n del Adjunto</u></strong><br>" +
		"			<textarea cols='45' rows='3'name='descripcion_" + campos + "' id='descripcion_" + campos + "'></textarea>" +
		"		</td>" +
		"   </tr>" +	
		"</table>";
	var contenedor= document.getElementById("contenedor");
    contenedor.appendChild(NvoCampo);
    /*
    var NvoCampo_select = document.createElement("div");
    NvoCampo_select.id= "divcampo_select_"+(campos);
    NvoCampo_select.innerHTML= 
		"<table>" +
		"   <tr>" +
		"     <select name='tipo_adjunto_" + campos + "' id='tipo_adjunto_" + campos + "'>" + select + 
		"   </tr>" +
		"</table>";
	var contenedor_select = document.getElementById("contenedor_select");
	contenedor_select.appendChild(NvoCampo_select);
	*/
	
	document.getElementById("hidden_cantidad_adjuntos").value = parseFloat(document.getElementById("hidden_cantidad_adjuntos").value) + parseFloat(1)
}


function quitarCampo(iddiv){
  var eliminar = document.getElementById("divcampo_" + iddiv);
  var contenedor= document.getElementById("contenedor");
  contenedor.removeChild(eliminar);
}

function limpiar(){
	var contenedor = document.getElementById("adjunto_1");
	contenedor.value = "";
}
