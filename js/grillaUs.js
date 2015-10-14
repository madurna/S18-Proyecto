/*	function updateGrid(info) 
	{
	 var pars = "page=" + info.page;
	    if (info.sort.length > 0) {
			pars += "&orderBy=" + info.sort[0].field + "&direction=" + info.sort[0].direction;
		}
		var d = new Date(); now = d.getTime();
		$("#cargando").css("display", "inline");
		fields = $("#frmFiltro").serialize();
		url = "contenidous.php?marca="+ now +"&tabla="+info.data.contenido+"&popup="+info.data.popup+"&"+pars;
		if (fields != '')
			url = url+"&"+fields;			
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
    $("a.contenido-grilla").click(function() {
    	var d = new Date(); now = d.getTime();
    	var valor = $(this).attr('href');		
    	url = "contenidous.php?marca="+ now + "&"+valor +"&popup=1";
    	$("#cargando").css("display", "inline");
		$("#contenido p").html("");	
		$("#contenido p").load(url,function(){
		    $("#cargando").css("display", "none");
		});	
	    return false;
    });
*/