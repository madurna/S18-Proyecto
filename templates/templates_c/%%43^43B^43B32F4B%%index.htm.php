<?php /* Smarty version 2.6.26, created on 2015-10-10 22:16:19
         compiled from index.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'index.htm', 62, false),array('modifier', 'cat', 'index.htm', 62, false),array('modifier', 'upper', 'index.htm', 96, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $this->_tpl_vars['webTitulo']; ?>
 :: <?php echo $this->_tpl_vars['secTitulo']; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/oceba.css" rel="stylesheet" type="text/css">
<link href="../css/industria.css" rel="stylesheet" type="text/css">
<link href="../css/wforms.css" rel="stylesheet" type="text/css">
<link id="page_favicon" href="../templates/templates/mbh.ico" rel="icon" type="image/x-icon" />
<script src="../js/jquery-1.8.3.js"></script>
<link href="../css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<!--boostrap-->
<link href="../css/assets/stylesheets/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../css/assets/stylesheets/pixel-admin.css" rel="stylesheet" type="text/css">

<!-- Pixel Admin's javascripts -->
<script src="../css/assets/javascripts/bootstrap.js"></script>
<!-- Fin -->
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
</head>
<body leftmargin="0" topmargin="0" onLoad="cargado()">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" background="../img/fp-blanco.jpg">
  <!--DWLayoutTable-->
  <tr align="left" valign="middle"> 
    <td align="center">
		<div>
			<img src="../img/header_mbh.png" width="100%" border="0" usemap="#Map">
			<!--<div id="radio">
				<input type="radio" id="radio1" name="radio" onClick="location.href = '/mercados/remoteAuthCli.php'" /><label for="radio1">Calidad</label>
				<input type="radio" id="radio2" name="radio" checked="checked" /><label for="radio2">Mercados</label>
			</div> -->
		</div>
	</td>
    
  </tr>
  <tr valign="middle" width=""><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['menu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></tr>
  <tr valign="middle">
    <td  bgcolor="#FFFFFF">
	 <table border="0" cellspacing="1" cellpadding="1" >
	   <tr> 
       <!--DWLayoutTable-->
	  <?php unset($this->_sections['menu']);
$this->_sections['menu']['name'] = 'menu';
$this->_sections['menu']['loop'] = is_array($_loop=$this->_tpl_vars['links']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['menu']['show'] = true;
$this->_sections['menu']['max'] = $this->_sections['menu']['loop'];
$this->_sections['menu']['step'] = 1;
$this->_sections['menu']['start'] = $this->_sections['menu']['step'] > 0 ? 0 : $this->_sections['menu']['loop']-1;
if ($this->_sections['menu']['show']) {
    $this->_sections['menu']['total'] = $this->_sections['menu']['loop'];
    if ($this->_sections['menu']['total'] == 0)
        $this->_sections['menu']['show'] = false;
} else
    $this->_sections['menu']['total'] = 0;
if ($this->_sections['menu']['show']):

            for ($this->_sections['menu']['index'] = $this->_sections['menu']['start'], $this->_sections['menu']['iteration'] = 1;
                 $this->_sections['menu']['iteration'] <= $this->_sections['menu']['total'];
                 $this->_sections['menu']['index'] += $this->_sections['menu']['step'], $this->_sections['menu']['iteration']++):
$this->_sections['menu']['rownum'] = $this->_sections['menu']['iteration'];
$this->_sections['menu']['index_prev'] = $this->_sections['menu']['index'] - $this->_sections['menu']['step'];
$this->_sections['menu']['index_next'] = $this->_sections['menu']['index'] + $this->_sections['menu']['step'];
$this->_sections['menu']['first']      = ($this->_sections['menu']['iteration'] == 1);
$this->_sections['menu']['last']       = ($this->_sections['menu']['iteration'] == $this->_sections['menu']['total']);
?> 
		<?php if ($this->_tpl_vars['links'][$this->_sections['menu']['index']] != null): ?> 				
        	<td width="100" align="center" valign="middle" height="19"> 
			  <div align="center">
			  	<?php if (((is_array($_tmp=((is_array($_tmp=$_SERVER['SCRIPT_NAME'])) ? $this->_run_mod_handler('replace', true, $_tmp, $this->_tpl_vars['links'][$this->_sections['menu']['index']]['pgn'], "") : smarty_modifier_replace($_tmp, $this->_tpl_vars['links'][$this->_sections['menu']['index']]['pgn'], "")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['links'][$this->_sections['menu']['index']]['pgn']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['links'][$this->_sections['menu']['index']]['pgn'])) == $_SERVER['SCRIPT_NAME']): ?>
					<span style="color: #D21A34; font-size: 13px;'"><b><?php echo $this->_tpl_vars['links'][$this->_sections['menu']['index']]['item']; ?>
</b>	</span>		
				<?php else: ?>	
					<a class="link2" title="<?php echo $this->_tpl_vars['links'][$this->_sections['menu']['index']]['alt']; ?>
" href="<?php echo $this->_tpl_vars['links'][$this->_sections['menu']['index']]['pgn']; ?>
"><?php echo $this->_tpl_vars['links'][$this->_sections['menu']['index']]['item']; ?>
</a>
	    		<?php endif; ?>
	    	  </div>
		    </td>
		<?php endif; ?>
      <?php endfor; endif; ?>
	   <td width="120">&nbsp;</td>
       <td width="120">&nbsp;</td>
       <td width="120">&nbsp;</td>		 
		</tr>
		<tr> 
       <!--DWLayoutTable-->
	  <?php unset($this->_sections['submenu']);
$this->_sections['submenu']['name'] = 'submenu';
$this->_sections['submenu']['loop'] = is_array($_loop=$this->_tpl_vars['sublinks']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['submenu']['show'] = true;
$this->_sections['submenu']['max'] = $this->_sections['submenu']['loop'];
$this->_sections['submenu']['step'] = 1;
$this->_sections['submenu']['start'] = $this->_sections['submenu']['step'] > 0 ? 0 : $this->_sections['submenu']['loop']-1;
if ($this->_sections['submenu']['show']) {
    $this->_sections['submenu']['total'] = $this->_sections['submenu']['loop'];
    if ($this->_sections['submenu']['total'] == 0)
        $this->_sections['submenu']['show'] = false;
} else
    $this->_sections['submenu']['total'] = 0;
if ($this->_sections['submenu']['show']):

            for ($this->_sections['submenu']['index'] = $this->_sections['submenu']['start'], $this->_sections['submenu']['iteration'] = 1;
                 $this->_sections['submenu']['iteration'] <= $this->_sections['submenu']['total'];
                 $this->_sections['submenu']['index'] += $this->_sections['submenu']['step'], $this->_sections['submenu']['iteration']++):
$this->_sections['submenu']['rownum'] = $this->_sections['submenu']['iteration'];
$this->_sections['submenu']['index_prev'] = $this->_sections['submenu']['index'] - $this->_sections['submenu']['step'];
$this->_sections['submenu']['index_next'] = $this->_sections['submenu']['index'] + $this->_sections['submenu']['step'];
$this->_sections['submenu']['first']      = ($this->_sections['submenu']['iteration'] == 1);
$this->_sections['submenu']['last']       = ($this->_sections['submenu']['iteration'] == $this->_sections['submenu']['total']);
?> 
		<?php if ($this->_tpl_vars['sublinks'][$this->_sections['submenu']['index']] != null): ?> 				
        	<td width="20" > 
			  <div align="left"><?php if (((is_array($_tmp=((is_array($_tmp=$_SERVER['SCRIPT_NAME'])) ? $this->_run_mod_handler('replace', true, $_tmp, $this->_tpl_vars['sublinks'][$this->_sections['submenu']['index']]['pgn'], "") : smarty_modifier_replace($_tmp, $this->_tpl_vars['sublinks'][$this->_sections['submenu']['index']]['pgn'], "")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['sublinks'][$this->_sections['submenu']['index']]['pgn']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['sublinks'][$this->_sections['submenu']['index']]['pgn'])) == $_SERVER['SCRIPT_NAME']): ?> <span class="texto_negro"><?php echo $this->_tpl_vars['sublinks'][$this->_sections['submenu']['index']]['item']; ?>
 </span>			
				<?php else: ?>
					<a class="link3" title="<?php echo $this->_tpl_vars['sublinks'][$this->_sections['submenu']['index']]['alt']; ?>
" href="<?php echo $this->_tpl_vars['sublinks'][$this->_sections['submenu']['index']]['pgn']; ?>
"><?php echo $this->_tpl_vars['sublinks'][$this->_sections['submenu']['index']]['item']; ?>
</a> 
			<?php endif; ?>
		    </div></td>
		<?php endif; ?>
      <?php endfor; endif; ?>
	   <td width="120">&nbsp;</td>
      <td width="120">&nbsp;</td>
      <td width="120">&nbsp;</td>		 
	  </tr>
	  </table>
	</td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="top" bgcolor="#FFFFFF"><?php if ($this->_tpl_vars['usuario']): ?><span class="texto_negro"></b><?php if ($this->_tpl_vars['modulo']): ?>
		 MODULO: <b> <?php echo ((is_array($_tmp=$this->_tpl_vars['modulo'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
<?php endif; ?></span><?php endif; ?></td>
  </tr>
  <tr> 
    <td align="center" width="100%" valign="top"><table width="100%"><td align="top" width="50%"><?php echo $this->_tpl_vars['superiorizquierdo']; ?>
</td><td align="top"><?php echo $this->_tpl_vars['superiorderecho']; ?>
</td></table>
    </td>
		

  </tr>
  <tr> 
    <td height="372" align="center" valign="top">
    <div align="center"><?php echo $this->_tpl_vars['body']; ?>
</div>
    <div align="center"><?php echo $this->_tpl_vars['body_grilla']; ?>
</div>
    	<?php if ($this->_tpl_vars['include_file']): ?>            
    		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['include_file'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    	<?php endif; ?>
		<br />
    </td>
  </tr>
  <br />
  <tr> 
    <td><div align="center"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pie.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div></td>
  </tr>
</table>
<map name="Map">
  <area shape="rect" coords="14,2,302,150" href="../home/home.php">
</map>
</body>
</html>