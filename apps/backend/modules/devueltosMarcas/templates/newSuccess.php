<div id="sf_admin_container" class="newDevueltosMarcas">
  <h1>Generar nuevas devoluciones pendientes a una marca</h1>


  <?php if (!$pedido): ?>

    <form method="get">
      <label>Ingrese el id del pedido del cual quiere obtener los productos a agregar</label>
      <input type="text" name="idPedido" />
      <br /><br />
      <input type="submit" value="Buscar Pedido" class="button" />        
    </form>

  <?php else: ?>

  <p>
    Selecciona la cantidad de cada producto del pedido, para el cual quieras que se genere un registro de devolucion pendiente a la marca.
    <br /><br /><br />
    ¿Te equivocaste de pedido? <a href="<?php echo url_for('devueltosMarcas_new'); ?>">Hace click aqui para seleccionar otro pedido</a>.
  </p>

  <form method="post">
    <table>
      <tr>
        <th>Imagen</th>
        <th>Producto</th>
        <th>Marca</th>
        <th>Talle</th>
        <th>Color</th>
        <th>Devolvibles<br />a la marca</th>
      </tr>

      <?php foreach ($pedidoProductoItems as $pedidoProductoItem): ?>
      <?php $producto = $pedidoProductoItem->getProductoItem()->getProducto(); ?>

      <tr>
        <td><img width="100px" src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto); ?>"></td>
        <td><a href="/backend/productos/<?php echo $producto->getIdProducto() ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
        <td><?php echo $producto->getMarca()->getNombre(); ?></td>
        <td><?php echo $pedidoProductoItem->getProductoTalle()->getDenominacion(); ?></td>
        <td><?php echo $pedidoProductoItem->getProductoColor()->getDenominacion(); ?></td>
        <td><?php echo $form['pedidoProductoItem_' . $pedidoProductoItem->getIdPedidoProductoItem() ]; ?></td>
      </tr>
      <?php endforeach; ?>
    </table>

    <input type="submit" value="Generar devoluciones pendientes a una marca" class="button" />        
  </form>

  <?php endif; ?>

</div>
