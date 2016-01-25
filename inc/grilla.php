<?php
require_once('Structures/DataGrid.php');
require_once('HTML/Table.php');	

class grilla extends Structures_DataGrid {
    function grilla($limit = null, $width='100%', $page = null)
    {   	
        parent::Structures_DataGrid($limit, $page);
		
		$this->renderer->setTableHeaderAttributes(array('align' => 'center', 'text-align' => 'center' ,'bgcolor' => '#8F7359', 'class'=>'tituloLinkGrilla','style'=> '-webkit-border-radius: 3px; border-radius: 3px; '));

		$this->renderer->setTableEvenRowAttributes(array('align' => 'center','text-align' => 'center', 'bgcolor' => '#FFFFFF'));
		$this->renderer->setTableOddRowAttributes(array('align' => 'center', 'text-align' => 'center','bgcolor' => '#EEEEEE')); // 'class'=>'link1
		$this->renderer->setTableAttribute('cellspacing', '5');
		$this->renderer->setTableAttribute('walign', 'center');
		
		$this->renderer->setTableAttribute('width', $width);
		$this->renderer->sortIconASC = "<img src=\"../".IMG_DIR."/up.gif\" border=\"0\" align=\"middle\">";
		$this->renderer->sortIconDESC = "<img src=\"../".IMG_DIR."/down.gif\" border=\"0\" align=\"middle\">";
    }
}

/*class grilla extends Structures_DataGrid{
    public function grilla($limit = null, $width='100%', $page = null)
    {
        parent::Structures_DataGrid($limit, $page);
        $this->renderer->setTableHeaderAttributes(array('align' => 'center','bgcolor' => '#FFFBC9'));
        $this->renderer->setTableEvenRowAttributes(array('align' => 'center', 'bgcolor' => '#FFFFFF'));
        $this->renderer->setTableOddRowAttributes(array('align' => 'center', 'bgcolor' => '#EEEEEE')); // 'class'=>'link1'
        $this->renderer->setTableAttribute('cellspacing', '0');
        $this->renderer->setTableAttribute('cellpadding', '2');
        $this->renderer->setTableAttribute('class', 'datagrid');
        $this->renderer->setTableAttribute('width', $width);
        $this->renderer->sortIconASC = "<img src=\"../".IMG_DIR."/up.gif\" border=\"0\" align=\"middle\">";
        $this->renderer->sortIconDESC = "<img src=\"../".IMG_DIR."/down.gif\" border=\"0\" align=\"middle\">";
    }
    public function bind($do) {
        return parent::bind($do,array('link_level'=> 1),'DB_DataObject');
    }

    /**
     * Genera un link para la modificacion de datos
     *
     * @param array $vals Campos de una grilla y parametros adicionales
     * @return string
     */
/*   function printLink($vals,$args) {
        extract($vals);
        extract($args);
        $dir = 'Error';
        if ($idvendedor) {
            $dir = "<a href='{$record[$idvendedor]}'>[Editar]</a> |
                <a href='{$record[$idvendedor]}' onclick='return confirmar()'>[Borrar]</a>";
        }
        else {
            trigger_error('DataGrid::addColumn() Id Vendedor para modificacion de registro nulo', E_USER_WARNING);
        }

        return $dir;
    }
}*/
/*
class grillaHTML extends Structures_DataGrid {
	private $_ampliar;
    function grillaHTML($limit = null, $width='100%', $page = null,$ampliar=true)
    {   	
        parent::Structures_DataGrid($limit, $page);  
        $this->_ampliar = $ampliar;
        $this->setRendererOption('encoding',"UTF-8",true);   
        
		$this->renderer->setTableHeaderAttributes(array('align' => 'center','class' => 'tituloGrilla'));
		$this->renderer->setTableEvenRowAttributes(array('align' => 'center', 'bgcolor' => '#FFFFFF','class' => 'filaGrilla'));
		$this->renderer->setTableOddRowAttributes(array('align' => 'center', 'bgcolor' => '#EEEEEE','class' => 'filaGrilla')); // 'class'=>'link1'
		$this->renderer->setTableAttribute('cellspacing', '0');
		$this->renderer->setTableAttribute('cellpadding', '2');
		$this->renderer->setTableAttribute('class', 'datagrid');
		$this->renderer->setTableAttribute('width', $width);
		//$this->renderer->setTableAttribute('height', "500");
   		$this->setRendererOption('sortIconASC',"<img src=\"../".IMG_DIR."/up.gif\" border=\"0\" align=\"middle\">");
		$this->setRendererOption('sortIconDESC',"<img src=\"../".IMG_DIR."/down.gif\" border=\"0\" align=\"middle\">");
	}   
    function bind($do,$options = array('link_level'=> 1,'link_keep_key' => true),$type='DB_DataObject') {
    	return parent::bind($do,$options,$type);		
    }
    function getOutput($regs = 1) {
		if (($this->_ampliar) and (get_class($this->renderer) == 'Structures_DataGrid_Renderer_HTMLTable')) {
			$key = time().rand(100,999);
			$grilla = '
			<style type="text/css">				
				tr.filaGrilla:hover td {
				background: #bcd4ec;
				}
			</style>
			<script>
				function ampliarGrilla_'.$key.'(){
					dialogo = $("#dialog'.$key.'");
					$(dialogo).dialog({ autoOpen: false});
					$(dialogo).dialog( "option", "position", "center");
					$(dialogo).dialog( "option", "width", "85%" );
					$(dialogo).dialog( "option", "height", "500" );
					$(dialogo).dialog({ zIndex: 4000 });
					$(dialogo).html("<div id=\'ampdg'.$key.'\'>"+$("#dg'.$key.'").html()+"</div>");
					$("#dialog'.$key.' a").each(function(){$(this).click(function(){alert("La función seleccionada no se puede acceder mediante la ampliación de la grilla"); return false;});});
					$(dialogo).dialog("open");
				}
			</script>';
			
			
			$total = parent::getRecordCount();
			if (PEAR::isError($total))
				$total = 0;
			
			if ($total>0){
                            if($regs){
                                $grilla=$grilla.'
                                <div align="center"><a href="#" onClick="ampliarGrilla_'.$key.'()">[Ampliar p&aacute;gina]</a></div><br/><br/><div><b>Total de registros encontrados: </b>'.$total.'</div><div id="dialog'.$key.'" style="display:none; overflow:auto;"></div><br/><div align="center" style="width:675px; min-height:50px; overflow:auto;"id="dg'.$key.'">'.
                                        parent::getOutput().'</div>';
                            }
                            else{
                                $grilla=$grilla.'
                                <div align="center"><a href="#" onClick="ampliarGrilla_'.$key.'()">[Ampliar p&aacute;gina]</a></div><br/><br/><div id="dialog'.$key.'" style="display:none; overflow:auto;"></div><br/><div align="center" style="width:675px; min-height:50px; overflow:auto;"id="dg'.$key.'">'.
                                    parent::getOutput().'</div>';

                            }
                        }
			//$grilla = parent::getOutput();
			return $grilla;
		}
		else
			return parent::getOutput();
	}

	
	function getOutputSinAmpliar($titulo = '') {
		if (($this->_ampliar) and (get_class($this->renderer) == 'Structures_DataGrid_Renderer_HTMLTable')) {
			$key = time().rand(100,999);
			if (parent::getRecordCount() > 0)
			$grilla=$grilla.'
			<style type="text/css">				
				tr.filaGrilla:hover td {
				background: #bcd4ec;
				}
			</style>
			<div align="center"><b>'.$titulo.'</b></div><div id="dialog'.$key.'" style="display:none; overflow:auto;"></div><br/><div align="center" style="width:675px; overflow:auto;"id="dg'.$key.'">'.
			parent::getOutput().'</div>';
				
			//$grilla = parent::getOutput();
			return $grilla;
		}
		else
			return parent::getOutput();
	}
	

	function getOutputSorteo($width = '650',$height = 'auto') {
		if (($this->_ampliar) and (get_class($this->renderer) == 'Structures_DataGrid_Renderer_HTMLTable')) {
			$key = time().rand(100,999);
			$grilla = '
			<style type="text/css">				
				tr.filaGrilla:hover td {
				background: #bcd4ec;
				}
			</style>
			<script>
				function ampliarGrilla_'.$key.'(){
					dialogo = $("#dialog'.$key.'");
					$(dialogo).dialog({ autoOpen: false});
					$(dialogo).dialog( "option", "position", "center");
					$(dialogo).dialog( "option", "width", "85%" );
					$(dialogo).dialog( "option", "height", "600" );
					$(dialogo).dialog({ zIndex: 4000 });
					$(dialogo).html("<div id=\'ampdg'.$key.'\'>"+$("#dg'.$key.'").html()+"</div>");
					$("#dialog'.$key.' a").each(function(){$(this).click(function(){alert("La función seleccionada no se puede acceder mediante la ampliación de la grilla"); return false;});});
					$(dialogo).dialog("open");
				}
			</script>';
			if (parent::getRecordCount() > 0)
			$grilla=$grilla.'
			<div align="center"><a href="#" onClick="ampliarGrilla_'.$key.'()">[Ampliar p&aacute;gina]</a></div><div id="dialog'.$key.'" style="display:none; overflow:auto;"></div><br/><div align="center" style="width:'.$width.';height:'.$height.'; overflow-x:auto;overflow-y:hidden;padding-bottom:20px;"id="dg'.$key.'">'.
				parent::getOutput().'</div>';

			//$grilla = parent::getOutput();
			return $grilla;
		}
		else
			return parent::getOutput();
	}
}

*/

class grillaHTML extends Structures_DataGrid {
	private $_ampliar;
    function grillaHTML($limit = null, $width='100%', $page = null,$ampliar=true)
    {   	
        parent::Structures_DataGrid($limit, $page);  
        $this->_ampliar = $ampliar;
        $this->setRendererOption('encoding',"UTF-8",true);   
        
		parent::Structures_DataGrid($limit, $page);
		$this->renderer->setTableHeaderAttributes(array('align' => 'center','bgcolor' => '#333333'));
		$this->renderer->setTableEvenRowAttributes(array('align' => 'center', 'bgcolor' => '#FFFFFF'));
		$this->renderer->setTableOddRowAttributes(array('align' => 'center', 'bgcolor' => '#EEEEEE')); // 'class'=>'link1'
		// $this->renderer->setTableAttribute('class', 'link3');
		$this->renderer->setTableAttribute('cellspacing', '0');
		$this->renderer->setTableAttribute('cellpadding', '2');
		$this->renderer->setTableAttribute('class', 'datagrid');
		$this->renderer->setTableAttribute('width', $width);
		$this->renderer->sortIconASC = "<img src=\"../".IMG_DIR."/up.gif\" border=\"0\" align=\"middle\">";
		$this->renderer->sortIconDESC = "<img src=\"../".IMG_DIR."/down.gif\" border=\"0\" align=\"middle\">";
  	
    }   
    
    function bind($do,$options = array('link_level'=> 1,'link_keep_key' => true),$type='DB_DataObject') {
    	return parent::bind($do,$options,$type);		
    }
    
    function getOutput($regs = 1) {
		if (($this->_ampliar) and (get_class($this->renderer) == 'Structures_DataGrid_Renderer_HTMLTable')) {
			$key = time().rand(100,999);
			$grilla = '
			<style type="text/css">				
				tr.filaGrilla:hover td {
				background: #bcd4ec;
				}
			</style>
			<script>
				function ampliarGrilla_'.$key.'(){
					dialogo = $("#dialog'.$key.'");
					$(dialogo).dialog({ autoOpen: false});
					$(dialogo).dialog( "option", "position", "center");
					$(dialogo).dialog( "option", "width", "85%" );
					$(dialogo).dialog( "option", "height", "500" );
					$(dialogo).dialog({ zIndex: 4000 });
					$(dialogo).html("<div id=\'ampdg'.$key.'\'>"+$("#dg'.$key.'").html()+"</div>");
					$("#dialog'.$key.' a").each(function(){$(this).click(function(){alert("La función seleccionada no se puede acceder mediante la ampliación de la grilla"); return false;});});
					$(dialogo).dialog("open");
				}
			</script>';
			
			
			$total = parent::getRecordCount();
			if (PEAR::isError($total))
				$total = 0;
			
			if ($total>0){
                            if($regs){
                                $grilla=$grilla.'
                                <div align="center"><a href="#" onClick="ampliarGrilla_'.$key.'()">[Ampliar p&aacute;gina]</a></div><br/><br/><div><b>Total de registros encontrados: </b>'.$total.'</div><div id="dialog'.$key.'" style="display:none; overflow:auto;"></div><br/><div align="center" style="width:675px; min-height:50px; overflow:auto;"id="dg'.$key.'">'.
                                        parent::getOutput().'</div>';
                            }
                            else{
                                $grilla=$grilla.'
                                <div align="center"><a href="#" onClick="ampliarGrilla_'.$key.'()">[Ampliar p&aacute;gina]</a></div><br/><br/><div id="dialog'.$key.'" style="display:none; overflow:auto;"></div><br/><div align="center" style="width:675px; min-height:50px; overflow:auto;"id="dg'.$key.'">'.
                                    parent::getOutput().'</div>';

                            }
                        }
			//$grilla = parent::getOutput();
			return $grilla;
		}
		else
			return parent::getOutput();
	}
	
	function getOutputSinAmpliar($titulo = '') {
		if (($this->_ampliar) and (get_class($this->renderer) == 'Structures_DataGrid_Renderer_HTMLTable')) {
			$key = time().rand(100,999);
			if (parent::getRecordCount() > 0)
			$grilla=$grilla.'
			<style type="text/css">				
				tr.filaGrilla:hover td {
				background: #bcd4ec;
				}
			</style>
			<div align="center"><b>'.$titulo.'</b></div><div id="dialog'.$key.'" style="display:none; overflow:auto;"></div><br/><div align="center" style="width:675px; overflow:auto;"id="dg'.$key.'">'.
			parent::getOutput().'</div>';
				
			//$grilla = parent::getOutput();
			return $grilla;
		}
		else
			return parent::getOutput();
	}
}

class grillaCuadro extends Structures_DataGrid {
    function grillaCuadro($limit = null, $width='100%', $page = null)
    {   	
        parent::Structures_DataGrid($limit, $page);
		$this->renderer->setTableHeaderAttributes(array('align' => 'center','bgcolor' => '#FFFFFF'));
		$this->renderer->setTableEvenRowAttributes(array('align' => 'center', 'bgcolor' => '#FFFFFF'));
		$this->renderer->setTableOddRowAttributes(array('align' => 'center', 'bgcolor' => '#EEEEEE')); // 'class'=>'link1'
		// $this->renderer->setTableAttribute('class', 'link3');
		$this->renderer->setTableAttribute('cellspacing', '0');
		$this->renderer->setTableAttribute('cellpadding', '2');
		$this->renderer->setTableAttribute('class', 'datagrid');
		$this->renderer->setTableAttribute('width', $width);
		$this->renderer->sortIconASC = "<img src=\"../".IMG_DIR."/up.gif\" border=\"0\" align=\"middle\">";
		$this->renderer->sortIconDESC = "<img src=\"../".IMG_DIR."/down.gif\" border=\"0\" align=\"middle\">";
    }
}


class grillaContenido extends Structures_DataGrid {
    function grillaContenido($limit = null, $width='100%', $page = null)
    {   	
   		parent::Structures_DataGrid($limit, $page);
		$this->renderer->setTableHeaderAttributes(array('align' => 'center','bgcolor' => '#333333'));
		$this->renderer->setTableEvenRowAttributes(array('align' => 'center', 'bgcolor' => '#FFFFFF'));
		$this->renderer->setTableOddRowAttributes(array('align' => 'center', 'bgcolor' => '#EEEEEE')); // 'class'=>'link1'
		// $this->renderer->setTableAttribute('class', 'link3');
		$this->renderer->setTableAttribute('cellspacing', '0');
		$this->renderer->setTableAttribute('cellpadding', '2');
		$this->renderer->setTableAttribute('class', 'datagrid');
		$this->renderer->setTableAttribute('width', $width);
		//$this->renderer->setTableAttribute('style', 'overflow:scroll;');
		$this->renderer->sortIconASC = "<img src=\"../".IMG_DIR."/up.gif\" border=\"0\" align=\"middle\">";
		$this->renderer->sortIconDESC = "<img src=\"../".IMG_DIR."/down.gif\" border=\"0\" align=\"middle\">";
    }
}


class grillaHTMLPermisos extends Structures_DataGrid {
	private $_ampliar;
    function grillaHTMLPermisos($limit = null, $width='100%', $page = null,$ampliar=true)
    {   	
        parent::Structures_DataGrid($limit, $page);  
        $this->_ampliar = $ampliar;
        $this->setRendererOption('encoding',"UTF-8",true);   
        
		$this->renderer->setTableHeaderAttributes(array('align' => 'center','class' => 'tituloGrilla'));
		$this->renderer->setTableEvenRowAttributes(array('align' => 'center', 'bgcolor' => '#FFFFFF'));
		$this->renderer->setTableOddRowAttributes(array('align' => 'center', 'bgcolor' => '#EEEEEE')); // 'class'=>'link1'
		$this->renderer->setTableAttribute('cellspacing', '0');
		$this->renderer->setTableAttribute('cellpadding', '2');
		$this->renderer->setTableAttribute('class', 'datagrid');
		$this->renderer->setTableAttribute('width', $width);
		//$this->renderer->setTableAttribute('height', "500");
   		$this->setRendererOption('sortIconASC',"<img src=\"../".IMG_DIR."/up.gif\" border=\"0\" align=\"middle\">");
		$this->setRendererOption('sortIconDESC',"<img src=\"../".IMG_DIR."/down.gif\" border=\"0\" align=\"middle\">");
	}   
    function bind($do,$options = array('link_level'=> 1,'link_keep_key' => true),$type='DB_DataObject') {
    	return parent::bind($do,$options,$type);		
    }
}

?>