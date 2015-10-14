function cambiar_estado(aplicacion,rol,modulo,tipoacc,accion){
	
	if (accion == "mostrar"){
		//modifico el valor y titulo del checkbox que llamo a la funcion
		campo = "estado[" + modulo + "][" + tipoacc + "]";
		obj_campo = document.getElementById(campo);
		if (obj_campo.value == '1'){
			obj_campo.value = "0";
			obj_campo.setAttribute('title','No tiene permiso');
		}
		else{
			obj_campo.value = "1";
			obj_campo.setAttribute('title','Tiene permiso');
		}
	}
	
	//EL ORDEN DE LOS TIPOS DE ACCESO ES : ACCESO = 4 ; ALTA = 1 ; BAJA = 3 ; MODIFICACION = 2
	
	//variables con los valores originales de los checkbox de tipo de acceso
	//ALTA
	var no_tp1 = "estado_original[" + modulo + "][1]";
	var vo_tp1 = document.getElementById(no_tp1).value;
	//MODIFICACION
	var no_tp2 = "estado_original[" + modulo + "][2]";
	var vo_tp2 = document.getElementById(no_tp2).value;
	//BAJA
	var no_tp3 = "estado_original[" + modulo + "][3]";
	var vo_tp3 = document.getElementById(no_tp3).value;
	//ACCESO
	var no_tp4 = "estado_original[" + modulo + "][4]";
	var vo_tp4 = document.getElementById(no_tp4).value;
	
	//variables con los valores actuales de los checkbox de tipo de acceso
	//ALTA
	var na_tp1 = "estado[" + modulo + "][1]";
	var va_tp1 = document.getElementById(na_tp1).value;
	//MODIFICACION
	var na_tp2 = "estado[" + modulo + "][2]";
	var va_tp2 = document.getElementById(na_tp2).value;
	//BAJA
	var na_tp3 = "estado[" + modulo + "][3]";
	var va_tp3 = document.getElementById(na_tp3).value;
	//ACCESO
	var na_tp4 = "estado[" + modulo + "][4]";
	var va_tp4 = document.getElementById(na_tp4).value;
	//TILDAR TODOS
	var nom_tildar = "tildar[" + modulo + "]";
	var tildar = document.getElementById(nom_tildar);

	//muestro el boton de GUARDAR
	if (accion == "mostrar"){
		//campo en donde se va a mostrar el GUARDAR
		nombre_campo_guardar = "modificar_permiso[" + modulo + "]";
		obj = document.getElementById(nombre_campo_guardar);
		
		//si hay algun cambio entre los valores de los checkbox y los valores originales (que estan en un hidden) muestro el boton
		if ( (vo_tp1 !== va_tp1) || (vo_tp2 !== va_tp2) || (vo_tp3 !== va_tp3) || (vo_tp4 !== va_tp4) ){
			obj.setAttribute('type','button');
		}
		else{
			//oculto el boton
			obj.setAttribute('type','hidden');
		}
		
		//tildo o destildo el campo checkbox para tildar todos
		if ( (va_tp1 == '1') && (va_tp2 == '1') && (va_tp3 == '1') && (va_tp4 == '1')){
			tildar.checked = true;
			tildar.value = "1";
			tildar.setAttribute('title','Todos los permisos');
		}
		else{
			tildar.checked = false;
			tildar.value = "0";
			tildar.setAttribute('title','');
		}
		
	}
	else{
		if (accion == "eliminar"){
			//AJAX AL PHP QUE VA A MODIFICAR
		 	$.ajax({
			type: "POST",
			url: "../permisos/eliminar_permiso.php",
			//EL ORDEN DE LOS TIPOS DE ACCESO ES : ACCESO = 4 ; ALTA = 1 ; BAJA = 3 ; MODIFICACION = 2
			data: "app_id="+aplicacion+"&rol_id="+rol+"&mod_id="+modulo+"&vo_tp4="+vo_tp4+"&va_tp4="+va_tp4+"&vo_tp1="+vo_tp1+"&va_tp1="+va_tp1+"&vo_tp3="+vo_tp3+"&va_tp3="+va_tp3+"&vo_tp2="+vo_tp2+"&va_tp2="+va_tp2 ,
				success: function( respuesta ){
							alert(respuesta);
							nombre_campo_guardar = "modificar_permiso[" + modulo + "]";
							document.getElementById(nombre_campo_guardar).setAttribute('type','hidden');
	
							if (respuesta == "Modificacion exitosa"){
								//cambio los valores de los hidden de los tipos de acceso
								document.getElementById(no_tp4).value = document.getElementById(na_tp4).value;
								document.getElementById(no_tp1).value = document.getElementById(na_tp1).value;
								document.getElementById(no_tp3).value = document.getElementById(na_tp3).value;
								document.getElementById(no_tp2).value = document.getElementById(na_tp2).value;
							}
						}
			});
		}
		else{
			//tildo o destildo todos los checkbox del modulo
			alta = document.getElementById(na_tp1);
			modificacion = document.getElementById(na_tp2);
			baja = document.getElementById(na_tp3);
			acceso = document.getElementById(na_tp4);
			
			if (tildar.checked){
				alta.checked = true;
				alta.value = "1";
				alta.setAttribute('title','Tiene permiso');
				modificacion.checked = true;
				modificacion.value = "1";
				modificacion.setAttribute('title','Tiene permiso');
				baja.checked = true;
				baja.value = "1";
				baja.setAttribute('title','Tiene permiso');
				acceso.checked = true;
				acceso.value = "1";
				acceso.setAttribute('title','Tiene permiso');
				tildar.value = "1";
				tildar.setAttribute('title','Todos los permisos');
			}
			else{
				alta.checked = false;
				alta.value = "0";
				alta.setAttribute('title','No tiene permiso');
				modificacion.checked = false;
				modificacion.value = "0";
				modificacion.setAttribute('title','No tiene permiso');
				baja.checked = false;
				baja.value = "0";
				baja.setAttribute('title','No tiene permiso');
				acceso.checked = false;
				acceso.value = "0";
				acceso.setAttribute('title','No tiene permiso');
				tildar.value = "0";
				tildar.setAttribute('title','Ningun permiso');
			}
			
			va_tp1 = document.getElementById(na_tp1).value;
			va_tp2 = document.getElementById(na_tp2).value;
			va_tp3 = document.getElementById(na_tp3).value;
			va_tp4 = document.getElementById(na_tp4).value;
						
			//campo en donde se va a mostrar el GUARDAR
			nombre_campo_guardar = "modificar_permiso[" + modulo + "]";
			obj = document.getElementById(nombre_campo_guardar);
			
			//si hay algun cambio entre los valores de los checkbox y los valores originales (que estan en un hidden)
			if ( (vo_tp1 !== va_tp1) || (vo_tp2 !== va_tp2) || (vo_tp3 !== va_tp3) || (vo_tp4 !== va_tp4) ){
				obj.setAttribute('type','button');
			}
			else{
				obj.setAttribute('type','hidden');
			}		
			
		}
	}
}