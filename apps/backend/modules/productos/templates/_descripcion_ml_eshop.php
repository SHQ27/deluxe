<table style="font-family: trebuchet ms;" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/top.png"/></td>
    </tr>
    <tr>
        <td valign="top" width="97" style="background: url(<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/left_repeat.png);"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/left.png"/></td>
        <td width="704" rowspan="2" valign="top">
            <table width="704">
                <?php $principal = $productoImagenes[0]; ?>
                <tr>
                    <td valign="top">
                        <table style="margin: 0 0 0 20px;">
                            <tr>
                                <td valign="top" width="324" height="535" style="background: url('<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/imagen_grande.png') no-repeat center 0 ; padding: 20px 30px 25px 18px; text-align: center;">
                                    <img width="322" src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_mediana', $principal)?>"/>
                                </td>
                                <td valign="top" style="font-size: 16px; padding: 15px 10px 0 2px;" rowspan="2" >
                                    <h2 style="color: #000; font-size: 18px; padding: 0; margin: 0 0 30px 0; text-transform: uppercase;"><?php echo $producto->getDenominacion();?></h2>
                                    <?php echo preg_replace('/(style|class)="[^"]*"/', '', $producto->getDescripcion(ESC_RAW)); ?>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <?php $c = count($productoImagenes); ?>
                                            <?php $c = ( $c >= 4 ) ? 4 : $c; ?>
                                            <?php for( $i = 1 ; $i < $c ; $i++ ): ?>
                                            <?php $productoImagen = $productoImagenes[$i]; ?>
                                            <td valign="top" width="100" height="152" style="background: url('<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/imagen_chico.png') no-repeat center 0 ; padding: 10px 12px 10px 7px; text-align: center;">
                                                <img width="100" src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $productoImagen)?>"/>
                                            </td>
                                            <?php endfor; ?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="middle" style="text-align:center;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/alertas.png"/></td>
                </tr>
                <?php if ( $tablaTalles ): ?>
                <tr>
                    <td valign="middle" style="text-align:center;"><img style="margin: 10px 0;" src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/separador.png"/></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/guia_de_talles.png"/>
                        
                        <table width="96%" style="border-collapse: collapse; margin: 10px auto;">
                        	<tr>
                        		<td style="background: #fff; color: #000; padding: 5px; border: solid #000 1px; border-right: none;">&nbsp;</td>
                            	<?php $i = 1; ?>
                            	<?php $isLast = false; ?>
                        		<?php foreach( $tablaTalles['zonas'] as $zona ): ?>
                        		<?php $isLast = ( count($tablaTalles['zonas']) == $i ); ?>
                        		<td style="background: #fff; color: #000; padding: 5px; border: solid #000 1px; border-left: none; <?php echo ( !$isLast ) ? 'border-right: none;' : ' '; ?> text-transform: uppercase;"><?php echo $zona; ?><br /><small style="font-size: 9px;">DESDE-HASTA</small></td>
                        		<?php $i++; ?>
                        		<?php endforeach; ?>
                        	</tr>
                        	<?php foreach( $tablaTalles['talles'] as $row ): ?>
                        	
                        	<tr>
                        		<td style="background: #fff; padding: 5px; color: #000; text-transform: uppercase; border: solid #000 1px; border-right: none;"><?php echo $row['talle']; ?></td>
                            	<?php $i = 1; ?>
                            	<?php $isLast = false; ?>
                        		<?php foreach( $row['data'] as $subRow ): ?>
                        		<?php $isLast = ( count($row['data']) == $i ); ?>
                        		<td style="padding: 5px; border: solid #000 1px; border-left: none; <?php echo ( !$isLast ) ? 'border-right: none;' : ' '; ?>"><?php echo $subRow['desde']; ?> - <?php echo $subRow['hasta']; ?></td>
                        		<?php $i++; ?>
                        		<?php endforeach; ?>
                        	</tr>
                        	<?php endforeach; ?>
                        </table>
                        
                        <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/medidas_cm.png"/>
                    </td>
                </tr>
                <?php endif; ?>                
                <tr>
                    <td valign="middle" style="text-align:center;"><img style="margin: 10px 0;" src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/separador.png"/></td>
                </tr>
                <tr>
                    <td valign="middle" style="text-align:center;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/entregas.png"/></td>
                </tr>
                <tr>
                    <td valign="middle" style="text-align:center;"><img style="margin: 10px 0;" src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/separador.png"/></td>
                </tr>
                <tr>
                    <td valign="middle" style="text-align:center;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/formas_pago.png"/></td>
                </tr>
                <tr>
                <td valign="middle" style="text-align:center;">
                    <br/><br/>
                </td>
                </tr>
            </table>        
        </td>
        <td valign="top" width="99" style="background: url(<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/right_repeat.png);"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/right.png"/></td>
    </tr>
    <tr>
        <td valign="bottom" width="97" height="205"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/left_bottom.png"/></td>
        <td valign="bottom" width="99" height="205"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/right_bottom.png"/></td>
    <tr>
        <td colspan="3" height="121"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/eshop/<?php echo $idEshop; ?>/bottom.png"/></td>
    </tr>
</table>