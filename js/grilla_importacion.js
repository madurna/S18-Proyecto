function grillaImportacionReady() {	
	var dialogo = $("#dialogo-importacion");
	$(dialogo).dialog("destroy");
	$(dialogo).dialog({ 	
		'autoOpen': false,
		'title': "",
		'modal': true,
		'position': "center", 
		'width': '800', 
		'height': '480', 
		'show': 'fade',
		'draggable': false,
		'buttons' : [
			{text: "Guardar", click: function() { $("#frmCol").submit();}},
			{text: "Cerrar", click: function() {
				$(this).dialog("close");}
			}
		]		
	});	
	
	var dg_tr = $(".datagrid tr");
	$(dg_tr).mouseover(function() {
			$(this).addClass("over");
	});
	$(dg_tr).mouseout(function() {
		$(this).removeClass("over");
	});	
	
	$("a.contenido-grilla").click(function() {	
		var d = new Date(); now = d.getTime();
		var valor = $(this).attr('href');	
		abrirDialogoURL("config_archivo.php?marca="+ now + "&"+valor +"&popup=1");
		return false;
	});
}

function cargarDialogoURL(url) {
	var dialogo = $("#dialogo-importacion");
	$(dialogo).html("Cargando...");	
	//$(dialogo).dialog( "option", "position", [350,100] );
	$(dialogo).load(url);	
}

function abrirDialogoURL(url)  {
	var dialogo = $("#dialogo-importacion");
	cargarDialogoURL(url)
	$(dialogo).dialog("open");	
}
function guardarDatosURL(url,responseText) {
	cargarDialogoURL(url)	
}