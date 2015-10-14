<?php /* Smarty version 2.6.26, created on 2015-10-10 22:24:29
         compiled from menu_oceba.htm */ ?>
<!--DWLayoutTable-->
<td bgcolor="#b6192a">
	<table class="table-bordered" width="100%" height="35" cellspacing="2" cellpadding="2" >
	<tr valign="middle" align="center" > 
		
	  <?php unset($this->_sections['menu']);
$this->_sections['menu']['name'] = 'menu';
$this->_sections['menu']['loop'] = is_array($_loop=$this->_tpl_vars['linksMenu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		  <?php if ($this->_tpl_vars['linksMenu'][$this->_sections['menu']['index']] != null): ?> 				
		  		<td width="7%" style="cursor:hand; cursor:pointer;" id="menu<?php echo $this->_tpl_vars['linksMenu'][$this->_sections['menu']['index']]['id']; ?>
" onClick="javascript:location.href='../<?php echo $this->_tpl_vars['linksMenu'][$this->_sections['menu']['index']]['link']; ?>
'" title="<?php echo $this->_tpl_vars['linksMenu'][$this->_sections['menu']['index']]['alt']; ?>
" class="menu_td"><a id="menua<?php echo $this->_tpl_vars['linksMenu'][$this->_sections['menu']['index']]['id']; ?>
" class="link1" title="<?php echo $this->_tpl_vars['linksMenu'][$this->_sections['menu']['index']]['alt']; ?>
" href="../<?php echo $this->_tpl_vars['linksMenu'][$this->_sections['menu']['index']]['link']; ?>
">&nbsp;<?php echo $this->_tpl_vars['linksMenu'][$this->_sections['menu']['index']]['item']; ?>
&nbsp;</a></td>
		  <?php endif; ?>
	  <?php endfor; endif; ?>
				 
		<td width="18%" align="right" class="dropdown-right btn btn-labeled btn-danger text-left" id="menu30">
			<a href="#" id="menua12" class="dropdown-toggle user-menu link3" data-toggle="dropdown">
				<span class="btn-label icon fa fa-align-justify"></span>
				<span > &nbsp;&nbsp;Bienvenido&nbsp;<b><?php echo $this->_tpl_vars['usuario']; ?>
</b>!</span>
			</a>
			<ul class="dropdown-menu bg-danger text-bold no-margin-vr">
				<li><a id="menua12" href="../home/edicion.php"><i class="dropdown-icon fa fa-user"></i>&nbsp;&nbsp;Perfil</a></li>
				<li class="divider"></li>
				<li id="menu13"><a id="menua13" onClick="javascript: return confirm('¿Desea salir?')" href="../home/logout.php"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;<b>Cerrar sesi&oacute;n</b></a></li>
			</ul>
		</td>
		
	</tr>
	</table>
	<script>
		var idmenu = <?php echo $_SESSION['menu_principal']; ?>
;
		document.getElementById("menu"+idmenu).style.backgroundColor="#df3823";
		document.getElementById("menua"+idmenu).style.fontWeight="bold";
	</script>
</td>