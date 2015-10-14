<script type="text/javascript" src="../js/jquery.livequery.js"></script>
<input type="hidden" id="actual" value="{$actual}">
<input type="hidden" id="id" value="{$id}">
{literal}
<script type="text/javascript">

    $(document).ready(function(){
        $("a.menu-seguridad").click(function(){
            var contenido = $(this).attr("title");
            var d = new Date(); now = d.getTime();
            $("#contenido p").html("");
            $("#cargando").css("display", "inline");
            $("#contenido p").load("getContenido.php?marca="+ now + "&contenido=" + contenido,function(){
                    $("#cargando").css("display", "none");                   
                });           
            return false;
            });
        if (!($("#actual").attr("value")=="")){
        	$("#contenido p").html("");
            $("#cargando").css("display", "inline");
            $("#contenido p").load("getContenido.php?contenido=" + $("#actual").attr("value")+ "&id=" + $("#id").attr("value"),function(){
                $("#cargando").css("display", "none");
            });
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
</style>
{/literal}
<h2>Administraci&oacute;n de Seguridad</h2>
<table align="center">
    <tr>
        <td><a class="menu-seguridad" href="#Aplicaciones" title="Aplicaciones">[Aplicaciones]</a></td>
        <td><a class="menu-seguridad" href="#Modulos" title="Modulos">[M&oacute;dulos]</a></td>
        <td><a class="menu-seguridad" href="#Roles" title="Roles">[Roles]</a></td>
        <td><a class="menu-seguridad" href="#Usuarios" title="Usuarios">[Usuarios]</a></td>
        <td><a class="menu-seguridad" href="#Tipos-Acceso" title="Tipos-Acceso">[Tipos Acceso]</a></td>
        <td><a class="menu-seguridad" href="#Permisos" title="Permisos">[Permisos]</a></td>
        <td><a class="menu-seguridad" href="#Deportes" title="Deportes">[Deportes]</a></td>
        <td><a class="menu-seguridad" href="#Jugadores" title="Jugadores">[Jugadores]</a></td>
    </tr>
    <tr>
    	<td colspan=6 align="center">
    		<a class="menu-seguridad" href="#Log-Ingresos" title="Log-Ingresos">[Log Ingresos]</a>
    	</td>
    </tr>
</table>
<br/>
<div id="cargando" style="display:none; color: green;"><br/><br/>Cargando...</div>
<div id="contenido"><p></p></div><div id="otro"><p></p></div>