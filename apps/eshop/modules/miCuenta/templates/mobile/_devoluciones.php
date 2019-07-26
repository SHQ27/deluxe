<script>
var topPosition = 300;
</script>

<div id="devoluciones_main">
    <?php if (!$procesado): ?>

    <div class="row steps">
        <div class="col41"><div class="inline step selected" rel="1">1</div></div>
        <div class="col42"><div class="inline step" rel="2">2</div></div>
        <div class="col43"><div class="inline step" rel="3">3</div></div>
        <div class="col44"><div class="inline step" rel="4">4</div></div>
    </div>
    
    <form method="post">
    
        <?php echo $form['_csrf_token'] ?>
    
    
        <div id="paso-1" class="show">
        
    		<div class="texto">
    			Estos son los productos que estan en plazo de devolución (10 días luego de recibido el pedido. Ver <a class="bold italic color4" href="<?php echo url_for('tyc')?>">Política de devoluciones.</a>
    		</div>

            <table class="tableCarrito items">
                <thead class="headerCarrito">
                    <tr>
                        <th class="carritoCol5">&nbsp;</th>
                        <th class="carritoCol1y2" colspan="2">PRODUCTOS</th>
                        <th class="carritoCol3">CANT.</th>
                        <th class="carritoCol4">PRECIO</th>
                    </tr>
                </thead>
                <tbody class="itemsCarrito">
                    <?php $index = 0; ?>
                    <?php foreach ($pedidoProductoItems as $pedidoProductoItem): ?>
                    <?php $productoItem = $pedidoProductoItem->getProductoItem(); ?>
                    <?php $producto = $productoItem->getProducto(); ?>
                    <tr class="item">
                        <td class="carritoCol5">
                            <?php echo $form['pedido_producto_item[id]']->render( array( 'name' => 'devoluciones[pedido_producto_item_id][' . $index . ']', 'value' => $pedidoProductoItem->getIdPedidoProductoItem(), 'class' => 'hide' ) ); ?>
                            <input type="button" class="checkbox formInputButton avoid-click" value="" rel="<?php echo $index; ?>">
                        </td>
                        <td class="carritoCol1 foto">
                            <img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>" alt="<?php echo $producto->getDenominacion() ?>" width="100%" />
                        </td>
                        <td class="carritoCol2 datos">
                            <div class="nombre"><?php echo truncate_text( $producto->getDenominacion(), 30 ) ?></div>
                            <div class="talle">TALLE. <?php echo $productoItem->getProductoTalle()->getDenominacion() ?></div>
                            <div class="color">COLOR. <?php echo $productoItem->getProductoColor()->getDenominacion() ?></div>
                        </td>
                        <td class="carritoCol3">
                            <div class="cantidad" data-peso="<?php echo $producto->getPeso(); ?>">
                                <div class="select customSelect avoid-click">
                                    <select class="avoid-click" name="devoluciones[pedido_producto_item_cantidad][<?php echo $index; ?>]">
                                        <?php for ($i = 1 ; $i <= $pedidoProductoItem->getCantidad() ; $i++ ): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td class="carritoCol4 precio total">
                            $<?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ); ?>
                            <div class="alert hide"></div>
                        </td>
                    </tr>
                    <?php $index++; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="5" id="generalError" class="hide"></td>
                    </tr>
                </tbody>
            </table>

    		<div class="campo">
    		    <div class="">MOTIVO DE LA DEVOLUCION</div>
        		<div id="motivo" class="select">
            		<div class="customSelect"> 
            			<?php echo $form['motivo'] ?>
            		</div>
    			</div>
    		</div>
            <div class="campo">
                <div class="">DESCRIPCIÓN</div>
                <div class="motivo_abierto">
                    <?php echo $form['motivo_abierto']->render( array( "class" => "OS-12 color4", "placeholder" => 'Describe aquí el motivo de la devolución...' ) ) ?> 
                    <div class="error"></div>
                </div>
            </div>
            <div class="btContainer">
    		  <input type="button" value="DEVOLVER" class="buttonDevolver">
            </div>
	   </div>
	

    	<div id="paso-2" class="hide">
    	    		
    		<div class="preferencia opcion">
    
        		<div class="radio small">
        			<input id="devoluciones_credito_MP" type="radio" value="MP" name="devoluciones[credito]" />
        		</div>
        		<label for="devoluciones_credito_MP" class="radioLabel">
        		      <span class="tituloOpcion">LA DEVOLUCIÓN SE REALIZARÁ POR MEDIO DE MERCADO PAGO</span>
        		      <br />
        		      <span class="textoOpcion">(Ten en cuenta que puede demorar hasta 30 días hábiles en reflejarse en tu resumen)</span>
    		    </label>
    		    
    		</div>
    		
    		<div class="botones">
                <div class="row">
                    <div class="col21"><div id="p2_btAnt" class="buttonAnterior">< ANTERIOR</div></div>
                    <div class="col22"><div id="p2_btSig" class="buttonSiguiente">SIGUIENTE</div></div>
                </div>
    		</div>
    	</div>

        
    	<div id="paso-3" class="hide">
    	
            <div class="preferencia opcion">       
        		<div class="radio small selected">
        		      <input id="devoluciones_entrega_OCA" type="radio" value="OCA" checked="checked" name="devoluciones[entrega]" />
        		</div>
        		<label for="devoluciones_entrega_OCA" class="radioLabel tituloOpcion">
        		      RETIRAREMOS EL PRODUCTO EN TU DOMICILIO
        		      <br />
        		      <span class="OS-11" id="oca_aclaracion"></span>
    		    </label>
    		</div>
    		
    		<div class="form direccionEntrega">
    			<div class="campo">
    			     NOMBRE
    				<?php echo $form['nombre']->render( array('class' => '') ); ?>
    			</div>
    			<div class="campo">APELLIDO
    				<?php echo $form['apellido']->render( array('class' => '') ); ?>
    			</div>
    			<div class="campo medio">CALLE
    				<?php echo $form['calle']->render( array('class' => '') ); ?>
    			</div>
    			<div class="campo chico">NÚMERO
    				<?php echo $form['numero']->render( array('class' => '') ); ?>
    			</div>
    			<div class="campo medio">PISO
    				<?php echo $form['piso']->render( array('class' => '') ); ?>
    			</div>
    			<div class="campo chico">DEPARTAMENTO
    				<?php echo $form['dpto']->render( array('class' => '') ); ?>
    			</div>
    			<div class="campo"><div class="">PROVINCIA</div>
    				<div id="provincia" class="select">
                        <div class="customSelect">
                        <?php echo $form['id_provincia']; ?>
                        </div>
    				</div>
    			</div>
    			<div class="campo">LOCALIDAD
    				<?php echo $form['localidad']->render( array('class' => '') ); ?>
    			</div>
    			<div class="campo">CÓDIGO POSTAL
    			    <?php echo $form['codigo_postal']->render( array('class' => '') ); ?>
    			</div>
    			
    			<div class="costoEnvio">COSTO DE ENVIO. $<span></span>.-</div>
            	<div class="error"></div>
    		</div>
    		<div class="botones">
                <div class="row">
                    <div class="col21"><div id="p2_btAnt" class="buttonAnterior">< ANTERIOR</div></div>
                    <div class="col22"><div id="p2_btSig" class="buttonSiguiente">SIGUIENTE</div></div>
                </div>
    		</div>
    	</div>
	
        
        <div id="paso-4" class="hide">
    
    		<div class="texto">
    			Verifica los productos y opciones de devolución elegidos y confirma para finalizar
    		</div>
    		
            <table class="listProductItems tableCarrito items">
            </table>
                
    		<div class="resumen">
    			<div class="label">RESUMEN DE DEVOLUCIÓN</div>
    			<div class="opciones">
    			     <ul class="leyenda"></ul>
    		    </div>
		    </div>
		
    		<div class="botones">
                <div class="row">
                    <div class="col21"><div id="p4_btAnt" class="buttonAnterior">< ANTERIOR</div></div>
                    <div class="col22"><input type="submit" class="buttonConfirmar" value="CONFIRMAR" /></div>
                </div>
    		</div>
        </div>
                
    </form>
    
    <?php else: ?>
    <div id="devoluciones_ok">
        <?php if ($procesado == 'ok'): ?>
        <div class="texto">
        	Se ha iniciado el proceso de devolución.
        	<br />
        	A la brevedad estarás recibiendo un e-mail con los pasos a seguir.			
        </div>
        <?php else: ?>
        <div class="texto">
        	Hubo un problema en el proceso de devolución
        	<br />
        	por favor intentalo nuevamente.			
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<script>
    var outlet = <?php echo html_entity_decode($outlet); ?>;
    var idCategorias = <?php echo html_entity_decode($idCategorias); ?>;
    var idCategoriasRestringidas = <?php echo $idCategoriasRestringidas ?>;
    var mensajeCategoriasRestringidas = '<?php echo $mensajeCategoriasRestringidas ?>';
</script>