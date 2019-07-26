<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<table width="550" cellpadding="20" cellspacing="0" border="0" align="center">
	<tr>
    	<td width="30%" align="left" valign="top">
        	            	<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto) ?>" style="border:1px solid #999999" border="0"/>
        </td>
        <td align="left" style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #333; font-size: 12px; padding: 0 45px; line-height: 25px;" valign="top">
			<p>
				<strong style="text-transform: uppercase;">Hola ¿Cómo estás?</strong>
			</p>
			
			<p>			
			    <strong>Te recomendaron:</strong>
			    <br/>
            	<a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host') . $producto->getDetalleUrl(); ?>"><?php echo $producto->getDenominacion(); ?></a>
            	<br/>
                <?php echo $producto->getMarca()->getNombre(); ?>
                <br/><br/>
            	<?php if ($campana): ?>
            	<strong>APÚRATE!</strong>
            	<br />La campaña de este producto finaliza el <strong><?php echo $campana->getDateTimeObject('fecha_fin')->format("d-m-Y"); ?></strong>
				<?php endif; ?>
				<br/>
			</p>
			<p style="font-size: 16px">
				¿Queres Comprarlo?&nbsp;&nbsp;Hace click <a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host') . $producto->getDetalleUrl(); ?>">aquí</a>
			</p>
		</td>
    </tr>
</table>

<?php echo include_partial('mails/footer'); ?>