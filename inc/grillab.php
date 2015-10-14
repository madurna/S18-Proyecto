<?php
require_once('Structures/DataGrid.php');
require_once('HTML/Table.php');

class grilla extends Structures_DataGrid{
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
    function printLink($vals,$args) {
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
}