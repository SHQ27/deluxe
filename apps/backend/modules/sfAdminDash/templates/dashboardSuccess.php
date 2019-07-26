<div id="sf_admin_container" class="dashboard">

  <h1>Dashboard</h1>
  
  <h2>Alertas de atención inmediata</h2>
  
    <div class="cpanel">
          <ul>
              <?php if ( count($alertas) ): ?>
              <?php foreach( $alertas as $alerta ): ?>
              <li>
                <a href="<?php echo url_for( $alerta['route'] ); ?>"><?php echo  html_entity_decode($alerta['descripcion']); ?></a>
              </li>
              <?php endforeach; ?>
              <?php else: ?>
              <li class="ok">No hay alertas de atencion inmediata.</li>
              <?php endif; ?>
        </ul>
    </div>
    
</div>