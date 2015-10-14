{literal}
<script type="text/javascript" src="../js/mostrarModulos.js"></script>
<script type="text/javascript" src="../js/mostrarRoles.js"></script>
<script type="text/javascript" src="../js/mostrarTipoAcceso.js"></script>
<script type="text/javascript">
	function marcarItemModulo(item) {
		$("#dg_modulos tr").each(
				function() {
					$(this).removeClass("over");
				}
		);
		$(item).parent().parent().addClass("over");
		 
	}
	function marcarItemRol(item) {
		$("#dg_rol tr").each(
				function() {
					$(this).removeClass("over");
				}
		);
		$(item).parent().parent().addClass("over");		 
	}
	
    var app_id = 0;
    $("#aplicacion").change(function() {
        var app_id = $(this).val();
		if (app_id > 0) {
			$("#modulos p").html("Cargando...");
			$("#resumen p").html("");		
			$("#modulos p").load("getPermisos.php?contenido=Roles&id="+app_id);
			$("#resumen p").load("setPermisos.php?contenido=Roles&id="+app_id);

			// Si cambia el div aplicacion limpio el resto de los divs
	   
			$("#roles p").html("");
			$("#tipoacceso p").html("");
			//$("#resumen p").html("");
		}
		else {
			$("#modulos p").html("");
			$("#resumen p").html("");		
			$("#roles p").html("");
			$("#tipoacceso p").html("");			
		}
		
    });

</script>

<style type="text/css">
    tr.alt td {
        background: #eeeeee;
    }
    tr.over td {
        background: #bcd4ec;
    }
    tr.clickeada td {
        background: #20ffec;
    }
</style>
{/literal}
<div align="center">{$p_frm}</div>
<table align="center" width="700">
    <tr valign="top">
        <td width="33%"><div id="modulos"><p></p></div></td>
        <td width="33%"><div id="roles"><p></p></div></td>
        <td width="33%"><div id="tipoAcceso"><p></p></div></td>
    </tr>
</table>
<div id="resumen" style="text-align:left;margin-left:180px;"><p></p></div>