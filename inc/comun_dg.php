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

    //obrero

        //Localidad
    function get_loca_obrero($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['obrero_localidad_id']!=null)
        {
            $do = DB_DataObject::factory('localidad');
            $do->get($record['obrero_localidad_id']);
            return $do->localidad_nombre;
        }
        else
            return '-';
    }

        //Provincia
    function get_prov_obrero($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['obrero_localidad_id']!=null)
        {
            $do = DB_DataObject::factory('localidad');
            $do_p = DB_DataObject::factory('provincia');
            $do -> joinAdd($do_p);
            $do->get($record['obrero_localidad_id']);
            return $do->provincia_nombre;
        }
        else
            return '-';
    }
    
    //Apellido
    function get_ape_obrero($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['obrero_apellido']!=null)
        {
            return utf8_encode($record['obrero_apellido']);
        }
        else
            return '-';
    }
    
    //Nombre
    function get_nom_obrero($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['obrero_nombre']!=null)
        {
            return utf8_encode($record['obrero_nombre']);
        }
        else
            return '-';
    }
    
    //Direccion
    function get_dire_obrero($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['obrero_direccion']!=null)
        {
            if (mb_detect_encoding($record['obrero_direccion']) == '')
                return utf8_encode($record['obrero_direccion']);
                else
                return $record['obrero_direccion'];
        }
        else
            return '-';
    }
    
    //Documento
    function get_doc_obrero($vals,$args) {
        extract($vals);
        extract($args);
        if ($record['obrero_tipo_doc_id']!=null)
        {
            $do = DB_DataObject::factory('tipo_documento');
            $do->get($record['obrero_tipo_doc_id']);
            return $do->tipo_doc_descripcion.' '.$record['obrero_nro_doc'];
        }
        else
            return '-';
    }

    //fin obrero
	
	//Reparticion
	function get_repa($vals,$args) {
		extract($vals);
		extract($args);
		if ($record['cliente_reparticion_id']!=null)
		{
			$do = DB_DataObject::factory('reparticion');
			$do->get($record['cliente_reparticion_id']);
			return $do->reparticion_descripcion;
		}
		else
			return '-';
	}
	
	//Estado
	function get_estado($vals,$args) {
		extract($vals);
		extract($args);
		if ($record['cliente_estado_id']!=null)
		{
			$do = DB_DataObject::factory('estado');
			$do->get($record['cliente_estado_id']);
			return $do->estado_descripcion;
		}
		else
			return '-';
	}
	
	function getResultadoMedicion($vals,$args){
		extract($vals);
		extract($args);
        if ($record['medct_resultado'])    	{
        	$res = $record['medct_resultado'];
        }
        elseif ($record['medcli_resultado'])    	{
        	$res = $record['medcli_resultado'];
        }
		//0: Satisfactorio 1: Penaliza 2:Fallido
		switch($res) {
			case 0:
				$val = 'Satisfactorio';
				break;
			case 1:
				$val = 'Penaliza';
				break;
			case 2:
				$val = 'Fallido';
				break;
		}
		return $val;
	}

	function getSemestreNombre($vals,$args){
		extract($vals);
		extract($args);
        if ($record['sortct_sem_id'])
        	{
        	$semestres = DB_DataObject::factory('semestres');
        	$semestres -> sem_id = $record['sortct_sem_id'];
        	if($semestres->find(true))
        		$rta=$semestres->sem_nombre;
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}


	function getTarifa($vals,$args){
		extract($vals);
		extract($args);
        if ($record['cli_tarifa_id'])
        	{
        	$tarifas = DB_DataObject::factory('tarifa');
        	$tarifas -> tarifa_id = $record['cli_tarifa_id'];
        	if($tarifas->find(true))
        		$rta=$tarifas->tarifa_nombre;
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
	
	
		
	function getCodigoOcebaCliente($vals,$args){
		extract($vals);
		extract($args);
        if ($record['sortcli_cod_oceba'])
            return $record['sortcli_cod_oceba'];
        else
            return '<p>'.$record[$id].'</p>';
	}



	function getIdCliente($vals,$args){
		extract($vals);
		extract($args);
        if ($record['sortcli_id'])
            return $record['sortcli_id'];
        else
            return '<p>'.$record[$id].'</p>';
	}

	function getDesde($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id])
        	{
        	$semestres = DB_DataObject::factory('semestres');
        	$semestres -> sem_id = $record[$id];
        	if($semestres->find(true))
        		$rta=getFecha($semestres->sem_fechaDesde);
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
	
		function getFechaInstalacionCT($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id])
        	{
        	$cronct -> cronct_id = $record[$id];
        	if($cronct != null)
        		$rta=getFecha($cronct->cronct_fecha_instalacion);
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
	
	function getFechaRetiroCT($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id])
        	{
        	$cronct = DB_DataObject::factory('cronograma_ct');
        	$cronct -> cronct_id = $record[$id];
        	if($cronct->find(true))
        		$rta=getFecha($cronct->cronct_fecha_retiro);
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
	
	function getFechaInstalacionCli($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id])
        	{
        	$croncli = DB_DataObject::factory('cronograma_clientes');
        	$croncli -> croncli_id = $record[$id];
        	if($croncli->find(true))
        		$rta=getFecha($croncli->croncli_fecha_instalacion);
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
	
	function getFechaRetiroCli($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id])
        	{
        	$croncli = DB_DataObject::factory('cronograma_clientes');
        	$croncli -> croncli_id = $record[$id];
        	if($croncli->find(true))
        		$rta=getFecha($croncli->croncli_fecha_retiro);
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
	
	/*
	function getDesdeCli($vals,$args){
		extract($vals);
		extract($args);
        if ($record['sortcli_sem_id'])
        	{
        	$semestres = DB_DataObject::factory('semestres');
        	$semestres -> sem_id = $record['sortcli_sem_id'];
        	if($semestres->find(true))
        		$rta=getFecha($semestres->sem_fechaDesde);
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}*/

	function getHasta($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id])
        	{
        	$semestres = DB_DataObject::factory('semestres');
        	$semestres -> sem_id = $record[$id];
        	if($semestres->find(true))
        		$rta=getFecha($semestres->sem_fechaHasta);
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}

	
	
		
	/*
	function getHastaCli($vals,$args){
		extract($vals);
		extract($args);
        if ($record['sortcli_sem_id'])
        	{
        	$semestres = DB_DataObject::factory('semestres');
        	$semestres -> sem_id = $record['sortcli_sem_id'];
        	if($semestres->find(true))
        		$rta=getFecha($semestres->sem_fechaHasta);
        		return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}*/

	function getPtoRed($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id] == '0')
        	{$rta='No';
        	 return $rta;
        	}
		if ($record[$id] == '1')
        	{$rta='Si';
        	 return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}

	function getTipo($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id] == '0')
        	{$rta='Titular';
        	 return $rta;
        	}
		if ($record[$id] == '1')
        	{$rta='Suplente';
        	 return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}

	/*
	function getTipoCli($vals,$args){
		extract($vals);
		extract($args);
        if ($record['sortcli_alternativo'] == '0')
        	{$rta='Titular';
        	 return $rta;
        	}
		if ($record['sortcli_alternativo'] == '1')
        	{$rta='Suplente';
        	 return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}*/
	/*
	function getCodCt($vals,$args){
		extract($vals);
		extract($args);
        if ($record['sortct_id'])
        	{

        	$centros_de_transformacion = DB_DataObject::factory('centros_de_transformacion');
        	$centros_de_transformacion -> sortct_id = $record['sortct_id'];
        	$sucursal = DB_DataObject::factory('sucursal');
        	$centros_de_transformacion->ct_suc_id= $sucursal ->suc_id;
        	if($centros_de_transformacion->find(true))
        		{
        		$rta=$centros_de_transformacion->ct_codigo;
        		return $rta;
        		}
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
	*/

	/*
	function getCodSum($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id])
        	{
        	$clientes = DB_DataObject::factory('clientes');
        	$clientes -> cli_id = $record[$id];
        	if($clientes->find(true))
        		{
        		$rta=$clientes->cli_cod_suministro;
        		return $rta;
        		}
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}*/

	/*
	function getCodMedCli($vals,$args){
		extract($vals);
		extract($args);
        if ($record['sortcli_id'])
        	{

        	$clientes = DB_DataObject::factory('clientes');
        	$clientes -> cli_id = $record['sortcli_id'];

        	if($clientes->find(true))
        		{
        		$rta=$clientes->cli_nro_medidor;
        		return $rta;
        		}
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}*/
	
	/*
	function getCodMedCt($vals,$args){
		extract($vals);
		extract($args);
        if ($record['sortct_id'])
        	{

        	$clientes = DB_DataObject::factory('clientes');
        	$clientes -> cli_id = $record['sortct_id'];

        	if($clientes->find(true))
        		{
        		$rta=$clientes->cli_nro_medidor;
        		return $rta;
        		}
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}*/

	function getPenalizado($vals,$args){
			extract($vals);
		extract($args);
        if ($record[$id] == '0')
        	{
        		$rta='Satisfactorio';
        		//$rta='<img alt="No" src="../img/spirit20_icons/system-delete-alt-02.png">';
        	 return $rta;
        	}
		if ($record[$id] == '1')
        	{
        		$rta='Penalizado';
        		//$rta='<img alt="Si" src="../img/spirit20_icons/system-tick-alt-03.png">';
        	 return $rta;
        	}
		
        	
        else
            return '<p>'.$record[$id].'</p>';
	}	


	function getResultado($vals,$args){
			extract($vals);
		extract($args);
        if ($record[$id] == '0')
        	{
        		$rta='Satisfactorio';
        		//$rta='<img alt="No" src="../img/spirit20_icons/system-delete-alt-02.png">';
        	 return $rta;
        	}
		if ($record[$id] == '1')
        	{
        		$rta='Penalizado';
        		//$rta='<img alt="Si" src="../img/spirit20_icons/system-tick-alt-03.png">';
        	 return $rta;
        	}
		if ($record[$id] == '2')
        	{
        		$rta='Fallido';
        		//$rta='<img alt="Si" src="../img/spirit20_icons/system-tick-alt-03.png">';
        	 return $rta;
        	}
        	
        else
            return '<p>'.$record[$id].'</p>';
	}	
	
	
	function getPublicado($vals,$args){
			extract($vals);
		    extract($args);
        if ($record[$id] == '0')
        	{$rta= '<img alt="No" src="../img/spirit20_icons/system-delete-alt-02.png">';
        	 return $rta;
        	}
		if ($record[$id] == '1')
        	{$rta= '<img alt="Si" src="../img/spirit20_icons/system-tick-alt-03.png">';
        	 return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
	
	function getPublicado2($vals,$args){
			extract($vals);
		    extract($args);
        if ($record[$id] == '0')
        	{$rta= 'No';
        	 return $rta;
        	}
		if ($record[$id] == '1')
        	{$rta= 'Si';
        	 return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}

	function getAlternativoCliente($vals,$args){
			extract($vals);
		extract($args);
        if ($record['sortcli_alternativo'] == '0')
        	{$rta='No';
        	 return $rta;
        	}
		if ($record['sortct_alternativo'] == '1')
        	{$rta='Si';
        	 return $rta;
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}


	function getCronograma($vals,$args){
		extract($vals);
		extract($args);
		$aux = $args['aux'];
		$emp = $args['emp'];
		$sem = $args['sem'];
        if ($record[$id])
        {
        	$rta='<a href="../cronogramas/cronogramas.php?cont='.$aux.'&data[0]='.$emp.'&data[1]='.$sem.'"><img alt="Si" src="../img/spirit20_icons/system-tick-alt-03.png"></a>';
        	
        }
        else {
        	$rta='<img alt="No" src="../img/spirit20_icons/system-delete-alt-02.png">';
        }
        	
        return $rta;
	}
	
	function getCronograma2($vals,$args){
		extract($vals);
		extract($args);
		$aux = $args['aux'];
		$emp = $args['emp'];
		$sem = $args['sem'];
        if ($record[$id])
        {
        	$rta='Si';
        	
        }
        else {
        	$rta='No';
        }
        	
        return $rta;
	}

	function getMedido($vals,$args){
		extract($vals);
		extract($args);
        $aux = $args['aux'];
		$emp = $args['emp'];
		$sem = $args['sem'];
		
		
		if ($record[$id])
		{
		if((!$aux) or ($aux == 'ct'))
			{
			if ($record['sortct_id__key'])
				$id = 'sortct_id__key';
				$mediciones = DB_DataObject::factory('mediciones_ct');
        	$mediciones -> medct_sortct_id = $record[$id];
        	}
		if($aux == 'usuario')		
			{
			if ($record['sortcli_id__key'])
				$id = 'sortcli_id__key';
       		$mediciones = DB_DataObject::factory('mediciones_clientes');
       		$mediciones -> medcli_sortcli_id = $record[$id];
        	}
        if($mediciones->find(true))
        	{
        		//print_r($record[$id]."<br />");
			$rta='<a href="../mediciones/mediciones.php?cont='.$aux.'&data[0]='.$emp.'&data[1]='.$sem.'"><img alt="Si" src="../img/spirit20_icons/system-tick-alt-03.png"></a>';
        	return $rta;
        	}
        else
        	{
        		
        	$rta='<img alt="No" src="../img/spirit20_icons/system-delete-alt-02.png">';
         	return $rta;
        	}
		}
        else
            return '<p>'.$record[$id].'</p>';
	}
	
	function getMedido2($vals,$args){
		extract($vals);
		extract($args);
        $aux = $args['aux'];
		$emp = $args['emp'];
		$sem = $args['sem'];
		
		
		if ($record[$id])
		{
		if((!$aux) or ($aux == 'ct'))
			{
			if ($record['sortct_id__key'])
				$id = 'sortct_id__key';
				$mediciones = DB_DataObject::factory('mediciones_ct');
        	$mediciones -> medct_sortct_id = $record[$id];
        	}
		if($aux == 'usuario')		
			{
			if ($record['sortcli_id__key'])
				$id = 'sortcli_id__key';
       		$mediciones = DB_DataObject::factory('mediciones_clientes');
       		$mediciones -> medcli_sortcli_id = $record[$id];
        	}
        if($mediciones->find(true))
        	{
        		//print_r($record[$id]."<br />");
			$rta='Si';
        	return $rta;
        	}
        else
        	{
        		
        	$rta='No';
         	return $rta;
        	}
		}
        else
            return '<p>'.$record[$id].'</p>';
	}

        /**
     * Calcula el acumulado de acuerdo a la fecha actual
     * @param array $vals
     * @param array $args
     */

    function getAcumulado($vals,$args)
    {
        extract($vals);
        extract($args);
        $fecha_retiro = null;
        $credito = null;

        if($args['tipo'] == 'ct'){
            $fecha_retiro = ($record['medct_fecha_inst']);
            $credito = $record['medct_credito'];
        }
        elseif($args['tipo'] == 'cli'){
            $fecha_retiro = ($record['medcli_fecha_inst']);
            $credito = $record['medcli_credito'];
        }
        else{
            return "No hay acumulado para calcular";
        }

        $fecha_hoy = ($args['fecha_hoy']);

        $cant_semamas = date("W",strtotime($fecha_hoy) - strtotime($fecha_retiro));
        $valor_multa_acumulado = number_format(($credito * $cant_semamas),2);
        return $valor_multa_acumulado;
    }

    function cantSemanas($vals,$args)
    {
        extract($args);
        extract($vals);
        $fecha_retiro = null;
        $cant_semanas = 0;

        if($args['tipo'] == 'ct'){
            $fecha_retiro = ($record['medct_fecha_inst']);
        }
        elseif($args['tipo'] == 'cli'){
            $fecha_retiro = ($record['medcli_fecha_inst']);
        }
        else{
            return "No hay acumulado para calcular";
        }

        $fecha_hoy = ($args['fecha_hoy']);
		
		$cant_semanas = date("W",strtotime($fecha_hoy) - strtotime($fecha_retiro));
        return $cant_semanas;
    }

    function getCredito($vals,$args){
        extract($vals);
        extract($args);
        return number_format($record[$id],2);
    }
    
    function getDatosCliente($val,$args) {
		$record = $val['record'];
		$xls = $args['xls'];
		if($xls){
			if($args['dato'] == 'cli'){
				return $record['cli_titular'];
			}
			else{
				return $record['ct_codigo'];
			}
		} else {
		    if($args['dato'] == 'cli'){
				return '<a href="'.$record['cli_id'].'|'.$args['dato'].'" name="modal">'.htmlentities($record['cli_titular']).'</a>';
			}	
			else{
				return '<a href="'.$record['ct_id'].'|'.$args['dato'].'" name="modal">'.$record['ct_codigo'].'</a>';
			}
		}
    }
    
    
    
    
    /*
    function getCodSum($vals,$args){
        extract($vals);
        extract($args);
       if ($record['sortct_cli_id'])
        {

           $clientes = DB_DataObject::factory('clientes');
           $clientes -> cli_id = $record['sortct_cli_id'];

           if($clientes->find(true))
           {
                $rta=$clientes->cli_cod_suministro;
                return $rta;
           }
        }
        else
        return '<p>'.$record[$id].'</p>';
   }*/

//    function getCodCt($vals,$args){
//        extract($vals);
//        extract($args);
//        if ($record['sortct_id'])
//        {
//
//            $centros_de_transformacion = DB_DataObject::factory('centros_de_transformacion');
//            $centros_de_transformacion -> sortct_id = $record['sortct_id'];
//            $sucursal = DB_DataObject::factory('sucursal');
//            $centros_de_transformacion->ct_suc_id= $sucursal ->suc_id;
//            if($centros_de_transformacion->find(true))
//            {
//                $rta=$centros_de_transformacion->ct_codigo;
//                return $rta;
//            }
//        }
//        else
//        return '<p>'.$record[$id].'</p>';
//    }
//
//
//    function getPtoRed($vals,$args){
//        extract($vals);
//        extract($args);
//        if ($record['sortct_pto_red'] == '0')
//        {$rta='Si';
//            return $rta;
//        }
//        if ($record['sortct_pto_red'] == '1')
//        {$rta='No';
//            return $rta;
//        }
//        else
//        return '<p>'.$record[$id].'</p>';
//    }
//
//    function getCodSum($vals,$args){
//        extract($vals);
//        extract($args);
//        if ($record['sortct_cli_id'])
//        {
//
//            $clientes = DB_DataObject::factory('clientes');
//            $clientes -> cli_id = $record['sortct_cli_id'];
//
//            if($clientes->find(true))
//            {
//                $rta=$clientes->cli_cod_suministro;
//                return $rta;
//            }
//        }
//        else
//        return '<p>'.$record[$id].'</p>';
//    }


    //*************************Funciones***************************************

//    function getCodigoOceba($vals,$args){
//        extract($vals);
//        extract($args);
//        if ($record['medcli_sortcli_id'])
//        {
//            $sorteo_cliente = DB_DataObject::factory('sorteos_clientes');
//            $sorteo_cliente -> sortcli_id = $record['medcli_sortcli_id'];
//            if($sorteo_cliente->find(true))
//            $rta=$sorteo_cliente->sortcli_cod_oceba;
//            return $rta;
//        }
//        else
//        return '<p>'.$record[$id].'</p>';
//    }

//    function getCodigoOcebaCt($vals,$args){
//        extract($vals);
//        extract($args);
//        if ($record['medct_sortct_id'])
//        {
//            $sorteo_ct = DB_DataObject::factory('sorteos_ct');
//            $sorteo_ct -> sortct_id = $record['medct_sortct_id'];
//            if($sorteo_ct->find(true))
//            $rta=$sorteo_ct->sortct_cod_oceba;
//            return $rta;
//        }
//        else
//        return '<p>'.$record[$id].'</p>';
//    }

//    function getArchivoCli($vals,$args){
//        extract($vals);
//        extract($args);
//        if ($record['medcli_arch_id'])
//        {
//            $archivo = DB_DataObject::factory('archivos_importacion');
//            $archivo -> arch_id = $record['medcli_arch_id'];
//            if($archivo->find(true))
//            $rta=$archivo->arch_path;
//            return $rta;
//        }
//        else
//        return '<p>'.$record[$id].'</p>';
//    }
//
//    function getArchivoCt($vals,$args){
//        extract($vals);
//        extract($args);
//        if ($record['medct_arch_id'])
//        {
//            $archivo = DB_DataObject::factory('archivos_importacion');
//            $archivo -> arch_id = $record['medct_arch_id'];
//            if($archivo->find(true))
//            $rta=$archivo->arch_path;
//            return $rta;
//        }
//        else
//        return '<p>'.$record[$id].'</p>';
//    }


    //*************************Funciones***************************************

    function getCodigoOceba($vals,$args){
        extract($vals);
        extract($args);
        if ($record['medcli_sortcli_id'])
        {
            $sorteo_cliente = DB_DataObject::factory('sorteos_clientes');
            $sorteo_cliente -> sortcli_id = $record['medcli_sortcli_id'];
            if($sorteo_cliente->find(true))
            $rta=$sorteo_cliente->sortcli_cod_oceba;
            return $rta;
        }
        else
        return '<p>'.$record[$id].'</p>';
    }

    function getCodigoOcebaCt($vals,$args){
        extract($vals);
        extract($args);
        if ($record['medct_sortct_id'])
        {
            $sorteo_ct = DB_DataObject::factory('sorteos_ct');
            $sorteo_ct -> sortct_id = $record['medct_sortct_id'];
            if($sorteo_ct->find(true))
            $rta=$sorteo_ct->sortct_cod_oceba;
            return $rta;
        }
        else
        return '<p>'.$record[$id].'</p>';
    }

    function getArchivoCli($vals,$args){
        extract($vals);
        extract($args);
        if ($record['medcli_arch_id'])
        {
            $archivo = DB_DataObject::factory('archivos_importacion');
            $archivo -> arch_id = $record['medcli_arch_id'];
            if($archivo->find(true))
            $rta=$archivo->arch_path;
            return $rta;
        }
        else
        return '<p>'.$record[$id].'</p>';
    }

    function getArchivoCt($vals,$args){
        extract($vals);
        extract($args);
        if ($record['medct_arch_id'])
        {
            $archivo = DB_DataObject::factory('archivos_importacion');
            $archivo -> arch_id = $record['medct_arch_id'];
            if($archivo->find(true))
            $rta=$archivo->arch_path;
            return $rta;
        }
        else
        return '<p>'.$record[$id].'</p>';
    }

    function verArchivo($vals,$args)
    {
        extract($vals);
        extract($args);
        return '<a href="../ver_archivos_importacion/index.php?empresa='.$record[$emp].'&tipo_archivo='.$record[$arch].'">[Ver&nbsp;Archivo]</a>';
        
    }
	function dgVerNombreEmpresa($val,$arg) { 		
		$do_emp = DB_DataObject::factory('empresas');
		$do_emp->emp_id = $val['record'][$arg['id']];
		if ($do_emp->find(true)) return $do_emp->emp_nombre; else return '';
	}
	
	
    function getPromedioCredito($vals,$args)
    {
        extract($args);
        extract($vals);
        return number_format(($record['medcli_credito']/$args['total_mediciones']),2);
    }

    function getPromedioAcumulado($vals,$args)
    {
        $total_multa_acumulado = 0;
        $total_multa_acumulado = (float) str_replace(',', '', getAcumulado($vals,$args));
        extract($args);
        extract($vals);

        return number_format(($total_multa_acumulado/$args['total_mediciones_semestre']),2);
    }

    //funciones excel
    function getCronogramaExcel($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id])
        	{
        	$cronograma = DB_DataObject::factory('cronograma_ct');
        	$cronograma -> cronct_sortct_id = $record[$id];
        	if($cronograma->find(true))
        		{
        		$rta='Si';
        		return $rta;
        		}
        	else
        		{$rta='No';
        	 	 return $rta;}
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
   
	function getMedidoExcel($vals,$args){
		extract($vals);
		extract($args);
        if ($record[$id])
        	{
        	$mediciones = DB_DataObject::factory('mediciones_ct');
        	$mediciones -> medct_sortct_id = $record[$id];
        	if($mediciones->find(true))
        		{
        		$rta='Si';
        		return $rta;
        		}
        	else
        		{$rta='No';
        	 	 return $rta;}
        	}
        else
            return '<p>'.$record[$id].'</p>';
	}
	
	function getTieneError($vals,$args){
	    extract($vals);
	    extract($args);
	    if($record[$id] != '0'){
	        return "$record[$id]";
	    }
	    else{
	        return "Sin&nbsp;error";
	    }
	    
	}
	
	function getDist($vals,$args){
		extract($vals);
		extract($args);
        $sucursales = DB_DataObject::factory('deporte');
        $sucursales -> id_deporte = $args['id'];
        if($sucursales->find(true)){
        		$rta=$sucursales->nombre;
        		return $rta;
        	}
	}

    //ECO RECICLAR  
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

    //fin obrero
	

?>
