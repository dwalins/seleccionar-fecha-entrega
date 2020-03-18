<?php
/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

if ( !defined( '_PS_VERSION_' ) )
  exit;
 
require_once(dirname(__FILE__) . '/classes/Funciones.php');

class SeleccionarEntrega extends Module{
    public function __construct()
    {
        $this->name = 'seleccionarentrega';
        $this->tab = 'shipping_logistics';
        $this->version = '1.0.0';
        $this->author = 'Roberto Rivera';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
     
        parent::__construct();
     
        $this->displayName = $this->l( 'Seleccionar Entrega' );
        $this->description = $this->l( 'Modulo que permite escoger al cliente el dia y hora de entrega para su pedido' );
    }
 
    // Instalando
    public function install()
    {
        if(parent::install()== false OR
        !$this->registerHook('displayCarrierExtraContent') OR
        !$this->registerHook('actionFrontControllerSetMedia') OR
        !$this->registerHook('displayBeforeCarrier') OR
        !$this->registerHook('actionValidateOrder') OR
        !$this->registerHook('displayOrderConfirmation') OR
        !$this->registerHook('displayInvoice'))
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
    public function uninstall() 
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('seleccionarentrega')
        ) {
            return false;
        }

        Db::getInstance ()->execute ('DELETE FROM '._DB_PREFIX_.'fecha_entrega');
        Db::getInstance()->execute('DROP TABLE `'._DB_PREFIX_.'fecha_entrega`');
        return true;
    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->registerJavascript(
			'seleccionarentrega-jquery',
            'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',
            [
                'media' => 'all',
                'priority' => 200,
            ]
		);
		$this->context->controller->registerJavascript(
			'seleccionarentrega-funciones',
            'modules/' . $this->name . '/views/js/seleccionarentrega.js',
            [
                'media' => 'all',
                'priority' => 200,
            ]
	    );
    }

    // Engancho en el transporte
    public function hookdisplayBeforeCarrier($params)
    {
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
        
        return $this->display(__FILE__,'views/templates/front/fechaentrega.tpl');
    }
    
    public function hookDisplayOrderConfirmation($params)
    {        
        // Recojo el id del carrito y del pedido
        // TODO: Intentar recuperar estos id's de otra forma que no sea por GET
        $id_order = Tools::getValue('id_order');
        $id_cart = Tools::getValue('id_cart');
        
        // Uso funciones del archivo funciones
        // La historia de las funciones y el archivo que tanto amaba, eran mas amigos cuantas más funciones usaba
        Funciones::confirmarFechaEntrega($id_cart, $id_order);    
    }
    
    // Detalles del pedido BO
    public function hookDisplayInvoice($params)
    {
        $fecha_entrega = Funciones::getFechaEntrega(Tools::getValue('id_order'));
        
        $this->context->smarty->assign('fecha_entrega', $fecha_entrega);
        
        return $this->display(__FILE__,'views/templates/admin/adminfechaentrega.tpl');
    }
}
