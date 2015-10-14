<?php /* Smarty version 2.6.26, created on 2015-04-22 18:15:16
         compiled from popUpSinEncabezado.htm */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $this->_tpl_vars['webTitulo']; ?>
 :: <?php echo $this->_tpl_vars['secTitulo']; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link href="../css/oceba.css" rel="stylesheet" type="text/css">
<link href="../css/industria.css" rel="stylesheet" type="text/css">
<link href="../css/wforms.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.8.3.js"></script>
<link href="../css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<?php echo '
<script>
	function cargado() {
		$("#radio").buttonset();
	}
</script>
<style>
#radio { 
	width:775px; 
	position:absolute; 
	margin-top:-54px; 
	text-align:center;
}
</style>
'; ?>

<link href="../css/wforms-jsonly.css" rel="alternate stylesheet" type="text/css" title="stylesheet activated by javascript">
<?php echo $this->_tpl_vars['header']; ?>

</head>
<body leftmargin="0" topmargin="0" onLoad="cargado()">
<table border="0" align="center" cellpadding="0" cellspacing="0" background="../img/fp-blanco.jpg">
  <!--DWLayoutTable-->
  <tr> 
    <td align="center" width="100%" valign="top"><table width="100%"><td align="top" width="50%"><?php echo $this->_tpl_vars['superiorizquierdo']; ?>
</td><td align="top"><?php echo $this->_tpl_vars['superiorderecho']; ?>
</td></table>
    </td>
  </tr>
  <tr> 
    <td height="372" align="center" valign="top"><?php echo $this->_tpl_vars['head']; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['includeFile2'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo $this->_tpl_vars['body']; ?>
<BR>
      <p><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['includeFile'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></p>
      <p>&nbsp;</p>
    </td>
  </tr>
</table>
</body>
</html>