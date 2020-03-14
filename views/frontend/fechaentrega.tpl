<!-- Block seleccionarentrega -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
// Activamos las horas cuando se selecciona una fecha
$(".delivery-options").on('change','#diasEntrega',function () { 
	$('#horasEntrega').removeAttr("disabled");
});

$(".delivery-options").on('change','#horasEntrega',function () { 

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
</script>
<div class="fecha-entrega">
	<h3>{l s='Seleccione una fecha de entrega del pedido'}</h3>
	<select id="diasEntrega" name="diasEntrega">
		<option value='{$tomorrow|date_format:"%A %e de %B de %Y"}'>{$tomorrow|date_format:"%A %e de %B de %Y"}</option>
		<option value='{$aftertomorrow|date_format:"%A %e de %B de %Y"}'>{$aftertomorrow|date_format:"%A %e de %B de %Y"}</option>
		<option value='{$afteraftertomorrow|date_format:"%A %e de %B de %Y"}'>{$afteraftertomorrow|date_format:"%A %e de %B de %Y"}</option>
	</select>
	<select id="horasEntrega" name="horasEntrega" disabled="disabled">
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
<!-- /Block seleccionarentrega -->