{*
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Block SeleccionarEntrega -->
<div class="fecha-entrega">
    <h3>{l s='Seleccione una fecha de entrega del pedido' mod='seleccionarentrega'}</h3>
    <select id="diasEntrega" name="diasEntrega">
        <option disabled selected value> -- {l s='Seleccione la fecha de entrega' mod='seleccionarentrega'} -- </option>
        <option value='{$tomorrow|date_format:"%A %e de %B de %Y"}'>{$tomorrow|date_format:"%A %e de %B de %Y"}</option>
        <option value='{$aftertomorrow|date_format:"%A %e de %B de %Y"}'>{$aftertomorrow|date_format:"%A %e de %B de %Y"}</option>
        <option value='{$afteraftertomorrow|date_format:"%A %e de %B de %Y"}'>{$afteraftertomorrow|date_format:"%A %e de %B de %Y"}</option>
    </select>
    <select id="horasEntrega" name="horasEntrega" disabled="disabled">
        <option disabled selected value> -- {l s='Seleccione la hora de entrega' mod='seleccionarentrega'} -- </option>
        <option value="11:00 - 13:00">11:00 - 13:00</option>
        <option value="12:00 - 14:00">12:00 - 14:00</option>
        <option value="13:00 - 15:00">13:00 - 15:00</option>
        <option value="14:00 - 16:00">14:00 - 16:00</option>
        <option value="15:00 - 17:00">15:00 - 17:00</option>
        <option value="18:00 - 20:00">18:00 - 20:00</option>
        <option value="19:00 - 21:00">19:00 - 21:00</option>
        <option value="19:00 - 21:00">19:00 - 21:00</option>
    </select>
    <br /><br />
</div>
<!-- /Block SeleccionarEntrega -->