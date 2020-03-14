<?php

require_once(dirname(__FILE__) . '/../../classes/Funciones.php');

class seleccionarentregaajaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        Funciones::insertarCarrito($this->context->cart->id, $_POST['diaEntrega'] ." ". $_POST['horaEntrega']);
    }
}