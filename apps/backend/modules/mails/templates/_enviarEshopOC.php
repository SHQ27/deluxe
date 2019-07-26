<?php include_partial('mails/headerESHOP', array('eshop' => $eshop, 'title' => $title) )?>
    

<p>
    Buenos días,

    Adjuntamos las ventas correspondientes al día <?php echo $fecha ?>.
    <br />
    Los productos deben ser entregados de 8 a 13 y de 14 a 17hs. en <?php echo $eshop->getDomicilioComercial(); ?>.
    <br />
    Por cualquier consulta podés contactarnos telefónicamente (011) 4544-4764.
</p>

<p>
    Podes descargar las ventas en formato Excel, haciendo 
    <a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host'); ?>/backend/eshops/descargarResumenPedidos?hash=<?php echo $hash; ?>">
        click aquí
    </a> 
     y visualizar el resumen de mercaderia necesaria para satisfacer los pedidos a continuación:
</p>

<?php $tieneStockPropio = false; ?>
<?php foreach ( $productos as $producto ): ?>
<?php if ( $producto['cantidadSTKPER'] ) { $tieneStockPropio = true; break; }  ?>
<?php endforeach; ?>


<?php if ( $tieneStockPropio ): ?>
<h2 style="font-size: 14px; margin: 80px 0 10px 0; color: #333333;">VENTAS CON STOCK PROPIO</h2>

<table style="margin: 30px 0;" width="550">
    <thead>
        <tr>
            <th style="text-align: left;">Imagen</th>
            <th style="text-align: left;">Producto</th>
            <th style="text-align: left;">Color</th>
            <th style="text-align: left;">Talle</th>
            <th style="text-align: left;">Precio Uni.</th>
            <th style="text-align: left;">Cant.</th>
            <th style="text-align: left;">Importe</th>
        </tr>
    </thead>
    <tbody>
        <?php $cantidad = 0; ?>
        <?php $importeTotal = 0; ?>
        <?php foreach ( $productos as $producto ): ?>
        <?php if ( $producto['cantidadSTKPER'] ): ?>
        <tr>
            <?php $cantidad += $producto['cantidadSTKPER']; ?>
            <?php $importe = $producto['precio'] * $producto['cantidadSTKPER']; ?>
            <?php $importeTotal += $importe; ?>
            <td style="text-align: left;"><img src="<?php echo $producto['img']; ?>"/></td>
            <td style="text-align: left;"><?php echo $producto['nombre']; ?></td>
            <td style="text-align: left;"><?php echo $producto['color']; ?></td>
            <td style="text-align: left;"><?php echo $producto['talle']; ?></td>
            <td style="text-align: left;">$ <?php echo formatHelper::getInstance()->decimalNumber( $producto['precio'] ) ?></td>
            <td style="text-align: left;"><?php echo $producto['cantidadSTKPER']; ?></td>
            <td style="text-align: left;">$ <?php echo formatHelper::getInstance()->decimalNumber( $importe ) ?></td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="5" style="text-align: right;"><strong>Total</strong></td>
            <td style="text-align: left;"><strong><?php echo $cantidad; ?></strong></td>
            <td style="text-align: left;"><strong>$ <?php echo formatHelper::getInstance()->decimalNumber( $importeTotal ) ?></strong></td>
        </tr>
    </tbody>
</table>
<?php endif; ?>

<?php $tieneStockRefuerzo = false; ?>
<?php foreach ( $productos as $producto ): ?>
<?php if ( $producto['cantidadREFUER'] ) { $tieneStockRefuerzo = true; break; }  ?>
<?php endforeach; ?>

<?php if ( $tieneStockRefuerzo ): ?>
<h2 style="font-size: 14px; margin: 80px 0 10px 0; color: #333333;">VENTAS CON STOCK DE REFUERZO</h2>

<table style="margin: 30px 0;" width="550">
    <thead>
        <tr>
            <th style="text-align: left;">Imagen</th>
            <th style="text-align: left;">Producto</th>
            <th style="text-align: left;">Color</th>
            <th style="text-align: left;">Talle</th>
            <th style="text-align: left;">Cant.</th>
            <th style="text-align: left;">Precio Uni.</th>
        </tr>
    </thead>
    <tbody>
        <?php $cantidad = 0; ?>
        <?php $total = 0; ?>
        <?php foreach ( $productos as $producto ): ?>
        <?php if ( $producto['cantidadREFUER'] ): ?>
        <tr>
            <?php $cantidad += $producto['cantidadREFUER']; ?>
            <?php $total += $producto['precio']; ?>
            <td style="text-align: left;"><img src="<?php echo $producto['img']; ?>"/></td>
            <td style="text-align: left;"><?php echo $producto['nombre']; ?></td>
            <td style="text-align: left;"><?php echo $producto['color']; ?></td>
            <td style="text-align: left;"><?php echo $producto['talle']; ?></td>
            <td style="text-align: left;"><?php echo $producto['cantidadREFUER']; ?></td>
            <td style="text-align: left;">$ <?php echo $producto['precio']; ?></td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
            <td style="text-align: left;"><strong><?php echo $cantidad; ?></strong></td>
            <td style="text-align: left;"><strong><?php echo $total; ?></strong></td>
        </tr>
    </tbody>
</table>
<?php endif; ?>



<?php echo include_partial('mails/footerESHOP', array('eshop' => $eshop) ) ?>