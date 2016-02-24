<?php
	//Localidad
	function get_loca($vals,$args) {
		extract($vals);
		extract($args);
		if ($record['cliente_localidad_id']!=null)
		{
			$do = DB_DataObject::factory('localidad');
			$do->get($record['cliente_localidad_id']);
			return $do->localidad_nombre;
		}
		else
			return '-';
	}
	
	//Apellido
	function get_ape($vals,$args) {
		extract($vals);
		extract($args);
		if ($record['cliente_apellido']!=null)
		{
			return utf8_encode($record['cliente_apellido']);
		}
		else
			return '-';
	}
	
	//Nombre
	function get_nom($vals,$args) {
		extract($vals);
		extract($args);
		if ($record['cliente_nombre']!=null)
		{
			return utf8_encode($record['cliente_nombre']);
		}
		else
			return '-';
	}
	
	//Direccion
	function get_dire($vals,$args) {
		extract($vals);
		extract($args);
		if ($record['cliente_direccion']!=null)
		{
			if (mb_detect_encoding($record['cliente_direccion']) == '')
				return utf8_encode($record['cliente_direccion']);
				else
				return $record['cliente_direccion'];
		}
		else
			return '-';
	}
	
	//Documento
	function get_doc($vals,$args) {
		extract($vals);
		extract($args);
		if ($record['cliente_tipo_doc_id']!=null)
		{
			$do = DB_DataObject::factory('tipo_documento');
			$do->get($record['cliente_tipo_doc_id']);
			return $do->tipo_doc_descripcion.' '.$record['cliente_nro_doc'];
		}
		else
			return '-';
	}

    //Empleado

    //Apellido
    function get_ape_empleado($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['empleado_apellido']!=null)
        {
            return utf8_encode($record['empleado_apellido']);
        }
        else
            return '-';
    }
    
    //Nombre
    function get_nom_empleado($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['empleado_nombre']!=null)
        {
            return utf8_encode($record['empleado_nombre']);
        }
        else
            return '-';
    }
    
    //Direccion
    function get_dire_empleado($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['empleado_direccion']!=null)
        {
            if (mb_detect_encoding($record['empleado_direccion']) == '')
                return utf8_encode($record['empleado_direccion']);
                else
                return $record['empleado_direccion'];
        }
        else
            return '-';
    }
    
    //Documento
    function get_doc_empleado($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['empleado_tipo_doc_id']!=null)
        {
            $do = DB_DataObject::factory('tipo_documento');
            $do->get($record['empleado_tipo_doc_id']);
            return $do->tipo_doc_descripcion.' '.$record['empleado_nro_doc'];
        }
        else
            return '-';
    }

        //Localidad
    function get_loca_empleado($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['empleado_localidad_id']!=null)
        {
            $do = DB_DataObject::factory('localidad');
            $do->get($record['empleado_localidad_id']);
            return $do->localidad_nombre;
        }
        else
            return '-';
    }

        //Provincia
    function get_prov_empleado($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['empleado_localidad_id']!=null)
        {
            $do = DB_DataObject::factory('localidad');
            $do_p = DB_DataObject::factory('provincia');
            $do -> joinAdd($do_p);
            $do->get($record['empleado_localidad_id']);
            return $do->provincia_nombre;
        }
        else
            return '-';
    }

    //fin empleado
?>