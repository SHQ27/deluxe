<td>
  <ul class="sf_admin_td_actions">
  
    <li class="sf_admin_action">
        <a href="http://articulo.mercadolibre.com.ar/MLA-<?php echo substr($publicacion_ml->getItemId(), 3); ?>-producto_JM" target="_blank">Ver articulo en ML</a>
    </li>
    
    <?php if ( $publicacion_ml->estaVigente() ): ?>
    <li class="sf_admin_action_desaprobar">
        <a href="<?php echo url_for('publicacion_ml_cerrar', array('idProducto' => $publicacion_ml->getIdProducto() ) ); ?>" title="Solo cierra la publicacion, pudiendo reactivarse luego sobe la misma publicacion" alt="Solo cierra la publicacion, pudiendo reactivarse luego sobe la misma publicacion">Cerrar Publicacion</a>
    </li>
    <?php endif; ?>
    
    <li class="sf_admin_action_delete">
        <a href="<?php echo url_for('publicacion_ml_eliminar', array('idProducto' => $publicacion_ml->getIdProducto() ) ); ?>" title="Elimina la publicacion, sin posibilidad de reactivar la misma publicacion" alt="Elimina la publicacion, sin posibilidad de reactivar la misma publicacion">Eliminar Articulo en ML</a>
    </li>
  </ul>
</td>
