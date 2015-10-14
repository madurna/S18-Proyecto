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
        
   //creo formulario
    $frm = new HTML_QuickForm('frm','get',$_SERVER['REQUEST_URI'],'');

    //arreglo de bruto y neto
    $v_tipo_salida = array('408'=>'Bruto', '409'=>'Neto');

    //nombre    
    $frm ->addElement('select','tipo_salida','Tipo: ',$v_tipo_salida,array('id' => 'tipo_salida'));

    //Años
    $frm ->addElement('select','anio','A&ntilde;o: ',anios(),array('id' => 'anio'));

    $frm -> setDefaults(array('anio' => date('Y')));

    //aceptar y limpiar
    $botones = array();
    $botones[] = $frm->createElement('submit','aceptar','Generar');
    $botones[] = $frm->createElement('reset','restaurar','Limpiar busqueda',array('onClick'=> "javascript: window.location.href='chart_prom_bruto_neto.php';"));
    $frm->addGroup($botones);
    
    $anio = 'A&ntilde;o';

    if ($_GET)
    {
      //traigo datos del form
      $tipo_salida = $_GET['tipo_salida'];
      $anio = $_GET['anio'];
      $aceptar = $_GET['aceptar'];
      //
    }
    
    $tpl = new tpl();
    $tpl->assign('webTitulo', WEB_TITULO);
    $tpl->assign('secTitulo', WEB_SECCION);
    $tpl->assign('menu', "menu_oceba.htm");
    $tpl->assign('links', $links1);

    $v_empresas = array(
                       
                        '4' => 'A.R.H.F. - ADMINISTRACION',
                        '5' => 'A.R.H.F. - TAFI VIEJO',
                        '2' => 'SAN MARTIN',
                        '6' => 'MITRE',
                        '1' => 'ROCA',
                        '3' => 'BELGRANO SUR',
                        '7' => 'BELGRANO CARGAS ( T )',
                        '8' => 'URQUIZA/SM CARGAS',
                        '9' => 'BELGRANO NORTE ( T )',
                        '10' => 'TREN DE LA COSTA',
                        '11' => 'SOFSE ENTRE RIOS',
                        '12' => 'SOFSE ONCE BRAGADO',
                        '13' => 'SARMIENTO',
                        '14' => 'SARMIENTO F. DE CONVENIO'
                );
     


    $body = '<h2>Promedio de empleados por empresa ( '.$anio.' )</h2><br /><div align="center"><br/>'.$frm->toHTML().'</div>';

    if ($aceptar == 'Generar')
    {
        $do_view_estadistica_promedio_neto_bruto= DB_DataObject::factory('view_estadistica_promedio_neto_bruto');

        if ($tipo_salida)
            $do_view_estadistica_promedio_neto_bruto -> whereAdd(" detalle_liquidacion_concepto_id = $tipo_salida");

        if ($anio)
            $do_view_estadistica_promedio_neto_bruto -> whereAdd(" liquidacion_anio = $anio");
        
        $do_view_estadistica_promedio_neto_bruto -> find();

        /*while ( $do_view_estadistica_promedio_neto_bruto -> fetch()){
           
           $empresa = $do_view_estadistica_promedio_neto_bruto -> liquidacion_empresa_id;
           for($i=1;$i<=12;$i++){
                $data[$empresa][$i] = 0;
            }
        }*/
        while ( $do_view_estadistica_promedio_neto_bruto -> fetch()){
            $empresa = $do_view_estadistica_promedio_neto_bruto -> liquidacion_empresa_id;
            $mes = $do_view_estadistica_promedio_neto_bruto -> liquidacion_mes;
            $data[$empresa][$mes] = $do_view_estadistica_promedio_neto_bruto -> detalle_liquidacion_monto_promedio;     
        }

       //print_r($data);
       for($j=1;$j<=14;$j++)
        {
            for($i=1;$i<=12;$i++)
            {
                if ($data[$j][$i]){
                    $mostrar[$j] .= round($data[$j][$i],2).',';
                }else{
                    $mostrar[$j] .= '0,';
                }
            }
        }
       //print_r($mostrar);
    $body .= "
      
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'></script>
        <script type='text/javascript' src='../js/jquery-1.4.2.min.js'></script>
        <script type='text/javascript' src='../js/jquery-ui-1.8.4.custom.min.js'></script>
        <script src='../js/highcharts.js'></script>
        <script src='../js/modules/exporting.js'></script>

        
        <div id='container' style='min-width: 310px; height: 400px; margin: 0 auto'></div>
        
        <script>

            // Carga del tema
            Highcharts.createElement('link', {
               href: '//fonts.googleapis.com/css?family=Dosis:400,600',
               rel: 'stylesheet',
               type: 'text/css'
            }, null, document.getElementsByTagName('head')[0]);

            Highcharts.theme = {
               colors: ['#7cb5ec', '#f7a35c', '#90ee7e', '#7798BF', '#aaeeee', '#ff0066', '#eeaaee',
                  '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
               chart: {
                  backgroundColor: null,
                  style: {
                     fontFamily: 'Dosis, sans-serif'
                  }
               },
               title: {
                  style: {
                     fontSize: '16px',
                     fontWeight: 'bold',
                     textTransform: 'uppercase'
                  }
               },
               tooltip: {
                  borderWidth: 0,
                  backgroundColor: 'rgba(219,219,216,0.8)',
                  shadow: false
               },
               legend: {
                  itemStyle: {
                     fontWeight: 'bold',
                     fontSize: '13px'
                  }
               },
               xAxis: {
                  gridLineWidth: 1,
                  labels: {
                     style: {
                        fontSize: '12px'
                     }
                  }
               },
               yAxis: {
                  minorTickInterval: 'auto',
                  title: {
                     style: {
                        textTransform: 'uppercase'
                     }
                  },
                  labels: {
                     style: {
                        fontSize: '12px'
                     }
                  }
               },
               plotOptions: {
                  candlestick: {
                     lineColor: '#404048'
                  }
               },


               // General
               background2: '#F0F0EA'
               
            };

            // Apply the theme
            Highcharts.setOptions(Highcharts.theme);

            ///finaliza el tema

            $(function () {
                $('#container').highcharts({
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: '".$v_tipo_salida[$tipo_salida]."'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
                    },
                    yAxis: {
                        title: {
                            text: 'Monto ($)'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: [
                    {
                        name: 'A.R.H.F. - ADMINISTRACION',
                        data: [".$mostrar[4]."]
                    }, {
                        name: 'A.R.H.F. - TAFI VIEJO',
                        data: [".$mostrar[5]."]
                    }, {
                        name: 'SAN MARTIN',
                        data: [".$mostrar[2]."]
                    }, {
                        name: 'MITRE',
                        data: [".$mostrar[6]."]
                    }, {
                        name: 'ROCA',
                        data: [".$mostrar[1]."]
                    }, {
                        name: 'BELGRANO SUR',
                        data: [".$mostrar[3]."]
                    }, {
                        name: 'BELGRANO CARGAS ( T )',
                        data: [".$mostrar[7]."]
                    }, {
                        name: 'URQUIZA/SM CARGAS',
                        data: [".$mostrar[8]."]
                    }, {
                        name: 'BELGRANO NORTE ( T )',
                        data: [".$mostrar[9]."]
                    }, {
                        name: 'TREN DE LA COSTA',
                        data: [".$mostrar[10]."]
                    }, {
                        name: 'SOFSE ENTRE RIOS',
                        data: [".$mostrar[11]."]
                    }, {
                        name: 'SOFSE ONCE BRAGADO',
                        data: [".$mostrar[12]."]
                    }, {
                        name: 'SARMIENTO',
                        data: [".$mostrar[13]."]
                    }, {
                        name: 'SARMIENTO F. DE CONVENIO',
                        data: [".$mostrar[14]."]
                    }
                    ]
                });
            });

        </script>

        ";
    }
    
    $tpl->assign('body', $body);
    $tpl->assign('usuario',$_SESSION['usuario']['nombre']);
    $tpl->display('index.htm');
    ob_end_flush();
    exit;
?>

