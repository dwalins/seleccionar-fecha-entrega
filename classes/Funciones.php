<?php
class Funciones extends ObjectModel{
	
	public static function borrarCarritoRepetido($id_cart){
		$sql = 'DELETE FROM '._DB_PREFIX_.'fecha_entrega WHERE id_cart = '. $id_cart;
		if (!Db::getInstance()->execute($sql))
			Tools::displayError('ERROR SFE001: No se ha podido borrar.');
	}
	
	public static function buscarCarritoRepetido($id_cart){
		$sql = 'SELECT * FROM '._DB_PREFIX_.'fecha_entrega WHERE id_cart = '. $id_cart;
		
		if ($row = Db::getInstance()->getRow($sql))
			Funciones::borrarCarritoRepetido($id_cart);
			// buscarCarritoRepetido($id_cart);
		
		return false;
	}
	
	public static function confirmarFechaEntrega($id_cart, $id_order){
		$sql = 'UPDATE `'._DB_PREFIX_.'fecha_entrega`
			SET `id_order` = '. $id_order .'
			WHERE `id_cart` = '. $id_cart;
			Db::getInstance()->execute($sql);
	}
	
	public static function insertarCarrito($id_cart, $entrega){
		$sql = 'INSERT INTO `'._DB_PREFIX_.'fecha_entrega` (`delivery_date`,`id_cart`)
					VALUES("'. $entrega .'",'. $id_cart .')';
					
		if(!Funciones::buscarCarritoRepetido($id_cart))
			Db::getInstance()->execute($sql);
	}
	
	public static function getFechaEntrega($id_order){
		$sql = 'SELECT delivery_date FROM '._DB_PREFIX_.'fecha_entrega WHERE id_order = '. $id_order;
		
		if ($row = Db::getInstance()->getRow($sql))
			return $row['delivery_date'];
	}
	
}
