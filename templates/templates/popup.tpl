{$head}
{$header}
<link href="../css/wforms-jsonly.css" rel="alternate stylesheet" type="text/css" title="stylesheet activated by javascript">
<script src="../js/comun.js"></script>
<script src="../js/jquery.min.js"></script>
<link href="../js/jqueryui/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="../js/jqueryui/jquery-ui.min.js"></script>
<script src="../js/jquery.form/jquery.form.js"></script>
{$script}
<table border="0" height="100%" align="center" cellpadding="0" cellspacing="0" background="../img/fp-blanco.jpg" style="width:755px; overflow:scroll;">
    <!--DWLayoutTable-->
    <tr><td valign="middle">{if $include_file}
            {include file=$include_file}
            {/if}{$body}<br />
        </td></tr>
</table>
