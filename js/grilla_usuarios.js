function validarFiltroLog(info) {
    var fecha_desde = new Date($("#frmFiltro :input[name=log_desde]").val());
    var fecha_hasta = new Date($("#frmFiltro :input[name=log_hasta]").val());
    if (fecha_desde > fecha_hasta)
    	alert("Rango de fechas incorrecto");
    else
    	filterGrid(info);
} 

function filterGrid(info) 
{
	var d = new Date(); now = d.getTime();
	$("#cargando").css("display", "inline");
	url = "getContenido.php?marca="+ now +"&contenido="+info.data.contenido;
	fields = $("#frmFiltro").serialize();
	if (fields != '')
		url = url+"&"+fields;			
	cargarDatos(url);
	// Important: return false to avoid href links
	return false;
}

function updateGrid(info) 
	{
	 	var pars = "page=" + info.page;
		if (info.sort.length > 0) {
			pars += "&orderBy=" + info.sort[0].field + "&direction=" + info.sort[0].direction;
		}
		var d = new Date(); now = d.getTime();
		$("#cargando").css("display", "inline");
		url = "getContenido.php?marca="+ now +"&contenido="+info.data.contenido+"&id="+info.data.id+"&"+pars;
		if (info.data.query_filtro != '')
			url = url+"&"+info.data.query_filtro;			
		cargarDatos(url);
		// Important: return false to avoid href links
		return false;
	}
    $(".datagrid tr").mouseover(function() {
            $(this).addClass("over");
        });
    $(".datagrid tr").mouseout(function() {
        $(this).removeClass("over");
    });
	$("a").click(function(event) {
		
		if (($(this).attr("title")=="Usuarios-Roles") || ($(this).attr("title")=="Roles-Usuarios") ){
			var id = $(this).attr("id");
			var valor = $(this).attr("title");
			valor = valor.replace(" ","_");
			var d = new Date(); now = d.getTime();
			cargarDatos("getContenido.php?marca="+ now + "&contenido="+valor + "&id=" + id);
		}				
		if (($(this).attr("title")=="Modulo-Paginas") || ($(this).attr("title")=="Modulo-Paginas") ){
			var id = $(this).attr("id");
			var valor = $(this).attr("title");
			valor = valor.replace(" ","_");
			var d = new Date(); now = d.getTime();
			cargarDatos("getContenido.php?marca="+ now + "&contenido="+valor + "&id=" + id);
		}

        if (($(this).attr("title")=="Modulo-Tablas") || ($(this).attr("title")=="Modulo-Tablas") ){
        	var id = $(this).attr("id");
        	var valor = $(this).attr("title");
	        valor = valor.replace(" ","_");
	        var d = new Date(); now = d.getTime();
	        cargarDatos("getContenido.php?marca="+ now + "&contenido="+valor + "&id=" + id);        
        }
		/*if (($(this).attr("title")=="Modulo-Tablas") || ($(this).attr("title")=="Modulo-Tablas") ){
			var id = $(this).attr("id");
			var valor = $(this).attr("title");
			valor = valor.replace(" ","_");
			var d = new Date(); now = d.getTime();
			cargarDatos("getContenido.php?marca="+ now + "&contenido="+valor + "&id=" + id);
		}*/
	});
	
	function cargarDatos(url) {
		$("#contenido p").html("");
	    $("#cargando").css("display", "inline");
	    $("#contenido p").load(url,function(){
		    $("#cargando").css("display", "none");
		});
	}