function showRequestImportacion(formData, jqForm, options) { 
	$("#dialogo-importacion").html("Guardando...");
} 				
function showResponseImportacion(responseText, statusText, xhr, $form)  {
	var val = $($form).children(':hidden').children('#tipoarch_id').val();
	guardarDatosURL("config_archivo.php?marca="+ now +"&id="+val,responseText);			
} 

function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			alert(item);
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	
	return dumped_text;
}

function abrirFormSwap(tap_id,col_id) {
	var dialogo = $("#colcamp_msg");				
	cargarFormSwap(tap_id,col_id);
	$(dialogo).dialog("open");
}
function cerrarFormSwap() {
	var dialogo = $("#colcamp_msg");				
	$(dialogo).html("");
	$(dialogo).dialog("close");
}
function cargarFormSwap(tap_id,col_id) {
	var dialogo = $("#colcamp_msg");				
	$(dialogo).html("");
	var d = new Date(); now = d.getTime();			
	$(dialogo).load("swap_col.php?marca="+ now + "&tipo="+tap_id+"&col="+col_id);			
}