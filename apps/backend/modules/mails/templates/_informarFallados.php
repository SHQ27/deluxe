<?php include_partial('mails/header', array('title' => $title, 'width' => 800) ) ?>
	
<table width="800" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
        <td align="left" style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #333; font-size: 12px; line-height: 25px;" valign="top">
			<p>
				<strong style="text-transform: uppercase;">Estimados,</strong>
			</p>
			
			<p>
			    en las ultimas entregas hemos recibido las siguientes prendas falladas:
			</p>
			
        </td>
    </tr>
</table>

<br />

<table cellspacing="20" width="800" style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #333; font-size: 12px;">
  <thead>
    <tr>
        <th>Imagen</th>
        <th>Producto</th>
        <th>Talle</th>
        <th>Color</th>
        <th>Costo</th>
        <th>Falla detectada</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 0; ?>
    <?php foreach ($fallados as $fallado): ?>            
      <tr>
        <td><img src="<?php echo sfConfig::get('app_upload_url'); ?>/producto/detalle/chica/<?php echo $fallado['id_producto_imagen']; ?>.jpg"/></td>
        <td style="text-align: center;"><?php echo $fallado['denominacion']; ?></td>
        <td style="text-align: center;"><?php echo $fallado['talle']; ?></td>
        <td style="text-align: center;"><?php echo $fallado['color']; ?></td>
        <td style="text-align: center;">$<?php echo $fallado['costo']; ?></td>
        <td><?php echo $fallado['descripcion_falla']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<br />
		
<table width="800" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
        <td align="left" style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #333; font-size: 12px; line-height: 25px;" valign="top">
			
			<p>
                De acuerdo a nuestra metodologia de trabajo, es necesario realizar la correspondiente Nota de Credito contra la entrega de la mercaderia.
                <br />
                El saldo a favor sera descontado en el proximo pago.
			</p>
			
		</td>
    </tr>
</table>

<?php echo include_partial('mails/footer'); ?>