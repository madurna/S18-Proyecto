function mostrarUSCT(tipo){
 	//Usando JQUERY, obtengo el value del option seleccionado de la lista paises.
        var empresa_id = $("#empresas").val();
		var cant_cli_min = '';
		if ($("#valorevaluarminusua")) {
			cant_cli_min = $("#valorevaluarminusua").val();
		}
 /*  
cantsem_pequ
cantsem_gran
cantsem*/
	$.ajax(
		{
		dataType: "html",
		type: "POST",

		// ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
		url: "mostrarUSCT.php?empresa_id=" + empresa_id + "&tipo=" + tipo + "&cant_cli_min=" + cant_cli_min,

        		//Usando JQUERY, Mostramos el mensaje cargando en la lista regiones. (un efecto visual)
            beforeSend: function(data){ 
			$("#dialogtexto-sel").html('<br /><br /><img src="../img/ajax-loader.gif" alt="" /><br />');
             $("#mensaje_select-sel").html('<br /><br /><img src="../img/ajax-loader.gif" alt="" /><br />');
            //Tambi�n puedes poner aqui el gif que indica cargando...
            },

        		//Llamada exitosa
		success: function(requestData){
			//Usando JQUERY, Cargamos las regiones del pais
			/*$("#ciudad_id").removeAttr("disabled");*/
			//$("#mensaje_select").html(requestData);
                     

                    if(tipo == 'CT'){
						mens_cant_ct = '';
						var sin_cadena = false;
						$.ajax(
							{
								dataType: "html",
								type: "POST",
								async: false,
								url: "../datos/ultimaCadenaElectrica.ajax.php?empresa_id=" + empresa_id,
								success: function(requestData2){
									if (!requestData2) {
										sin_cadena = true;										
									}
								}
							}
						);
						
						requestDataTotalCT = $.ajax(
							{
								dataType: "html",
								type: "POST",
								async: false,
								url: "../datos/get_total_ct_emp.ajax.php?empresa_id=" + empresa_id
							}
						)
						
						mens_cant_ct += '<b>Centros de transformación (Total en BD): </b>' + requestDataTotalCT.responseText + '<br /><br />';
						if (sin_cadena) 
							mens_cant_ct += '<b><img src="../img/adv.png" /> Advertencia no hay cadena eléctrica disponible</b><br /><br />';						
						
						mens_cant_ct += '<b>Total a sortear</b>: ' + requestData + '<br />';
						                       
                        //Me fijo si esta seleccionado porcentaje o cantidad
                        //Titulares
                        selec_porc_cant = $("input:radio[name='selec_porc_cant']:checked").val();
                        porc_cant = $('#valorevaluar').val();

						selec_cant_min = $("input[name='selec_cant_min']").val();
					    						
                        if(selec_porc_cant == 'porc'){
                            //calc_porc_cant = Math.round((requestData * porc_cant)/100);
                            calc_porc_cant = Math.ceil(requestData * (porc_cant/100));
							if ((requestData > 0) & (calc_porc_cant < selec_cant_min))
								calc_porc_cant = selec_cant_min
								
                            mens_calc_porc_cant = 'Titulares seleccionados: ' + calc_porc_cant;
                        }
                        else{
                            calc_porc_cant = porc_cant;
                            if(requestData == 0){
                                porc_cant = 0;
                            }

                            mens_calc_porc_cant = 'Titulares seleccionados: ' + porc_cant;
                        }

                        //Suplentes
                        selec_porc_cant_sup = $("input:radio[name='selec_porc_cant_sup']:checked").val();
                        porc_cant_sup = $('#valorevaluarsup').val();

                        if(selec_porc_cant_sup == 'porc'){
                            //calc_porc_cant_sup = Math.round(((requestData - calc_porc_cant)  * porc_cant_sup)/100); 
                            calc_porc_cant_sup = Math.ceil(requestData  * (porc_cant_sup/100)); 
                            mens_calc_porc_cant_sup = '<br />Suplentes seleccionados: ' + calc_porc_cant_sup;
                        }
                        else{
                            if(requestData == 0){
                                porc_cant_sup = 0;
                            }
                            mens_calc_porc_cant_sup = '<br />Suplentes seleccionados: ' + porc_cant_sup;
                        }

/*                        valorevaluarmin = $('#valorevaluarmin').val();
                        mens_valorevaluarmin = '<br />Cantidad mínima a seleccionar: ' + valorevaluarmin;
                        valorevaluarsuc = $('#valorevaluarsuc').val();
                        mens_valorevaluarsuc = ', Cantidad mínima por sucursal: ' +  valorevaluarsuc;

                        cantsem_ct = $('#cantsem_ct').val();
                        mens_no_selec_sem = '<br />No seleccionar C.T. para la cantidad de semestres: ' + cantsem_ct;*/

                        //Extremos de linea
                        mens_cant_el = '.<br /><br /><b>Extremos de linea</b> <br />';
                        selec_porc_cant_el = $("input:radio[name='selec_porc_cant_el']:checked").val();
                        porc_cant_el = $('#valorevaluarel').val();

                        if(selec_porc_cant_el == 'porc'){
                            //calc_porc_cant_el = Math.round((requestData * porc_cant_el)/100);
                            calc_porc_cant_el = Math.ceil(calc_porc_cant * (porc_cant_el/100));
                            mens_calc_porc_cant_el = 'E.L. seleccionados: ' + calc_porc_cant_el;
                        }
                        else{
                            mens_calc_porc_cant_el = 'E.L. seleccionados: ' + porc_cant_el;
                        }

/*                        valorevaluarminel = $('#valorevaluarminel').val();
                        mens_valorevaluarminel = ', Cantidad mínima a seleccionar: ' + valorevaluarminel + '.';*/

                        //mensaje = mens_cant_ct + mens_calc_porc_cant + mens_calc_porc_cant_sup + mens_valorevaluarmin + mens_valorevaluarsuc +  mens_no_selec_sem + mens_cant_el + mens_calc_porc_cant_el + mens_valorevaluarminel;
                        mensaje = mens_cant_ct + mens_calc_porc_cant + mens_calc_porc_cant_sup + mens_cant_el + mens_calc_porc_cant_el;

                        if(requestData == 0){
                            alert("No hay centros de transformacion para esa empresa");
                            $('a[name=modal]').hide();
                        }
                        else{
                            $('a[name=modal]').show();
                        }

                        $("#dialogtexto-sel").html(mensaje);
                        
                }
                else {
                       var myObject = eval('(' + requestData + ')');
                       cant_pequ = myObject['pequ'];
                       cant_gran = myObject['gran'];

                        if(cant_gran == 0 && cant_pequ == 0){
                             alert("No hay pequeñas ni grandes demandas para esa empresa");
                             $('a[name=modal]').hide();
                        }
                        else if(cant_pequ == 0){
                            alert("No hay pequeñas demandas para esa empresa");
                            $('a[name=modal]').show();
                        }
                        else if(cant_gran == 0){
                             alert("No hay grandes demandas para esa empresa");
                             $('a[name=modal]').show();
                        }
                        else{
                            $('a[name=modal]').show();
                        }

                        mens_cant_pequ = '<b>Pequeñas demandas: ' + cant_pequ + '</b><br />';
                       
                        //Pequeños
                        selec_porc_cant_pequ = $("input:radio[name='selec_porc_cant_pequ']:checked").val();
                        porc_cant_pequ = $('#valorevaluar_pequ').val();
                       
					    selec_cant_min_pequ = $("input[name='selec_cant_min_pequ']").val();
					   
                        if(selec_porc_cant_pequ == 'porc'){
                           // calc_porc_cant_pequ = Math.round((cant_pequ * porc_cant_pequ)/100);
                            calc_porc_cant_pequ = Math.ceil(cant_pequ * (porc_cant_pequ/100));
							if ((cant_pequ > 0) &(calc_porc_cant_pequ < selec_cant_min_pequ))
								calc_porc_cant_pequ = selec_cant_min_pequ
                            mens_calc_porc_cant_pequ = 'Usuarios seleccionados: ' + calc_porc_cant_pequ;
                        }
                        else{
                            if(cant_pequ == 0){
                                porc_cant_pequ = 0;
                            }
                            mens_calc_porc_cant_pequ = 'Usuarios seleccionados: ' + porc_cant_pequ;
                        }

/*                       valorevaluarmin_pequ = $('#valorevaluarmin_pequ').val();
                       mens_valorevaluarmin_pequ = '<br />Cantidad mínima a seleccionar: ' + valorevaluarmin_pequ;

                       valorevaluarsuc_pequ = $('#valorevaluarsuc_pequ').val();
                       mens_valorevaluarsuc_pequ = ', Cantidad mínima por sucursal: ' +  valorevaluarsuc_pequ;*/

                       //Suplentes pequeños
                       selec_porc_cant_sup_pequ = $("input:radio[name='selec_porc_cant_sup_pequ']:checked").val();
                       valorevaluarsup_pequ = $('#valorevaluarsup_pequ').val();

                       if(selec_porc_cant_sup_pequ == 'porc'){
                            //calc_porc_cant_sup_pequ = Math.round(((cant_pequ - calc_porc_cant_pequ)  * valorevaluarsup_pequ)/100);
                            calc_porc_cant_sup_pequ = Math.ceil((cant_pequ)  * (valorevaluarsup_pequ/100));
                            mens_calc_porc_cant_sup_pequ = '<br />Suplentes seleccionados: ' + calc_porc_cant_sup_pequ;
                        }
                        else{
                            if(cant_pequ == 0){
                                valorevaluarsup_pequ = 0;
                            }
                            mens_calc_porc_cant_sup_pequ = '<br />Suplentes seleccionados: ' + valorevaluarsup_pequ;
                        }

/*                       cantsem_pequ = $('#cantsem_pequ').val();
                       mens_no_selec_sem_pequ = '<br />No seleccionar usuarios para la cantidad de semestres: ' + cantsem_pequ; */


                       mens_cant_gran = '<br /><br /><b>Grandes demandas: ' + cant_gran + '</b><br />';

                        //Grandes
                        selec_porc_cant_gran = $("input:radio[name='selec_porc_cant_gran']:checked").val();
                        porc_cant_gran = $('#valorevaluar_gran').val();

						selec_cant_min_gran = $("input[name='selec_cant_min_gran']").val();
					   
						
                        if(selec_porc_cant_gran == 'porc'){
                            //calc_porc_cant_gran = Math.round((cant_gran * porc_cant_gran)/100);
                            calc_porc_cant_gran = Math.ceil(cant_gran * (porc_cant_gran/100));
							if ((cant_gran > 0) & (calc_porc_cant_gran < selec_cant_min_gran))
								calc_porc_cant_gran = selec_cant_min_gran
                            mens_calc_porc_cant_gran = 'Usuarios seleccionados: ' + calc_porc_cant_gran;
                        }
                        else{
                            if(cant_gran == 0){
                                porc_cant_gran = 0;
                            }
                            mens_calc_porc_cant_gran = 'Usuarios seleccionados: ' + porc_cant_gran;
                        }

/*                       valorevaluarmin_gran = $('#valorevaluarmin_gran').val();
                       mens_valorevaluarmin_gran = '<br />Cantidad mínima a seleccionar: ' + valorevaluarmin_gran;

                       valorevaluarsuc_gran = $('#valorevaluarsuc_gran').val();
                       mens_valorevaluarsuc_gran = ', Cantidad mínima por sucursal: ' +  valorevaluarsuc_gran; */

                       //Suplentes pequeños
                       selec_porc_cant_sup_gran = $("input:radio[name='selec_porc_cant_sup_gran']:checked").val();
                       valorevaluarsup_gran = $('#valorevaluarsup_gran').val();

                       if(selec_porc_cant_sup_gran == 'porc'){
                            //calc_porc_cant_sup_gran = Math.round(((cant_gran - calc_porc_cant_gran)  * valorevaluarsup_gran)/100);
                            calc_porc_cant_sup_gran = Math.ceil((cant_gran)  * (valorevaluarsup_gran/100));
                            mens_calc_porc_cant_sup_gran = '<br />Suplentes seleccionados: ' + calc_porc_cant_sup_gran;
                        }
                        else{
                            if(cant_gran == 0){
                                valorevaluarsup_gran = 0;
                            }
                            mens_calc_porc_cant_sup_gran = '<br />Suplentes seleccionados: ' + valorevaluarsup_gran;
                        }

   /*                    cantsem_gran = $('#cantsem_gran').val();
                       mens_no_selec_sem_gran = '<br />No seleccionar usuarios para la cantidad de semestres: ' + cantsem_gran; */

 //                      mensaje = mens_cant_pequ + mens_calc_porc_cant_pequ + mens_valorevaluarmin_pequ + mens_valorevaluarsuc_pequ + mens_calc_porc_cant_sup_pequ + mens_no_selec_sem_pequ + mens_cant_gran + mens_calc_porc_cant_gran + mens_valorevaluarmin_gran + mens_valorevaluarsuc_gran + mens_calc_porc_cant_sup_gran + mens_no_selec_sem_gran;
                       mensaje = mens_cant_pequ + mens_calc_porc_cant_pequ + mens_calc_porc_cant_sup_pequ + mens_cant_gran + mens_calc_porc_cant_gran +  mens_calc_porc_cant_sup_gran;

                       $("#dialogtexto-sel").html(mensaje);
                }
			},

            
 		error: function(requestData, strError, strTipoError){
			alert("Error " + strTipoError +': ' + strError); //En caso de error mostraremos un alert
			},

		//fin de la llamada ajax.
		complete: function(requestData, exito){
			// En caso de usar una gif (cargando...) aqui quitas la imagen
            
            
			}
		}
	);
}