function abrirDialogoIdURL(id,url)  {
	var dialogo = $("#"+id);
	$(dialogo).html('<div align="center"><img src ="../img/ajax-loader.gif" /><br/><br/>Cargando...</div>');	
	$(dialogo).dialog("open");
	$(dialogo).load(url);			
}