<?php
/**
 * Table Definition for usuario
 */
require_once 'DB/DataObject.php';

class DataObjects_Usuario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'usuario';             // table name
    public $usua_id;                        // int(11) not_null primary_key auto_increment group_by
    public $usua_usrid;                     // varchar(50) not_null
    public $usua_nombre;                    // varchar(100)
    public $usua_pwd;                       // varchar(32) not_null
    public $usua_email;                     // varchar(100) not_null
    public $usua_tel1;                      // varchar(45)
    public $usua_tel2;                      // varchar(45)
    public $usua_baja;                      // tinyint(1) not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    public $fb_linkDisplayFields = array('usua_usrid');
    
    public $cambiar_clave = false;
    public $cambiar_datos = false;
    
    var $fb_fieldsToRender = array(
    	'usua_id',
     	'usua_usrid',
    	'usua_nombre',
    	'usua_pwd',
    	'usua_email',
    	'usua_tel1',
    	'usua_tel2',
    	'cambiar_clave'
    ); 
    
    //Orden de los campos en el formulario
    var $fb_preDefOrder = array(
    	'usua_usrid',
    	'usua_nombre',
    	'usua_pwd',
    	'usua_email',
    	'usua_tel1',
    	'usua_tel2'
    	    	
    ); 
    
    public $fb_fieldLabels = array (
    'usua_usrid' => 'Nombre Usuario: ',
    'usua_nombre' => 'Nombre Completo: ',
    'usua_pwd' => 'Contrase&ntilde;a: ',
    'usua_email' => 'Mail Usuario: ',
    'usua_tel1' => 'Tel&eacute;fono: ',
    'usua_tel2' => 'Tel&eacute;fono Alternativo: '
    );
    
    public function delete() {
    	$this->query('START TRANSACTION;');
		$do_usuario_rol=DB_DataObject::factory('usuario_rol');
		$do_usuario_rol-> usrrol_usua_id = $this->usua_id;
		$do_usuario_rol->find();
		if($do_usuario_rol->N > 0) {
			while ($do_usuario_rol->fetch()) {					
				$result = $do_usuario_rol->delete();			
				if (!$result)
					break;
			}				
		}
		else {			
			$result = 1;
		}
	
		if ($result==1) {
			$this->usua_baja = 1;
    		parent::update();		
			$this->query('COMMIT;');
			return true;
		}
		else {
			$this->query('ROLLBACK;');
			return false;
		}
    }    
	
    function setUsua_pwd($pwd = null){
    	$this->usua_pwd = md5($pwd);
    }

       /**
     * Genera una nueva clave y la manda por mail
     * @param <integer> $id
     * @param <string> $mail
     */
    public function generarClave($id = 0, $email = null){
        //Nueva clave
        $nueva_pwd = substr(uniqid(),0,6);
        //Busco por id y mail
        $this->usua_id = $id;
        $this->usua_email = $email;

        //Si esta
        if($this->find(true)){
            //Actualizo
            $this->usua_pwd = md5($nueva_pwd);
            $this->update();

            //Envio el mail al usuario
//            $params = array(
//                     'Content-type' => 'text/html; charset=UTF-8\r\n',
//                     'From' => $mail,
//                     'sendmail_path'=> '/usr/lib/sendmail',
//                     'Subject' => 'Su nueva clave - Oceba');
//
//
//            //Creo la instancia
//            $mail = & Mail::factory("mail", $params);
//            if (PEAR::isError($mail)) {
//                echo($mail->getMessage()."<br/>".$nueva_pwd);
//		return false;
//            }
//
//            $body = '
//			<div>
//			<h3>Su nueva clave</h3>
//                        <p>Alguien a solicitado una nueva clave para ingresar al sistema Oceba Calidad</p>
//                        <p>Su nueva clave es: '.$nueva_pwd.'</p>
//                        <p>Ingrese en su panel del sistema Oceba con esta clave y proceda a cambiarla por una de su preferencia.</p>
//                        <p>Cualquier consulta comunicarse con Oceba.</p>
//			</div>';
//
//            //Envio el mail
//
//			try {
//				$eMail = $mail->send($email, $params, $body);
//			}
//			catch (Exception $e)
//			{
//				echo 'Exception caught: ',  $e->getMessage(), "\n", $nueva_pwd;
//			}
//
//            // Chequeo si hay errores
//            if (PEAR::isError($eMail)) {
//                echo($eMail->getMessage()."<br/>".$nueva_pwd);
//				return false;
//            }
            //return true;
            return $nueva_pwd;
        }
    }

	function preGenerateForm(&$fb) {	
		if (($this->usua_id > 0 ) and (!$this->cambiar_clave)  and (!$this->cambiar_datos)){
        		$this->fb_preDefElements['usua_pwd'] = HTML_QuickForm::createElement('html', '<tr><td align="right"><b>Contraseña:</b><br/><br/></td><td><a href="cambiar-clave.php?id='.$this->usua_id.'">[Cambiar clave]</a><br/><br/></td></tr>');
        	}
		//DB_DataObject::debugLevel(5); 
		if ($_GET['accion']=='m'){
			$this -> usua_id = $_GET['contenido'];
			if ($this -> find(true)){
				$estado_actual = $this -> usua_baja;
			}
			if($estado_actual == '1'){
				$estado = array('1'=>'Baja','0'=>'Alta');
			}
			else{
				$estado = array('0'=>'Alta','1'=>'Baja');
			}
			$aux =  HTML_QuickForm::createElement('select', 'usua_baja', 'Estado: ', $estado, array('id' => 'usua_baja'));    		
    		$this -> fb_preDefElements['usua_baja'] = $aux;
    	}
	}
	
	function postGenerateForm(&$frm,&$fb) { 
    	function checkUsua($params) {
			$do_usua = DB_DataObject::factory('usuario');
			$do_usua->usua_usrid = $params['usua_usrid'];
			$do_usua->usua_pwd = md5($params['usua_pwd_actual']);			
			if ($do_usua->find(true))
				return true;
			else
				return array('usua_pwd_actual'=>'La contraseña es incorrecta');
		}
				
    	//para que muestre la contraseña
        if ($this->cambiar_clave == true){
			$frm->removeElement('usua_pwd');  
			
			$frm->addRule(array('usua_pwd_nueva', 'usua_pwd_repetir'), 'Las claves no son iguales', 'compare', null, 'client');
			$frm->addFormRule('checkUsua');
			$frm->setRequiredNote(FRM_NOTA);
			$frm->setJsWarnings(FRM_WARNING_TOP, FRM_WARNING_BUTTON);
			$frm->addElement('Header','cambio_clave', 'Cambio de clave');
			
			$frm->addElement('password', 'usua_pwd_actual', 'Contraseña actual: ', array('size' => 25, 'maxlength' => 32));
			$frm->addElement('password', 'usua_pwd_nueva', 'Nueva contraseña: ', array('size' => 25, 'maxlength' => 32));
			$frm->addElement('password', 'usua_pwd_repetir', 'Repetir contraseña: ', array('size' => 25, 'maxlength' => 32));
			
			$frm->freeze(array('usua_usrid','usua_nombre','usua_email','usua_tel1','usua_tel2','usua_baja'));
			
			$frm->addRule('usua_pwd_nueva', 'Clave debe tener entre 6 y 12 caracteres', 'rangelength', array(6, 12), 'client',true);
			$frm->addRule('usua_pwd_repetir', 'Repetir contraseña requerida', 'required', null, 'client',true);
			
			
			$frm->addRule('usua_pwd_actual', 'Debe ingresar la contraseña actual', 'required', null, 'client',true);
			$frm->addRule(array('usua_pwd_nueva', 'usua_pwd_repetir'), 'Las contraseñas concuerdan', 'compare', null, 'client');
			
        }
		elseif ($this->cambiar_datos == true){
			$frm->removeElement('usua_pwd');
			$frm->addElement('link', 'usua_pwd','Contraseña', 'edit-clave.php','[Cambiar Clave]');			
		}
   }   
}
