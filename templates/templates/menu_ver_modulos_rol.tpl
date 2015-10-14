<script type="text/javascript" src="../js/jquery.livequery.js"></script>
<input type="hidden" id="actual" value="{$actual}">
<input type="hidden" id="id" value="{$id}">

<h2>Modulos rol</h2>
<!-- select de empresas-->
<table align="center">
  <tr> 
    <td width="40">&nbsp;</td>
    <td width="100%" align="center">
      {$dgp}<br/>
    {$dgp_paging}<br/>
    {$dgp_options}<br/></td>
    <td width="40">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"><img src="../img/spacer.gif" alt="" width="40" height="1"></td>
    <td></td>
    <td><img src="../img/spacer.gif" alt="" width="40" height="1"></td>
  </tr>
</table>
<br/>
<div id="cargando" style="display:none; color: green;"><br/><br/>Cargando...</div>
<h3>{$titulo_form}</h3>
<div id="contenido"><p></p></div><div id="otro"><p></p></div>