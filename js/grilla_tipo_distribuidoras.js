 function updateGrid(info) 
	{
		var pars = "page=" + info.page;
		if (info.sort.length > 0) {
			pars += "&orderBy=" + info.sort[0].field + "&direction=" + info.sort[0].direction;
		}
		$("#cargando").css("display", "inline");
		url = "getContenido.php?contenido="+info.data.contenido+"&"+pars;
		$("#contenido p").html("");
        $("#cargando").css("display", "inline");
        $("#contenido p").load(url,function(){
			 $("#cargando").css("display", "none");
		});			

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
		if (($(this).attr("title")=="Semestres")){
			var id = $(this).attr("id");
			var valor = $(this).attr("title");
			valor = valor.replace(" ","_");
			$("#contenido p").html("");		
		    $("#cargando").css("display", "inline");		    
		    $("#contenido p").load("getContenido.php?contenido="+valor + "&id=" + id,function(){
			    $("#cargando").css("display", "none");
			});
		}				
	});