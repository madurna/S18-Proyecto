$(document).ready(function(){
	var dialogo = $("#dialog");			
	$(dialogo).dialog({ 	
		"autoOpen": false,
		"title": "",
		"modal": true,
		"position": "center", 
		"width": 400, 
		"height": 200, 
		"show": "fade",
		"draggable": false
	});	
	cargarDialogo();	
});
function modificarPeriodo()  {
	var dialogo = $("#dialog");
	cargarDialogo();
	$(dialogo).dialog("open");	
}
function cargarDialogo() {
	var dialogo = $("#dialog");
	$(dialogo).html("Cargando...");	
	$(dialogo).load('modificar_periodo.php',
		function() {
			var options = { 
				beforeSubmit:  showRequestPeriodo,  // pre-submit callback 
				success:       showResponsePeriodo  // post-submit callback 
			}
			$("#frmPer").ajaxForm(options);			
		}
	);	
}

function showRequestPeriodo(formData, jqForm, options) { 
	$("#cont_frmPeriodo").html("Guardando datos formulario");
} 	

function showResponsePeriodo(responseText, statusText, xhr, $form)  {
    var d = new Date(); now = d.getTime();		
	cargarDialogo();	
}

function cerrarDialogo() {
	var dialogo = $("#dialog");
	$(dialogo).dialog("close");
	$(dialogo).html("");
}