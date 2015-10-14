<div align="center">
<div class="tplError" style="border:1px solid; padding:20px 10px 20px 10px; text-align:center; width:400px;">
	<div>
		<div style="float:left;"><img src="../img/not_ok48.png" width="48" height="48" style="vertical-align:middle;" /></div><div class="tplErrorMsg" style="margin-left:20px; padding-top:10px; text-align:center; min-height:48px;">{$error_msg}</div>
	</div>
	{if $error_volver}
	<div align="right">
		<a style="
			background:url('../img/red_buttons_and_bars.jpg') repeat scroll -60px -8px transparent;
			color:#FFFFFF;
			display:block;
			font-weight:bold;
			height:40px;
			line-height:39px;
			padding-right:50px;
			text-decoration:none;
			width:70px;" href="{if $error_volver_href}{$error_volver_href}{else}#{/if}"><span>{$error_volver}</span></a>
	</div>
	{/if}
</div>
</div>