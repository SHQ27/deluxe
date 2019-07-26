<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  
  <?php foreach($productos as $producto): ?>
  <url>
    <loc><?php echo $producto->getDetalleUrl(true); ?></loc>
  </url>
  <?php endforeach ?>
  
  <?php foreach($productoCategorias as $productoCategoria): ?>
  <url>
    <loc><?php echo url_for('productos_listado_categoria', array('slugProductoGenero' => $productoCategoria->getProductoGenero()->getSlug(), 'slugProductoCategoria' => $productoCategoria->getSlug() ), true ) ?></loc>
  </url>
  <?php endforeach ?>
  
  <?php foreach($campanas as $campana): ?>
  <url>
    <loc><?php echo url_for('ofertas_detalles', array('slugCampana' => $campana->getSlug() ), true ) ?></loc>
  </url>
  <?php endforeach ?>
        
  <?php foreach($estaticas as $url): ?>
  <url>
    <loc><?php echo url_for($url, array(), true); ?></loc>
  </url>
  <?php endforeach ?>
  
  
  
</urlset>