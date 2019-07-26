  	<table cellpadding="0" cellspacing="0" border="0" align="center" width="550">
		  <tr>
		  	<td align="center" style="margin: 0; padding: 0; background:#fff; padding: 50px 0">
			    <table cellpadding="0" cellspacing="0" border="0" align="center" width="550" style="font-family: sans-serif;">
			      <tr>
			        <td bgcolor="#ffffff" height="115" align="center">
			        
						<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/<?php echo $eshop->getIdEshop(); ?>/mail_header.jpg"/>						
						<div style="position: relative; margin: 35px 0 25px 0;">
						  <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/<?php echo $eshop->getIdEshop(); ?>/mail_linea.jpg"/>
						</div>
						
						<p style="color: <?php echo $eshop->getLinkColor(); ?>; font: 500 18px sans-serif; text-transform: uppercase; margin: 0; padding: 0; line-height: 22px;">
						  <?php echo $sf_data->getRaw('title'); ?>
    					</p>
                    </td>
			      </tr>
                  <tr>
			        <td bgcolor="#ffffff" style="color: #666666; font: normal 11px sans-serif; line-height: 18px;">
		                <p>&nbsp;</p>