<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<table width="550" cellpadding="20" cellspacing="0" border="0" align="center">
	<tr>
    	<td width="30%" align="left" valign="top">
        	<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto) ?>" style="border:1px solid #999999" border="0"/>
        </td>
        <td align="left" style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #333; font-size: 12px; padding: 0 45px; line-height: 25px;" valign="top">
			<p>
				<strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
			</p>
			
			<p>
				Te queríamos comentar que el artículo <strong><?php echo $producto->getDenominacion() ?></strong> de la marca <strong><?php echo $marca->getNombre() ?></strong> se encuentra nuevamente disponible.
				<br/><br/>
				Podés acceder a él haciendo <a style="color:#419dc4;" href="<?php echo sfConfig::get('app_host') . str_replace( $_SERVER['SCRIPT_NAME'], '', $producto->getDetalleUrl()); ?>">click aquí</a>.
			</p>
		</td>
    </tr>
</table>

<?php echo include_partial('mails/footer'); ?>