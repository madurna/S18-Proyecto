function allOPAP(flag)
    {
        if (flag == 0)
        {
            $(".selected_op").attr('checked', false);

                chequeados = new Array();
                $('.check_select input').each(function(index) {
                    chequeados[index] = $(this).val();
                });

                valores = eval(chequeados);



            $.ajax(
                {
                    dataType: "html",
                    type: "POST",

                    // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
                    url: "op_apertura_varios.php?check=1&valores="+valores,

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
        else
        {
            $(".selected_op").attr('checked', true);

            chequeados = new Array();
            $('.check_select input').each(function(index) {
                chequeados[index] = $(this).val();
            });

            valores = eval(chequeados);

            
            	$.ajax(
                {
                dataType: "html",
                type: "POST",

                // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
                url: "op_apertura_varios.php?check=0&valores="+valores,

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
    }


function procesarOPAP(op_id,obj){
 	//Usando JQUERY, obtengo el value del option seleccionado de la lista paises.    
    var check = obj.checked;
    if(check){
        check = 1;

        $("#table-selected-op_"+ op_id).attr('checked', true);

    }
    else{
        check = 0;
        //Usando JQUERY,
        $("#table-selected-op_"+ op_id).attr('checked', false);
    }

	$.ajax(
		{
		dataType: "html",
		type: "POST",

		// ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
		url: "op_apertura_procesa.php?op_id=" + op_id + "&check=" + check,
            
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

function resetChecks(obj){
	
	//Semestre y empresa
	emp = ($('#empresa').val());
	sem = ($('#sem').val());
		
	if(obj == 1){
		$(".selected_op").attr('checked', false);
	}
	
        $.ajax(
	{
	   dataType: "html",
            type: "POST",

            // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
            url: "resetChecks.php?emp=" + emp + "&sem=" + sem,

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

