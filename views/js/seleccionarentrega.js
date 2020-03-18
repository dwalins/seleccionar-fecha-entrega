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

// Activamos las horas cuando se selecciona una fecha
$("#hook-display-before-carrier").on('change','#diasEntrega',function () { 
    $('#horasEntrega').removeAttr("disabled");
});

$("#hook-display-before-carrier").on('change','#horasEntrega',function () { 

    //get the selected value
    var diaEntrega = $( "#diasEntrega option:selected" ).text();
    var horaEntrega = $( "#horasEntrega option:selected" ).text();

    var FechaEntrega = { 
        'diaEntrega':diaEntrega,
        'horaEntrega':horaEntrega
    };

    //make the ajax call
    $.ajax({
        url: '/index.php?fc=module&module=seleccionarentrega&controller=ajax',
        type: 'POST',
        data: FechaEntrega,
        success: function() {
            console.log("Data sent!");
        }
    });

});
