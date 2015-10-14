<?php
    /**
     * Muestra el nombre del campo de la tabla
     * @param <array> $vals
     * @param <array> $args
     * @return <string>
     */
//    function getDato($vals,$args){
//		extract($vals);
//		extract($args);
//        return '<p>'.utf8_encode($record[$id]).'</p>';
//	}

    function printCheckboxUsuario($params, $args)
    {
        extract($params);
        $input = "";
        //1 es seleccionado - 0 Sin seleccionar
        if($args['sess'][$record['cli_id']] == 0){
            $input = '<span class="check_select_us"><input type="checkbox" name="selected_us" value="' . $record['cli_id'] . '" id="table-selected-us_' . $record['cli_id'] . '" onclick="procesarUsuario(' . $record['cli_id'] . ',' . $args['tipo'] . ',this)" class="selected_us"></span>';
        }
        else{
            $input = '<span class="check_select_us"><input type="checkbox" name="selected_us" value="' . $record['cli_id'] . '" id="table-selected-us_' . $record['cli_id'] . '" checked="checked" onclick="procesarUsuario(' . $record['cli_id'] . ',' . $args['tipo'] . ',this)" class="selected_us"></span>';
        }

        return $input;
    }

    function printCheckboxSupUs($params, $args)
    {
        extract($params);
        $input = "";

        //1 es seleccionado - 0 Sin seleccionar
        if($args['sess'][$record['cli_id']] == 0){
            if($args['tit'][$record['cli_id']] == 1){
                $input = '<span class="check_select_us_sup"><input type="checkbox" name="selected_sup" value="' . $record['cli_id'] . '" id="table-selected-sup_' . $record['cli_id'] . '" onclick="procesarSupUs(' . $record['cli_id'] . ',this, '.$args['tipo'].')" class="selected_sup"></span>';
            }
            else{                
                $input = '<span class="check_select_us_sup"><input type="checkbox" name="selected_sup" value="' . $record['cli_id'] . '" id="table-selected-sup_' . $record['cli_id'] . '" onclick="procesarSupUs(' . $record['cli_id'] . ',this, '.$args['tipo'].')" disabled="disabled" class="selected_sup"></span>';
            }
        }
        else{
            $input = '<span class="check_select_us_sup"><input type="checkbox" name="selected_sup" value="' . $record['cli_id'] . '" id="table-selected-sup_' . $record['cli_id'] . '" checked="checked" onclick="procesarSupUs(' . $record['cli_id'] . ',this, '.$args['tipo'].')" class="selected_sup"></span>';
        }

        return $input;
    }

    function getSeleccionados($params, $args)
    {
        extract($params);

        //1 es seleccionado - 0 Sin seleccionar
        if($args['sess'][$record['cli_id']] == 1){
            return 'X';
        }
    }
