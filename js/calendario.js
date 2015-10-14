
function trim(str) {
	return str.replace(/^\s*|\s*$/g,"");
}

jQuery(function($){
	$.datepicker.regional["es"] = {
		closeText: "Cerrar",
		prevText: "&#x3c;Ant",
		nextText: "Sig&#x3e;",
		currentText: "Hoy",
		monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
		"Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
		monthNamesShort: ["Ene","Feb","Mar","Abr","May","Jun",
		"Jul","Ago","Sep","Oct","Nov","Dic"],
		dayNames: ["Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado"],
		dayNamesShort: ["Dom","Lun","Mar","Mi&eacute;","Juv","Vie","S&aacute;b"],
		dayNamesMin: ["Do","Lu","Ma","Mi","Ju","Vi","S&aacute;"],
		weekHeader: "Sm",
		dateFormat: "dd-mm-yy",
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: "",
		changeMonth: true,
		changeYear: true,
		yearRange:"2015:+1",
		showOn: "button",
		buttonImageOnly: true,
		buttonImage: "../img/spirit20_icons/calendar.png"
		};

		$.datepicker.setDefaults($.datepicker.regional["es"]);
	});

$(document).ready(function() {
	$(".datepicker").datepicker();
});

$(document).ready(function(){

	$("[id*=verDet]").click(function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		id = id.replace("verDet", "");
		$("#det"+id).show(1500);
		$("#linkVerDet"+id).hide();
		$("#linkOcultarDet"+id).show();
	});

	$("[id*=ocultarDet]").click(function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		id = id.replace("ocultarDet", "");
		$("#det"+id).hide(1500);
		$("#linkVerDet"+id).show();
		$("#linkOcultarDet"+id).hide();
	});

});