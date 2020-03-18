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

class Funciones extends ObjectModel
{
    
    public static function borrarCarritoRepetido($id_cart)
    {
        $sql = 'DELETE FROM '._DB_PREFIX_.'fecha_entrega WHERE id_cart = '. $id_cart;
        if (!Db::getInstance()->execute($sql))
            Tools::displayError('ERROR SFE001: No se ha podido borrar.');
    }
    
    public static function buscarCarritoRepetido($id_cart)
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.'fecha_entrega WHERE id_cart = '. $id_cart;
        
        if ($row = Db::getInstance()->getRow($sql))
            Funciones::borrarCarritoRepetido($id_cart);
            // buscarCarritoRepetido($id_cart);
        
        return false;
    }
    
    public static function confirmarFechaEntrega($id_cart, $id_order)
    {
        $sql = 'UPDATE `'._DB_PREFIX_.'fecha_entrega`
            SET `id_order` = '. $id_order .'
            WHERE `id_cart` = '. $id_cart;
            Db::getInstance()->execute($sql);
    }
    
    public static function insertarCarrito($id_cart, $entrega)
    {
        $sql = 'INSERT INTO `'._DB_PREFIX_.'fecha_entrega` (`delivery_date`,`id_cart`)
                    VALUES("'. $entrega .'",'. $id_cart .')';
                    
        if(!Funciones::buscarCarritoRepetido($id_cart))
            Db::getInstance()->execute($sql);
    }
    
    public static function getFechaEntrega($id_order)
    {
        $sql = 'SELECT delivery_date FROM '._DB_PREFIX_.'fecha_entrega WHERE id_order = '. $id_order;
        
        if ($row = Db::getInstance()->getRow($sql))
            return $row['delivery_date'];
    }
}
