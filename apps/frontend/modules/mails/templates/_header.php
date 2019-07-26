<?php $width = isset( $width ) ? $width : 640; ?>

<table width="<?php echo $width; ?>" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td align="center"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/mail_header.jpg" alt="DeluxeBuys.com"/></td>
    </tr>

	<tr>
    	<td>
        	<div align="center"  style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #000; font-size: 18px; letter-spacing: 1px; background-color: #f0ee44; line-height: 46px; margin: 25px 18px 20px 18px; text-transform: uppercase;">
        	    <strong><?php echo $sf_data->getRaw('title'); ?></strong>
        	</div>
    	</td>
    </tr>
    
	<tr>
    	<td align="left" style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #333; font-size: 12px; padding: 0 45px; line-height: 25px;">