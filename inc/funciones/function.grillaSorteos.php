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

    function printCheckboxCT($params, $args)
    {
        extract($params);
        $input = "";
        
        //1 es seleccionado - 0 Sin seleccionar
        if($args['sess'][$record['ct_id']] == 0){

            $input = '<span class="check_select"><input type="checkbox" name="selected_ct" value="' . $record['ct_id'] . '" id="table-selected-ct_' . $record['ct_id'] . '" onclick="procesarCT(' . $record['ct_id'] . ',this)" class="selected_ct"></span>';
        }
        else{
            
            $input = '<span class="check_select"><input type="checkbox" name="selected_ct" value="' . $record['ct_id'] . '" id="table-selected-ct_' . $record['ct_id'] . '" checked="checked" onclick="procesarCT(' . $record['ct_id'] . ',this)" class="selected_ct"></span>';
        }

        return $input;
    }

    function printCheckboxSup($params, $args)
    {
        extract($params);
        $input = "";
        //1 es seleccionado - 0 Sin seleccionar
        if($args['sess'][$record['ct_id']] == 0){
            if($args['sorteo_ct'][$record['ct_id']] == 1){
                $input = '<span class="check_select_sup"><input type="checkbox" name="selected_sup" value="' . $record['ct_id'] . '" id="table-selected-sup_' . $record['ct_id'] . '" onclick="procesarSup(' . $record['ct_id'] . ',this)" class="selected_sup"></span>';
            }
            else{
                $input = '<span class="check_select_sup"><input type="checkbox" name="selected_sup" value="' . $record['ct_id'] . '" id="table-selected-sup_' . $record['ct_id'] . '" onclick="procesarSup(' . $record['ct_id'] . ',this)" disabled="disabled" class="selected_sup"></span>';
            }
        }
        else{
            $input = '<span class="check_select_sup"><input type="checkbox" name="selected_sup" value="' . $record['ct_id'] . '" id="table-selected-sup_' . $record['ct_id'] . '" checked="checked" onclick="procesarSup(' . $record['ct_id'] . ',this)" class="selected_sup"></span>';
        }

        return $input;
    }

    function printCheckboxEL($params, $args)
    {
        extract($params);
        $input = "";
        //1 es seleccionado - 0 Sin seleccionar
        if($args['sess'][$record['ct_id']] == 0){
            if($args['sorteo_ct'][$record['ct_id']] == 1){
                if($args['sorteo_sup'][$record['ct_id']] == 1){
                    $input = '<span class="check_select_el"><input type="checkbox" name="selected_el" value="' . $record['ct_id'] . '" id="table-selected-el_' . $record['ct_id'] . '" onclick="procesarEl(' . $record['ct_id'] . ',this)" disabled="disabled" class="selected_el"></span>';
                }
                else{
                    $input = '<span class="check_select_el"><input type="checkbox" name="selected_el" value="' . $record['ct_id'] . '" id="table-selected-el_' . $record['ct_id'] . '" onclick="procesarEl(' . $record['ct_id'] . ',this)" class="selected_el"></span>';
                }
            }
            else{
                $input = '<span class="check_select_el"><input type="checkbox" name="selected_el" value="' . $record['ct_id'] . '" id="table-selected-el_' . $record['ct_id'] . '" onclick="procesarEl(' . $record['ct_id'] . ',this)" disabled="disabled" class="selected_el"></span>';
            }
        }
        else{
            $input = '<span class="check_select_el"><input type="checkbox" name="selected_el" value="' . $record['ct_id'] . '" id="table-selected-el_' . $record['ct_id'] . '" checked="checked" onclick="procesarEl(' . $record['ct_id'] . ',this)" class="selected_el"></span>';
        }

        return $input;
    }

    function printCheckboxSEL($params, $args)
    {
        extract($params);
        $input = "";
        //1 es seleccionado - 0 Sin seleccionar
        if($args['sess'][$record['ct_id']] == 0){
            $input = '<input type="checkbox" name="selected_el" value="' . $record['ct_id'] . '" id="table-selected-el_' . $record['ct_id'] . '" onclick="procesarEl(' . $record['ct_id'] . ',this)" class="selected_el">';
        }
        else{
            $input = '<input type="checkbox" name="selected_el" value="' . $record['ct_id'] . '" id="table-selected-el_' . $record['ct_id'] . '" checked="checked" onclick="procesarEl(' . $record['ct_id'] . ',this)" class="selected_el">';
        }

        return $input;
    }

    function getSeleccionados($params, $args)
    {
        extract($params);

        //1 es seleccionado - 0 Sin seleccionar
        if($args['sess'][$record['ct_id']] == 1){
            return 'X';
        }
    }
