<!-- Block seleccionarentrega -->
<div class="fecha-entrega">
    <h3>{l s='Seleccione una fecha de entrega del pedido'}</h3>
	<select name="diasEntrega">
		<option value='{$tomorrow|date_format:"%A %e de %B de %Y"}'>{$tomorrow|date_format:"%A %e de %B de %Y"}</option>
		<option value='{$aftertomorrow|date_format:"%A %e de %B de %Y"}'>{$aftertomorrow|date_format:"%A %e de %B de %Y"}</option>
		<option value='{$afteraftertomorrow|date_format:"%A %e de %B de %Y"}'>{$afteraftertomorrow|date_format:"%A %e de %B de %Y"}</option>
	</select>
	<select name="horasEntrega">
		<option value="11:00 - 13:00">11:00 - 13:00</option>
		<option value="12:00 - 14:00">12:00 - 14:00</option>
		<option value="13:00 - 15:00">13:00 - 15:00</option>
		<option value="14:00 - 16:00">14:00 - 16:00</option>
		<option value="15:00 - 17:00">15:00 - 17:00</option>
		<option value="18:00 - 20:00">18:00 - 20:00</option>
		<option value="19:00 - 21:00">19:00 - 21:00</option>
		<option value="19:00 - 21:00">19:00 - 21:00</option>
	</select>
</div>
<!-- /Block seleccionarentrega -->