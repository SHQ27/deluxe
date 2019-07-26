<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_filter">
  <?php if ($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
  <?php endif; ?>

  <form action="<?php echo url_for('usuario_collection', array('action' => 'filter')) ?>" method="post">
    <table cellspacing="0">
      <tfoot>
        <tr>
          <td colspan="2">
            <?php echo $form->renderHiddenFields() ?>
            <?php echo link_to(__('Reset', array(), 'sf_admin'), 'usuario_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?>
            <input type="submit" value="<?php echo __('Filter', array(), 'sf_admin') ?>" />
          </td>
        </tr>
      </tfoot>
      <tbody>
      
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_nombre">
				<td class="label"><label for="nombre">Nombre</label></td>
				<td>
					<?php echo $form['nombre']->render() ?>
				</td>
			</tr>
			
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_apellido">
				<td class="label"><label for="apellido">Apellido</label></td>
				<td>
					<?php echo $form['apellido']->render() ?>
				</td>
			</tr>
      
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_email">
				<td class="label"><label for="email">Email</label></td>
				<td>
					<?php echo $form['email']->render() ?>
				</td>
			</tr>
      
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_provincia">
				<td class="label"><label for="provincia">Provincia</label></td>
				<td>
					<?php echo $form['provincia']->render() ?>
				</td>
			</tr>
      			
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_sexo">
				<td class="label"><label for="sexo">Sexo</label></td>
				<td>
					<?php echo $form['sexo']->render() ?>
				</td>
			</tr>
				
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_edad">
				<td class="label"><label for="edad">Edad</label></td>
				<td>
					De
					<?php echo $form['edad_desde']->render() ?>
					a
					<?php echo $form['edad_hasta']->render() ?>
				</td>
			</tr>
			
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_compras">
				<td class="label"><label for="compras">Cantidad de Compras</label></td>
				<td>
					Entre
					<?php echo $form['compras_desde']->render() ?>
					y
					<?php echo $form['compras_hasta']->render() ?>
				</td>
			</tr>
			
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_fecha_alta">
				<td class="label"><label for="fecha_alta">Fecha de Alta</label> </td>
				<td>
					<?php echo $form['fecha_alta']->render() ?>
				</td>
			</tr>
			
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_source">
				<td class="label"><label for="localidad">Código del Source</label> </td>
				<td>
					<?php echo $form['source']->render() ?>
				</td>
			</tr>
			
			<tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_id_eshop">
				<td class="label"><label for="id_eshop">eShop</label> </td>
				<td>
					<?php echo $form['id_eshop']->render() ?>
				</td>
			</tr>
			
		</tbody>
    </table>
  </form>
</div>

<p>
	<a href="<?php echo url_for('usuarios_descargarCSV')?>">Exportar listado a CSV</a>
</p>

