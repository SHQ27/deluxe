<table style="font-family: verdana;" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/top.png"/></td>
    </tr>
    <tr>
        <td valign="top" width="97" style="background: url(<?php echo sfConfig::get('app_host_static'); ?>/images/ml/left_repeat.png);"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/left.png"/></td>
        <td width="704" rowspan="2">
            <table width="704">
                <?php $principal = $productoImagenes[0]; ?>
                <tr>_
                    <td valign="top">
                        <table style="margin: 0 0 0 20px;">
                            <tr>
                                <td valign="top" width="324" height="491" style="background: url('<?php echo sfConfig::get('app_host_static'); ?>/images/ml/imagen_grande.png') no-repeat center 0 ; padding: 25px; text-align: center;">
                                    <img width="322" src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_mediana', $principal)?>"/>
                                </td>
                                <td valign="top" style="font-size: 14px; padding: 15px 10px 0 2px;" rowspan="2" >
                                    <h2 style="text-decoration: underline; font-size: 21px; padding: 0; margin: 30px 0 10px 0; text-transform: uppercase;"><?php echo $marca->getNombre();?></h2>
                                    <h3 style="color: #e97476; font-size: 17px; padding: 0; margin: 0 0 30px 0; text-transform: uppercase;"><?php echo $producto->getDenominacion();?></h3>
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
                                            <td valign="top" width="100" height="152" style="background: url('<?php echo sfConfig::get('app_host_static'); ?>/images/ml/imagen_chico.png') no-repeat center 0 ; padding: 10px 12px 10px 7px; text-align: center;">
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
                    <td height="75" style="font-size: 12px; background: url('<?php echo sfConfig::get('app_host_static'); ?>/images/ml/cuadro.png') no-repeat center center;">
                        <div style="padding: 0 40px; margin: 7px 0; text-transform: uppercase;">
                            <strong>El stock y los talles disponibles son los que se visualizan en la publicación, no es necesario consultar antes de realizar la compra</strong>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign="middle" height="40" style="text-align:center;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/cambio.png"/></td>
                </tr>
                <tr>
                    <td valign="top" height="40" style="text-align:center;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/separador.png"/></td>
                </tr>
                <tr>
                    <td>
                        <h4 style="text-decoration: underline; font-size: 16px; padding: 0 50px; margin: 10px 0;">PREGUNTAS FRECUENTES</h4>
                        <p style="padding: 0 50px; text-transform: uppercase; font-size: 13px;">
                            <strong>¿Cuánto demora OCA en entregar mi pedido?</strong>
                            <br />
                            OCA demora entre 2 a 10 días hábiles en entregar tu pedido, dependiendo de tu localidad.
                            <br /><br />
                             
                            <strong>¿Cuáles son los métodos de pago disponibles?</strong>
                            <br />
                            Visa – Mastercard – American Express – Argencard – Cabal – Tarjeta Shopping – Tarjeta Naranja
                            <br /><br />
                            
                            <strong>¿Puedo pasar a retirar mi compra por algún lado?</strong>
                            <br />
                            Por el momento no; todos los pedidos son enviados a través de OCA.
                            <br /><br />
                            
                            <strong>¿Puedo cambiar el producto?</strong>
                            <br />
                            Debido a que trabajamos con stocks únicos de cada marca, la oferta es limitada; por este motivo si no estás conforme con el producto o el mismo no es del talle adecuado te ofrecemos devolverlo sin inconvenientes.
                            <br /><br />
                            
                            <strong>¿Puedo devolver el producto que compré?</strong>
                            <br />
                            En el caso que no estés conforme con el producto que recibiste, Deluxebuys te da la posibilidad de devolverlo.
                            <br /><br />
                            
                            <strong>Política de Devoluciones</strong>
                            <br />
                            Dentro del plazo de 10 días de recibido el pedido, todos los productos vendidos podrán ser devueltos con excepción de aquellos en que se indique en su descripción como artículo “sin cambio”.
                            <br /> 
                            <strong>Deluxebuys no acepta devoluciones ni cambios de los siguientes productos: ropa interior, medias, trajes de baño, accesorios (relojes, anteojos de sol, bijouterie), excepto si presentan un problema de calidad."</strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td height="40" style="text-align:center; vertical-align: middle;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/separador.png"/></td>
                </tr>
                <tr>
                    <td>
                        <h4 style="text-decoration: underline; font-size: 16px; padding: 0 50px; margin: 10px 0;">NUESTRAS MARCAS</h4>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/marcas.jpg?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>"/></td>
                </tr>
                <tr>
                    <td height="40" style="text-align:center; vertical-align: middle;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/separador.png"/></td>
                </tr>
                <tr>
                    <td>
                        <h4 style="text-decoration: underline; font-size: 16px; padding: 0 50px; margin: 10px 0;">FORMAS DE PAGO</h4>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/formas_pago.jpg?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>"/></td>
                </tr>
                <?php if ( $tablaTalles ): ?>
                <tr>
                    <td>
                        <h4 style="text-decoration: underline; font-size: 16px; padding: 0 50px; margin: 10px 0;">¿QUÉ TALLE SOY?</h4>
                        <table>
                            <tr>
                                <td width="250" style="text-align: center; vertical-align: middle;"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/silueta.jpg?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>"/></td>
                                <td width="448">
                                    <table style="text-align: center; font-size: 11px; margin: 0 auto;">
                                    	<tr>
                                    		<td style="background: #000000; color: #ffffff; padding: 5px;">TALLE</td>
                                    		<td style="background: #000000; color: #ffffff; padding: 5px;" colspan="<?php echo count( $tablaTalles['zonas'] ); ?>">ZONAS</td>
                                    	</tr>
                                    	<tr>
                                    		<td style="background: #000000; color: #ffffff; padding: 5px;"></td>
                                    		<?php foreach( $tablaTalles['zonas'] as $zona ): ?>
                                    		<td style="background: #000000; color: #ffffff; padding: 5px;; text-transform: uppercase;"><?php echo $zona; ?><br /><small style="font-size: 9px;">DESDE-HASTA</small></td>
                                    		<?php endforeach; ?>
                                    	</tr>
                                    	<?php $i = 1; ?>
                                    	<?php $isLast = false; ?>
                                    	<?php foreach( $tablaTalles['talles'] as $row ): ?>
                                    	<?php $isLast = ( count($tablaTalles['talles']) == $i ); ?>
                                    	<tr>
                                    	    <?php $borderClass = ( $isLast ) ? 'border-bottom: solid #000 1px; border-right: solid #000 1px;' : 'border-right: solid #000 1px;'; ?>
                                    		<td style="background: #000000; padding: 5px; color: #ffffff; text-transform: uppercase; <?php echo $borderClass; ?>"><?php echo $row['talle']; ?></td>
                                    		<?php foreach( $row['data'] as $subRow ): ?>
                                    		<td style="padding: 5px; <?php echo $borderClass; ?>"><?php echo $subRow['desde']; ?> - <?php echo $subRow['hasta']; ?></td>
                                    		<?php endforeach; ?>
                                    	</tr>
                                    	<?php $i++; ?>
                                    	<?php endforeach; ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>        
        </td>
        <td valign="top" width="98" style="background: url(<?php echo sfConfig::get('app_host_static'); ?>/images/ml/right_repeat.png);"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/right.png"/></td>
    </tr>
    <tr>
        <td valign="bottom" width="97" height="205"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/left_bottom.png"/></td>
        <td valign="bottom" width="98" height="205"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/right_bottom.png"/></td>
    <tr>
        <td colspan="3" height="121"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/ml/bottom.png"/></td>
    </tr>
</table>