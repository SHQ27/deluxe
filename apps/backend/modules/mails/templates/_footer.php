    	</td>
    </tr>
	
	
	
	<tr>
    	<td align="left" style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #000; font-size: 12px; padding: 0 45px;">
    	    <br /><br />
    	    <?php if ( !isset( $saludo ) ): ?>
    	    Saludos,
    	    <?php endif; ?>
    	    
    	    <?php if ( isset( $saludo ) && $saludo == 'MAXI' ): ?>
    	    Muchas gracias.
    	    <br />
            Maximiliano Alanz
            <br />
            Logística
    	    <?php endif; ?>
    	</td>
    </tr>
    
	<tr>
    	<td align="left" style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #fd7977; font-size: 12px; letter-spacing: 1px; padding: 0 45px;">
    	    <br />
    	    <strong>DELUXEBUYS.COM</strong>
    	    <br />
    	    SHOPPING ONLINE DE MODA
    	    <br /><br /><br />
    	</td>
    </tr>
    
	<tr>
    	<td align="center"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/mail_footer.jpg" alt="Encontra las mejores marcas hasta 80% off"/></td>
    </tr>
    
</table>