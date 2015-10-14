<?php
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// PEAR
	require_once(INC_PATH.'/pear.inc');
	require_once(INC_PATH.'/comun.php');
	//DB_DataObject::debugLevel(5);
	
	function getFechaWS() {
		return date('Y-m-d H:i:s',time());
	}		
	/*
	* Funcion que devuelve la distribuidora a la que pertenece un usuario
	* parametros: user // usuario del cual quiero buscar la distribuidora a la que pertenece
	*/
	function distribuidora_usuario($user)
	{	
		$do = DB_DataObject::factory('usuario');
		$do->usua_usrid = $user;
		if (!$do->find(true))
			return 'Error: usuario no encontrado';
				
		$do_usuario_empresa = DB_DataObject::factory('usuario_empresa');
		$do_usuario_empresa -> usremp_usua_id = $do->usua_id;
		
		if ($do_usuario_empresa->find(true))
		{
		$do_empresa = DB_DataObject::factory('empresas');
		$do_empresa ->emp_id  = $do_usuario_empresa-> usremp_emp_id;			 
		$do_empresa->find(true);
		
		return $do_empresa->emp_cod_oceba; // devuelve el codigo oceba de la empresa a la que pertenece el user
		}
	}

	function distribuidora_nombre($user)
	{

		$do = DB_DataObject::factory('usuario');
		$do->usua_usrid = $user;
		if (!$do->find(true))
			return 'Error: usuario no encontrado';

		$do_usuario_empresa = DB_DataObject::factory('usuario_empresa');
		$do_usuario_empresa -> usremp_usua_id = $do->usua_id;

		if ($do_usuario_empresa->find(true))
		{
			$do_empresa = DB_DataObject::factory('empresas');
			$do_empresa ->emp_id  = $do_usuario_empresa-> usremp_emp_id;
			$do_empresa->find(true);
			return $do_empresa->emp_nombre; // devuelve el codigo oceba de la empresa a la que pertenece el user
		}
	}
		
	// Funcion que devuelve los tipos de archivos de la tabla Tipos_archivo en un array	
	function tipos_archivo_en_array()
	{	
		$tipos=array();		
		$do_tipo_archivo = DB_DataObject::factory('tipo_archivo');
		$do_tipo_archivo->whereAdd("tipoarch_fecha_baja is NULL");
		$do_tipo_archivo->whereAdd("tipoarch_ddt_id is not NULL");
		$do_tipo_archivo->orderBy('tipoarch_descripcion');
//		BD_DataObject::debugLebel();
		if ($do_tipo_archivo-> find())
		{
			while ($do_tipo_archivo->fetch())
			{
				 $aux['id']=$do_tipo_archivo->tipoarch_id;
				 $aux['cod']=$do_tipo_archivo->tipoarch_codigo;
				 $aux['desc']=utf8_decode($do_tipo_archivo->tipoarch_descripcion);
				 $aux['prefijo'] = $do_tipo_archivo->tipoarch_prefijo;
				 $aux['periodo'] = $do_tipo_archivo->tipoarch_periodo;
				 $tipos[]=$aux;
			}
			
		}			
		return $tipos; // array cargado con los tipos de archivo
	}
	function tipos_distribuidoras() {
	    $tipos = array();
	    $do_tipo_dist = DB_DataObject::factory('empresas');
	    $do_tipo_dist->orderBy("emp_nombre");
	    if($do_tipo_dist-> find()) {
		while($do_tipo_dist->fetch()){
		    $aux['id'] = $do_tipo_dist->emp_id;
		    $aux['codigo'] = $do_tipo_dist->emp_cod_oceba;
		    $aux['nombre'] = $do_tipo_dist->emp_nombre;
		    $tipos[]=$aux;
		}
	    }
	    return $tipos;
	}
		
	/*
	* Funcion que devuelva los prefijos de los tipos de archivos de la tabla Tipos_archivo en un array de la siguiente forma:
	* Array ( 0 => array ('tipo_archivo' => tipoarch_descripcion, 'prefijo' => tipoarch_prefijo)
	*		... => ...  );
	*/	
	function prefijos_tipo_archivos()
	{
		$prefijos= array();
		$do_tipo_archivo = DB_DataObject::factory('tipo_archivo');		
		$do_tipo_archivo->orderBy('tipoarch_descripcion');
		if ($do_tipo_archivo->find(true))
		{
			while ($do_tipo_archivo->fetch())
			{
				$prefijos[]= array('tipo_archivo' => utf8_decode($do_tipo_archivo->tipoarch_descripcion), 
									'prefijo' => $do_tipo_archivo->tipoarch_prefijo);
			}
		}			
		return $prefijos; //array cargado
	}

	/** Funcion que devuelva un arreglo con el formato de los archivos de la siguiente forma:
	* $tipos[]= array('tipo_archivo' => $do_tipo_archivo->tipoarch_descripcion, 'prefijo' =>);
	* Array ( 0 => array ( 'tipo_archivo' => tipoarch_descripcion,'formato' => array( 0 => array ('columna' => colcamp_columna_nro, 'tipo_dato' => colcamp_tipo_datos),
	*											... => ...)
	*										),
	*			... => ...
	*			
	*			);
	*	Ejemplo:
	*	Array ( 0 => 
	*				array ( 'tipo_archivo' => 'Mediciones CT', 
	*						'formato' => array( 0 => array ('columna' => 0, 'tipo_dato' => integer),
	*											1 => array ('columna' => 1, 'tipo_dato' => string)			
	*								  )
	*					  ),
	*			1 => 
	*				array ( 'tipo_archivo' => 'Mediciones Clientes', 
	*						'formato' => array( 0 => array ('columna' => 0, 'tipo_dato' => integer),
	*											1 => array ('columna' => 1, 'tipo_dato' => string)					
	*								  )
	*						)
	*			);
	*/
		
	function formato($tipo_archivo=null)
	{	
		if (!$tipo_archivo)
			return 'Cod de archivo no ingresado';
		
		$formato= array();
		
		$do_tipo_archivo = DB_DataObject::factory('tipo_archivo');
		$do_tipo_archivo->tipoarch_codigo = $tipo_archivo;
		$do_tipo_archivo->orderBy('tipoarch_descripcion');
		$do_tipo_archivo->whereAdd('tipoarch_fecha_baja is null or tipoarch_fecha_baja ="0000-00-00 00:00"');
		
		$formato = array();
		if ($do_tipo_archivo->find(true))
		{
			$campoSem = null;
			//Busco en el diccionario de datos el campo que representa el semestre para la tabla del tipo de archivo
						
			$do_columnas_campos = DB_DataObject::factory('columnas_campos');
			$do_columnas_campos->colcamp_tipoarch_id = $do_tipo_archivo->tipoarch_id; 
			$do_columnas_campos->orderBy('colcamp_columna_nro');
			$do_columnas_campos->limit($do_tipo_archivo->tipoarch_cant_columnas);
			$do_columnas_campos->find();
			$datos=array(); // redefino el vector para que no quede basura 
								
			while ($do_columnas_campos->fetch())	
			{		
				$esSem = '0';
				if ($do_tipo_archivo->tipoarch_col_semestre == $do_columnas_campos->colcamp_columna_nro)
					$esSem = '1';
				
				$esEmp = '0';
				if ($do_tipo_archivo->tipoarch_col_empresa == $do_columnas_campos->colcamp_columna_nro)
					$esEmp = '1';
					
				$datos[]=array(
					'columna'=>$do_columnas_campos->colcamp_columna_nro,
					'tipo_dato'=>$do_columnas_campos->colcamp_tipo_datos,
					'vacio' => $do_columnas_campos->colcamp_vacio,
					'semestre' => $esSem, 
					'empresa' => $esEmp, 
					'descripcion'=>$do_columnas_campos->colcamp_descripcion);
			}
			$formato[]= array (
				'tipo_archivo'=>utf8_decode($do_tipo_archivo->tipoarch_descripcion),
				'formato'=>$datos
			);				
		}
		if ($formato)  	
			return $formato; // retorna el vector $formato cargado
		else
			return 'Datos no encontrados';
	}

	// En base a una empresa traer los nombres de los semestres de la misma
	function emp_sem($cod_empresa)
	{
		$do_empresa = DB_DataObject::factory('empresas');
		$do_empresa -> emp_cod_oceba = $cod_empresa;
		if($do_empresa->find(true))
		{	
			$do_semestres = DB_DataObject::factory('semestres');
			$do_semestres -> sem_tdist_id = $do_empresa -> emp_tdist_id;
			$do_semestres ->find();
			if($do_semestres->N > 0) {
				while ($do_semestres->fetch()) 
				{	
					return $do_semestres->sem_nombre;
				}
			}
		}
	}
	
	function user_info($user) {
		require_once('../inc/Encript.class.php');	
		$ftp = parse_ini_file('../config/ftp.ini');
		$do = DB_DataObject::factory('usuario');
		$do->usua_usrid = $user;
		if (!$do->find(true))
			return 'Error: usuario no encontrado';
		foreach ($ftp as $k => $dato) {
			$enc[$k] = Encript::EncriptarCadena($dato);
		}
		return implode('%',$enc);		
	}
?>