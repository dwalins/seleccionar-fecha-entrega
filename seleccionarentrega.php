<?php
/**
*
*  @author    Roberto Rivera for dwalins.com
*  @copyright dwalins.com
*  @version   1.0
*  http://dwalins.com
*
*/
if ( !defined( '_PS_VERSION_' ) )
  exit;
 
require_once(dirname(__FILE__) . '/classes/Funciones.php');

class seleccionarentrega extends Module{
	public function __construct(){
		$this->name = 'seleccionarentrega';
		$this->tab = 'front_office_features';
		$this->version = 1.0;
		$this->author = 'Roberto Rivera';
		$this->need_instance = 0;
	 
		parent::__construct();
	 
		$this->displayName = $this->l( 'Seleccionar Entrega' );
		$this->description = $this->l( 'Modulo que permite escoger al cliente el dia y hora de entrega para su pedido' );
    }
 
	// Instalando
	public function install(){
		if(parent::install()== false OR
		!$this->registerHook('displayCarrierList') OR
		!$this->registerHook('actionValidateOrder') OR
		!$this->registerHook('displayOrderConfirmation') OR
		!$this->registerHook('displayInvoice') OR
		!$this->registerHook('actionCarrierProcess'))
            return false;
        
        $sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'fecha_entrega`(
                        `delivery_date` text NOT NULL,
                        `id_deliverydate` int(10) unsigned NOT NULL auto_increment,
                        `id_order` int(10) unsigned,
                        `id_cart` int(10) unsigned,
                        PRIMARY KEY(`id_deliverydate`),
                        UNIQUE (`id_order`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

		 Db::getInstance()->execute($sql);
                 
        return true;
	}
	
	// Exterminate, Exterminate
	public function uninstall(){
	   if(!parent::uninstall())
            Db::getInstance ()->execute ('DELETE FROM'._DB_PREFIX_.'fecha_entrega');
        
        Db::getInstance()->execute('DROP TABLE `'._DB_PREFIX_.'fecha_entrega`');
        
        parent::uninstall();
	}

	// Engancho en el transporte
	public function hookDisplayCarrierList($params){
        global $smarty;
		// Asigno la fecha de los tres proximos días para mostrarlos en el select que muestra los dias.
		if(date('N') == 3){
			$this->context->smarty->assign('tomorrow', strtotime('+1 day'));
			$this->context->smarty->assign('aftertomorrow', strtotime('+2 day'));
			$this->context->smarty->assign('afteraftertomorrow', strtotime('+5 day'));
		}
		else if(date('N') == 4){
			$this->context->smarty->assign('tomorrow', strtotime('+1 day'));
			$this->context->smarty->assign('aftertomorrow', strtotime('+4 day'));
			$this->context->smarty->assign('afteraftertomorrow', strtotime('+5 day'));
		}
		else if(date('N') == 5){
			$this->context->smarty->assign('tomorrow', strtotime('+3 day'));
			$this->context->smarty->assign('aftertomorrow', strtotime('+4 day'));
			$this->context->smarty->assign('afteraftertomorrow', strtotime('+5 day'));
		}
		else if(date('N') == 6){
			$this->context->smarty->assign('tomorrow', strtotime('+2 day'));
			$this->context->smarty->assign('aftertomorrow', strtotime('+3 day'));
			$this->context->smarty->assign('afteraftertomorrow', strtotime('+4 day'));
		}
		else{
			$this->context->smarty->assign('tomorrow', strtotime('+1 day'));
			$this->context->smarty->assign('aftertomorrow', strtotime('+2 day'));
			$this->context->smarty->assign('afteraftertomorrow', strtotime('+3 day'));
		}
		
        return $this->display(__FILE__,'views/frontend/fechaentrega.tpl');
    }
	
	// Proceso de compra: seleccionar transportista
	public function hookActionCarrierProcess($params){
		global $smarty;
		// Doy de alta un registro en la base de datos con el id del carrito y la fecha de entrega
		Funciones::insertarCarrito($this->context->cart->id, $_POST['diasEntrega'] ." ". $_POST['horasEntrega']);
	}
	
	
	public function hookDisplayOrderConfirmation($params){
		global $smarty;		
		// Recojo el id del carrito y del pedido
		// TODO: Intentar recuperar estos id's de otra forma que no sea por GET
		$id_order = $_GET['id_order'];
		$id_cart = $_GET['id_cart'];
		
		// Uso funciones del archivo funciones
		// La historia de las funciones y el archivo que tanto amaba, eran mas amigos cuantas más funciones usaba
		Funciones::confirmarFechaEntrega($id_cart, $id_order);	
	}
	
	// Detalles del pedido BO
	public function hookDisplayInvoice($params){
		$fecha_entrega = Funciones::getFechaEntrega($_GET['id_order']);
		
		$this->context->smarty->assign('fecha_entrega', $fecha_entrega);
		
		return $this->display(__FILE__,'views/backend/adminfechaentrega.tpl');
	}


}
?>