<?php
	ob_start();
	require_once('../config/web.config');
	require_once(AUTHFILE);
	require_once(CFG_PATH.'/smarty.config');
	require_once(CFG_PATH.'/data.config');
	// links
	require_once('home.config');
	// PEAR
	require_once(INC_PATH.'/pear.inc');
	require_once(INC_PATH.'/comun.php');
	require_once(INC_PATH.'/grilla.php');
        include_once('MDB2.php');

        $config = PEAR::getStaticProperty("DB_DataObject",'options');
        $mdb2 =& MDB2::connect($config['database']);

        if (PEAR::isError($mdb2)) {
            die($mdb2->getMessage());
        }


        //echo $sql = "SELECT cortesxct_causa, cortesxct_id FROM cortes_por_ct GROUP BY cortesxct_causa";
        echo $sql = "SELECT cortesxct_desc_elem_mt_rep, cortesxct_id FROM cortes_por_ct GROUP BY cortesxct_desc_elem_mt_rep";
        echo "<br>";
        $res = $mdb2->query($sql);

        if (PEAR::isError($res)) {
            echo $sql;
            die($res->getMessage());
        }

        $cortesxct_causas = array();
        $no_encontrados = array();

         while($fila = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
             $cortesxct_causas[$fila['cortesxct_id']] = $fila['cortesxct_desc_elem_mt_rep'];
         }

//         var_dump($cortesxct_causas);
//         exit;

         foreach($cortesxct_causas as $key => $cort){
              echo $sql = "SELECT elemento_id FROM elemento_mt WHERE elemento_descripcion LIKE '".$cort."%' LIMIT 1";
             //echo $sql = "SELECT tipocau_id FROM tipo_causa WHERE tipocau_descripcion LIKE '".$cort."%' LIMIT 1";
             echo "<br />";
             $res = $mdb2->query($sql);

             if (PEAR::isError($res)) {
                 echo $sql;
                 die($res->getMessage());
             }

             if($res->numRows() > 0){
                 $row = $res->fetchRow(MDB2_FETCHMODE_ASSOC);
                 echo $sql = "UPDATE cortes_por_ct SET cortesxct_desc_elem_mt_rep_id = ".$row['elemento_id']." WHERE cortesxct_desc_elem_mt_rep = '".$cort."'";
                 echo "<br>";
                 $res = $mdb2->query($sql);

                 if (PEAR::isError($res)) {
                     echo $sql;
                     die($res->getMessage());
                 }
             }
             else{
                 //No encontro ese dato
                 $no_encontrados[] = ($cort);
             }
         }
var_dump($no_encontrados);
echo "finalizado para cortes x ct";
ob_end_flush();
exit;

//Estos elementos no estan para cortesxct_desc_elem_mt_int
/*
array
0 => string 'Aislador MN y otros' (length=19)
1 => string 'Cable convencional Cu / Al' (length=26)
2 => string 'Cable Preensamblado' (length=19)
3 => string 'Cable Subterraneo' (length=17)
4 => string 'Columna Hº Aº' (length=15)
5 => string 'Conector Preens. Línea/Acometida' (length=33)
6 => string 'Cruceta / Mensula de madera / Hº Aº' (length=37)
7 => string 'Descargador' (length=11)
8 => string 'Fusible BT' (length=10)
9 => string 'Grampa de conex paral / deriv' (length=29)
10 => string 'Porta fusible' (length=13)
11 => string 'Poste de madera' (length=15)
12 => string 'Puente / Pie de gallo' (length=21)
13 => string 'Terminal / Empalme de cable subterraneo' (length=39)
14 => string 'Transformador' (length=13)

//Estos elementos no estan para cortesxct_desc_elem_mt_rep
 *
 * array
  0 => string 'Aislador MN y otros' (length=19)
  1 => string 'Cable convencional Cu / Al' (length=26)
  2 => string 'Cable Preensamblado' (length=19)
  3 => string 'Cable Subterraneo' (length=17)
  4 => string 'Columna Hº Aº' (length=15)
  5 => string 'Conector Preens. Línea/Acometida' (length=33)
  6 => string 'Cruceta / Mensula de madera / Hº Aº' (length=37)
  7 => string 'Descargador' (length=11)
  8 => string 'Fusible BT' (length=10)
  9 => string 'Grampa de conex paral / deriv' (length=29)
  10 => string 'Porta fusible' (length=13)
  11 => string 'Poste de madera' (length=15)
  12 => string 'Puente / Pie de gallo' (length=21)
  13 => string 'Terminal / Empalme de cable subterraneo' (length=39)
  14 => string 'Transformador' (length=13)


*/

?>
