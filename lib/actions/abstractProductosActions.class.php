<?php

/**
 *
 * @package    deluxebuys
 * @subpackage productos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class abstractProductosActions extends deluxebuysActions
{	

    protected function createListado($request, $idProductoGenero, $filtros = array())
    {    
        $eshop = eshopTable::getInstance()->getCurrent();
                
        // Obtengo el objeto productoCategoria asociado al slug
        $slugProductoCategoria = $request->getParameter('slugProductoCategoria');
        $productoCategoria = productoCategoriaTable::getInstance()->getBySlug( $slugProductoCategoria, $idProductoGenero );
        
        // Filtros
        $filtros['marcas']              = $request->getParameter('marcas', array());
        $filtros['categorias']          = $request->getParameter('categorias', array());
        $filtros['talles']              = $request->getParameter('talles', array());
        $filtros['colores']             = $request->getParameter('colores', array());
        $filtros['rango']               = $request->getParameter('rango', array());
        $filtros['order']               = $request->getParameter('order', null);
        $filtros['page']                = $request->getParameter('page', 1);
        $filtros['idProductoCategoria'] = ( $productoCategoria ) ? $productoCategoria->getIdProductoCategoria() : NULL;
        
        // Get current page, is not set default will be 1
        $page = $request->getParameter('page', 1);
    
        // Query
        $queryProductos = productoTable::getInstance()->queryFilterBy( $filtros, $page );
        
        $pager = new Doctrine_Pager
        (
            $queryProductos,
            $page,
            sfConfig::get('app_rpp_productos_categoria')
        );
    
        // Seteo de variables en la vista
        $this->pager = $pager;
        $this->productos = $pager->execute();
        $this->productoCategoria = $productoCategoria;
        $this->idProductoGenero = $idProductoGenero;
        $this->orden = $filtros['order'];
        $this->query = $queryProductos;
        $this->rango = $filtros['rango'];
    
        // Seteo el template a utilizar
        $this->setTemplate( 'listado');
    
        // Base URL de Paginacion
        $paginationBaseUrl = preg_replace('/([&|?])page=([0-9]+)/', '', $_SERVER['REQUEST_URI']);
        $paginationBaseUrl .= (stripos($paginationBaseUrl, '?') === false) ? '?' : '&';
    
        $this->paginationBaseUrl = $paginationBaseUrl . 'page=';
    
        // Se quita el layout para las llamadas del paginador infinito
        if ( $page > 1 ) $this->setLayout(false);
    }
    
    protected function createListaTag($request, $filtros = array() )
    {
        $queryTag = $request->getParameter('queryTag');
    
        // Captura de Filtros
        $filtros['marcas'] 	    = $request->getParameter('marcas', array());
        $filtros['categorias']  = $request->getParameter('categorias', array());
        $filtros['talles'] 	    = $request->getParameter('talles', array());
        $filtros['colores']     = $request->getParameter('colores', array());
        $filtros['rango']	    = $request->getParameter('rango', array());
        $filtros['order']       = $request->getParameter('order', null);
        $filtros['tag']         = $queryTag;
    
    
        // Get current page, is not set default will be 1
        $page = $request->getParameter('page', 1);
    
        // Products
        $productoQuery = productoTable::getInstance()->queryFilterBy( $filtros, $page );
    
        // Paginator
        $pager = new Doctrine_Pager
        (
            $productoQuery,
            $page,
            sfConfig::get('app_rpp_productos_lista_tag')
        );
    
        // Seteo de variables en la vista
        $this->pager = $pager;
        $this->productos = $pager->execute();
    
        $this->queryTag = $queryTag;
        $this->idMarcas = array();
    
        // Filtros
        $this->query = $productoQuery;
        $this->rango = $filtros['rango'];
    
        // Base URL de Paginacion
        $paginationBaseUrl = preg_replace('/([&|?])page=([0-9]+)/', '', $_SERVER['REQUEST_URI']);
        $paginationBaseUrl .= (stripos($paginationBaseUrl, '?') === false) ? '?' : '&';
    
        $this->paginationBaseUrl = $paginationBaseUrl . 'page=';
    
        if ( $page > 1 ) $this->setLayout(false);
    }
    
    protected function createDetalle($request)
    {
        // Obtengo el producto
        $slugProducto = $request->getParameter('slugProducto');
        $idProducto = substr($slugProducto, 0, strpos($slugProducto, '-'));
        $producto = productoTable::getInstance()->getForDetalle( $idProducto );
        
        // Se verifica si esta habilitado el acceso al producto
        if ( !$producto || !$producto->estaHabilitado() )
        {
            $this->redirect('/');
        }
    
        // Armado de Meta Tags
        $metaTags = array();
        $tags = $producto->listTags();
        foreach ($tags as $tag)
        {
            $metaTags[] = $tag->getDenominacion();
        }
    
        $this->metaProductTags = (!empty($metaTags)) ? implode(", ", $metaTags) : '';
    
        // Sumo una visita
        $producto->sumaVisita();
        	
        // Obtengo las imagenes del producto
        $productoImagenes = productoImagenTable::getInstance()->listByIdProducto( $producto->getIdProducto() );

        // Obtengo los productoItems
        $response = $this->makeDataProductoItem( $producto->getIdProducto() );
        $dataProductoItems = $response['dataProductoItems'];


        $data = json_decode($dataProductoItems, true);
        $colores = array();
        foreach ($data as $row) {
            foreach ($row['childs'] as $color) {
                $colores[ $color['idProductoColor'] ] = $color['imagen'];
            }
        }

        $estaAgotado = $response['estaAgotado'];
        	
        // Calculos del Costo de envio
        $provincias = provinciaTable::getInstance()->listAll();
        	
        // Formulario
        $form = new addProductoForm( array('id_producto' => $producto->getIdProducto() ) );
        	
        // Metas para facebook
        $this->getResponse()->addMeta("og:title", $producto->getDenominacion() );
        $this->getResponse()->addMeta("og:site_name", $_SERVER['HTTP_HOST'] );
        	
        // Alerta por categorias sin devolucion
        $productoCategoria = $producto->getProductoCategoria();
        $eshop = eshopTable::getInstance()->getCurrent();

        if ( $eshop ) {
            $devolucionRestringidaData     = $eshop->getDevolucionRestringidaData();
            $idCategoriasRestringidas      = $devolucionRestringidaData['ids'];
            $mensajeCategoriasRestringidas = $devolucionRestringidaData['mensaje'];
        } else {
            $idCategoriasRestringidas      = json_decode( sfConfig::get('app_categoriaDevolucionRestringida_ids'), true);
            $mensajeCategoriasRestringidas = sfConfig::get('app_categoriaDevolucionRestringida_mensaje');
        }

        $this->mensajeCategoriasRestringidas = $mensajeCategoriasRestringidas;
        $this->mostrarAlertaRopaInterior     = in_array( $productoCategoria->getIdProductoCategoria(), $idCategoriasRestringidas );
            
        // Seteo de variables en la vista
        $this->producto          = $producto;
        $this->productoImagenes  = $productoImagenes;
        	
        $this->dataProductoItems = $dataProductoItems;
        $this->estaAgotado       = $estaAgotado;
        $this->provincias        = $provincias;
        $this->form              = $form;
    
        $this->productoGenero    = $productoCategoria->getProductoGenero();
        $this->productoCategoria = $productoCategoria;
    
        $session = sessionTable::getInstance()->getSession();
        $this->mostrarCartelMezcla = carritoProductoItemTable::getInstance()->mostrarCartelMezcla( $session->getIdSession(), $producto );
        
        $this->estimacionEntrega = $producto->getEstimacionEntrega();
    
        $this->campana = $producto->getCampana();
    
        $this->mediosDePago = configuracionTable::getInstance()->getById( configuracion::FICHA_MEDIOS_DE_PAGO );
    }
    
    protected function makeDataProductoItem( $idProducto, $soloConStock = true )
    {
        $stockTotal = 0;
        $items = array();
        $productoItems = productoItemTable::getInstance()->listByIdProductoOrdenado( $idProducto );
    
        foreach($productoItems as $productoItem)
        {
    
            $talle = $productoItem->getProductoTalle();
            $color = $productoItem->getProductoColor();
    
            $currentStock = $productoItem->getCurrentStock();
            
            if (!$soloConStock || $currentStock )
            {
                $items[$talle->getIdProductoTalle()]['idProductoTalle'] = $talle->getIdProductoTalle();
                $items[$talle->getIdProductoTalle()]['denominacion'] = $talle->getDenominacion();
                $items[$talle->getIdProductoTalle()]['childs'][$color->getIdProductoColor()]['idProductoColor'] = $color->getIdProductoColor();
                $items[$talle->getIdProductoTalle()]['childs'][$color->getIdProductoColor()]['denominacion'] = $color->getDenominacion();
                $items[$talle->getIdProductoTalle()]['childs'][$color->getIdProductoColor()]['stock'] = $currentStock;
                $items[$talle->getIdProductoTalle()]['childs'][$color->getIdProductoColor()]['imagen'] = $color->getFamiliaColor()->getImageFilename();
                $stockTotal += $currentStock;
            }
        }
        
        $estaAgotado = ( $stockTotal <= 0 );
    
        return array('estaAgotado' => $estaAgotado, 'dataProductoItems' => json_encode($items) );
    }
	
}
