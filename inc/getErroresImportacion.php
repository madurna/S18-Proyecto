<?

function getErroresUnzip($nro) {
switch ($nro) {
	case 1: return "el nombre de archi descripto en el .ini difiere del nombre del archivo fisico";
	case 2: return "no coincide el codigo de seguridad";
	case 3: return "el tipo de archivo no existe";
	case 4: return "no existe el usuario";
	case 5: return "el directorio no existe y no se pudo crear";
	case 6: return "no se puede abrir el archivo";
	case 7: return "el archivo no es importable";
	case 8: return "el tipo de archivo esta dado de baja";
	case 12: return "no se pudo copiar el archivo al directorio de destino";
}
}
//ini_get('register_argc_argv');
//echo getErroresUnzip($_SERVER['argv'][1]);