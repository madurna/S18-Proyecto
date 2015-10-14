<?php
	ob_start();
	require_once('../config/web.config');
	require_once(AUTHFILE);
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('estadistico.config');
	// PEAR
	require_once(INC_PATH.'/pear.inc');
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/grilla.php');
    
	// Librerias propias
	$_SESSION['menu_principal'] = 9;
  		
	$tpl = new tpl();
	$tpl->assign('webTitulo', WEB_TITULO);
	$tpl->assign('secTitulo', WEB_SECCION);
	$tpl->assign('menu', "menu_oceba.htm");
	$tpl->assign('links', $links1);

	$do_convenio = DB_DataObject::factory('convenio');
	$convenios = $do_convenio -> get_convenio_todos();

    $do_view_estadistica_cantidad_empresa_convenio= DB_DataObject::factory('view_estadistica_cantidad_empresa_convenio');
    $do_view_estadistica_cantidad_empresa_convenio -> find();
	while ( $do_view_estadistica_cantidad_empresa_convenio -> fetch() ){
      	 
        $empresa = $do_view_estadistica_cantidad_empresa_convenio -> empleado_empresa_id;
        $convenio = $do_view_estadistica_cantidad_empresa_convenio -> convenio_id;

        $data_empresa[$empresa] += $do_view_estadistica_cantidad_empresa_convenio -> cantidad_empleados;
        $data_convenio[$convenio] += $do_view_estadistica_cantidad_empresa_convenio -> cantidad_empleados;
        $data_emp_convenio[$convenio][$empresa] += $do_view_estadistica_cantidad_empresa_convenio -> cantidad_empleados;

    }
    //print_r($data_emp_convenio);
    for($i=1;$i<=5;$i++){
   		for($j=1;$j<=14;$j++){
   			if($data_emp_convenio[$i][$j])
    			$mostrar_empresa_convenio[$i].=$data_emp_convenio[$i][$j].',';
    		else
    			$mostrar_empresa_convenio[$i].='0,';
   		}
    }

    //print_r($mostrar_empresa_convenio);

    for($i=1;$i<=5;$i++)
    	$data_convenio_total+=$data_convenio[$i];

   // print_r($data_empresa);
    //print($data_convenio[5]/$data_convenio_total);
	$body = "

		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'></script>
		<script type='text/javascript' src='../js/jquery-1.4.2.min.js'></script>
		<script type='text/javascript' src='../js/jquery-ui-1.8.4.custom.min.js'></script>
		<script src='../js/highcharts.js'></script>
		<script src='../js/modules/exporting.js'></script>

		<div>
			<div id='container1' style=' float: left; min-width: 50%; height: 200px; max-width: 50%;'></div>
			<div id='container2' style=' float: right; min-width: 50%; height: 200px; max-width: 50%;'></div>
		<div>
		<div id='container3' style=' float: right; width:100%; height:auto;  margin: 0px'></div>
		
		<script>
		///Cantidad de empleados por convenio
			$(function () {

			    // Make monochrome colors and set them as default for all pies
			    Highcharts.getOptions().plotOptions.pie.colors = (function () {
			        var colors = [],
			            base = Highcharts.getOptions().colors[0],
			            i;

			        for (i = 0; i < 10; i += 1) {
			            // Start out with a darkened base color (negative brighten), and end
			            // up with a much brighter color
			            colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
			        }
			        return colors;
			    }());

			    // Build the chart
			    $('#container1').highcharts({
			        chart: {
			            plotBackgroundColor: null,
			            plotBorderWidth: null,
			            plotShadow: false
			        },
			        title: {
			            text: 'Empleados por convenio'
			        },
			        tooltip: {
			            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			        },
			        plotOptions: {
			            pie: {
			                allowPointSelect: true,
			                cursor: 'pointer',
			                dataLabels: {
			                    enabled: true,
			                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
			                    style: {
			                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			                    }
			                }
			            }
			        },
			        series: [{
			            type: 'pie',
			            name: 'Cantidad de empleados ',
			            data: [
			                ['".$convenios[1]."( ".$data_convenio[1]." )"."', ".$data_convenio[1]/$data_convenio_total."],
			                ['".$convenios[2]."( ".$data_convenio[2]." )"."', ".$data_convenio[2]/$data_convenio_total."],
			                ['".$convenios[3]."( ".$data_convenio[3]." )"."', ".$data_convenio[3]/$data_convenio_total."],
			                ['".$convenios[4]."( ".$data_convenio[4]." )"."', ".$data_convenio[4]/$data_convenio_total."],
			                ['".$convenios[5]."( ".$data_convenio[5]." )"."', ".$data_convenio[5]/$data_convenio_total."],
			            ]
			        }]
			    });
			});

			///Cantidad de empleados por empresa

			$(function () {

			    // Make monochrome colors and set them as default for all pies
			    Highcharts.getOptions().plotOptions.pie.colors = (function () {
			        var colors = [],
			            base = Highcharts.getOptions().colors[0],
			            i;

			        for (i = 0; i < 10; i += 1) {
			            // Start out with a darkened base color (negative brighten), and end
			            // up with a much brighter color
			            colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
			        }
			        return colors;
			    }());

			    // Build the chart
			    $('#container2').highcharts({
			        chart: {
			            plotBackgroundColor: null,
			            plotBorderWidth: null,
			            plotShadow: false
			        },
			        title: {
			            text: 'Empleados por empresa'
			        },
			        tooltip: {
			            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			        },
			        plotOptions: {
			            pie: {
			                allowPointSelect: true,
			                cursor: 'pointer',
			                dataLabels: {
			                    enabled: true,
			                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
			                    style: {
			                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			                    }
			                }
			            }
			        },
			        series: [{
			            type: 'pie',
			            name: 'Empleados',
			            data: [
			            	{
			                    name: 'A.R.H.F. - ADMINISTRACION',
			                    y: 0,
			                    sliced: true,
			                    selected: true
			                },
			                ['A.R.H.F. - TAFI VIEJO',   0],
			                ['SAN MARTIN',       ".$data_empresa[2]/$data_convenio_total."],
			                ['MITRE',    0],
			                ['ROCA',     ".$data_empresa[1]/$data_convenio_total."],
			                ['BELGRANO SUR',   ".$data_empresa[3]/$data_convenio_total."],
			                ['BELGRANO CARGAS ( T )',    0],
			                ['URQUIZA/SM CARGAS',     0],
			                ['BELGRANO NORTE ( T )',   0],
			                ['TREN DE LA COSTA',    0],
			                ['SOFSE ENTRE RIOS',     0],
			                ['SOFSE ONCE BRAGADO',   0],
			                ['SARMIENTO',     0],
			                ['SARMIENTO F. DE CONVENIO',   0]
			            ]
			        }]
			    });
			});

			/////Cantidad de empleados por convenio/empresa

			$(function () {
			    $('#container3').highcharts({
			        chart: {
			            type: 'bar'
			        },
			        title: {
			            text: 'Empleados por convenio/empresa'
			        },
			        xAxis: {
			            categories: ['ROCA','SAN MARTIN', 'BELGRANO SUR', 'A.R.H.F. - ADMINISTRACION', 'A.R.H.F. - TAFI VIEJO', 'MITRE', 
			            'BELGRANO CARGAS ( T )','URQUIZA/SM CARGAS', 'BELGRANO NORTE ( T )','TREN DE LA COSTA', 'SOFSE ENTRE RIOS',
			            'SOFSE ONCE BRAGADO','SARMIENTO', 'SARMIENTO F. DE CONVENIO',]
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Empleados'
			            }
			        },
			        legend: {
			            reversed: true
			        },
			        plotOptions: {
			            series: {
			                stacking: 'normal'
			            }
			        },
			        series: 
			        [
					        {
					            name: '".$convenios[1]."',
					            data: [".$mostrar_empresa_convenio[1]."]
					        }, {
					            name: '".$convenios[2]."',
					            data: [".$mostrar_empresa_convenio[2]."]
					        }, {
					            name: '".$convenios[3]."',
					            data: [".$mostrar_empresa_convenio[3]."]
					        }, {
					            name: '".$convenios[4]."',
					            data: [".$mostrar_empresa_convenio[4]."]
					        }, {
					            name: '".$convenios[5]."',
					            data: [".$mostrar_empresa_convenio[5]."]
					        }
			        ]
			    });
			});
		</script>

	";

	$tpl->assign('body', $body);
	$tpl->assign('usuario',$_SESSION['usuario']['nombre']);
	$tpl->display('index.htm');
	ob_end_flush();
	exit;
?>

