<?php
/**
 * Table Definition for planta_pieza
 */
require_once 'DB/DataObject.php';

class DataObjects_Planta_pieza extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'planta_pieza';        // table name
    public $planta_pieza_id;                 // int(11)  not_null primary_key auto_increment group_by
    public $planta_pieza_tipo;               // int(11)  not_null group_by
    public $planta_pieza_trommel_diametro;    // float(12)  group_by
    public $planta_pieza_largo;              // float(12)  group_by
    public $planta_pieza_motor;              // char(45)  
    public $planta_pieza_plano;              // char(45)  
    public $planta_pieza_relacionEngranaje;    // float(12)  group_by
    public $planta_pieza_alto;               // float(12)  group_by
    public $planta_pieza_ancho;              // float(12)  group_by
    public $planta_pieza_bomba;              // char(45)  
    public $planta_pieza_cilindro;           // char(45)  
    public $planta_pieza_comando;            // char(45)  
    public $planta_pieza_fonfo;              // int(11)  group_by
    public $planta_pieza_kilajeMax;          // int(11)  group_by
    public $planta_pieza_material;           // char(45)  
    public $planta_pieza_tipoCinta;          // char(45)  
    public $id_planta;                       // int(11)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
