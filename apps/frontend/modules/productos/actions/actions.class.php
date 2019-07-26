<?php

/**
 * productos actions.
 *
 * @package    deluxebuys
 * @subpackage productos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productosActions extends abstractProductosActions
{	
    
    /**
     * Executes listado action
     *
     * @param sfRequest $request A request object
     */
    public function executeListado(sfWebRequest $request)
    { 
        // Obtengo el objeto productoGenero asociado al slug
        $slugProductoGenero = $request->getParameter('slugProductoGenero');
        $productoGenero = productoGeneroTable::getInstance()->getBySlug( $slugProductoGenero );

        // Filtros adicionales
        $filtros = array(
            'idProductoGenero' => $productoGenero->getIdProductoGenero()
        );
        
        // Creo el listado
        $this->createListado($request, $productoGenero->getIdProductoGenero(), $filtros);
        
        // Seteo de variables adicionales en template
        $this->productoGenero = $productoGenero;

        $this->idMarcas = (!empty($filtros['marcas'])) ? explode(",", $filtros['marcas']) : array();
    }
    
    /**
     * Executes sticker action
     *
     * @param sfRequest $request A request object
     */
    public function executeSticker(sfWebRequest $request)
    {
        // Obtengo el objeto productoGenero asociado al slug
        $slugProductoGenero = $request->getParameter('slugProductoGenero');
        $productoGenero = productoGeneroTable::getInstance()->getBySlug( $slugProductoGenero );
    
        // Obtengo el objeto productoCategoria asociado al slug
        $slugProductoSticker = $request->getParameter('slugProductoSticker');
        $productoSticker = productoStickerTable::getInstance()->findOneBySlug( $slugProductoSticker );
        
        // Filtros
        $filtros['marcas']              = $request->getParameter('marcas', array());
        $filtros['categorias']          = $request->getParameter('categorias', array());
        $filtros['talles']              = $request->getParameter('talles', array());
        $filtros['colores']             = $request->getParameter('colores', array());
        $filtros['rango']               = $request->getParameter('rango', array());
        $filtros['order']               = $request->getParameter('order', null);
        $filtros['page']                = $request->getParameter('page', 1);
        $filtros['idProductoGenero']    = $productoGenero->getIdProductoGenero();
        $filtros['idProductoSticker']   = $productoSticker->getIdProductoSticker();
    
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
    
        $this->productoGenero = $productoGenero;
        $this->productoSticker = $productoSticker;
    
        $this->idMarcas = (!empty($filtros['marcas'])) ? explode(",", $filtros['marcas']) : array();
        $this->orden = $filtros['order'];
    
        // Filtros
        $this->query = $queryProductos;
        $this->rango = $filtros['rango'];
    
        $this->setTemplate( 'listaSticker');
    
        // Base URL de Paginacion
        $paginationBaseUrl = preg_replace('/([&|?])page=([0-9]+)/', '', $_SERVER['REQUEST_URI']);
        $paginationBaseUrl .= (stripos($paginationBaseUrl, '?') === false) ? '?' : '&';
    
        $this->paginationBaseUrl = $paginationBaseUrl . 'page=';
    
        if ( $page > 1 ) $this->setLayout(false);
    }
    
    /**
     * Executes detalle action
     *
     * @param sfRequest $request A request object
     */
    public function executeDetalle(sfWebRequest $request)
    {
        // Creo el detalle
        $this->createDetalle($request);
    }
    	
	public function executeDealandia(sfWebRequest $request)
	{		
		$this->cuponProductos = cuponProductoTable::getInstance()->listCuponesDeHoy();		
		$request->setRequestFormat('xml');
		$this->setLayout(false);		
	}
	
	public function executeGetDataProductoItem( sfWebRequest $request )
	{
		$idProducto = $request->getParameter('idProducto');
		$response = $this->makeDataProductoItem( $idProducto, false );
		$dataProductoItems = $response['dataProductoItems'];
		echo $dataProductoItems;
		return sfView::NONE;
	}
	
	/**
	 * Executes busqueda action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeBusqueda(sfWebRequest $request)
	{
	    header("HTTP/1.1 301 Moved Permanently");
	    header("Location: /");
	    exit;
	    
		$busqueda = $request->getParameter('q');

		// Obtengo el id de productoGenero
		$slugProductoGenero = $request->getParameter('genero');
		$productoGenero = productoGeneroTable::getInstance()->getBySlug($slugProductoGenero);
		$idProductoGenero = ($productoGenero)? $productoGenero->getIdProductoGenero() : null;
		 
		// Obtengo el id de productoCategoria
		$slugProductoCategoria = $request->getParameter('categoria');
		$productoCategoria = productoCategoriaTable::getInstance()->getBySlug($slugProductoCategoria, $idProductoGenero);
		$idProductoCategoria = ($productoCategoria)? $productoCategoria->getIdProductoCategoria() : null;
		 		
		// Obtengo el filtro de marcas
		$idMarcas = $request->getParameter('marcas', array());
		if ($idMarcas)
		{
			$idMarcas = explode(',', $idMarcas);
		}
		 
		// Orden
		$orden = $request->getParameter('orden', 'PRECIO_ASC');
		
		// Obtengo la cantidad a mostrar por pagina
		$rpp = explode('|', sfConfig::get('app_rpp_productos_busqueda') );
		$rppValue = $request->getParameter('rpp', $rpp[0]);

		if (strlen($busqueda) > 2)
		{
			$productos = productoTable::getInstance()->queryBusquedaProductos($busqueda, $idProductoGenero, $idProductoCategoria, $idMarcas, $orden);
			$marcas = marcaTable::getInstance()->listarMarcasDeBusqueda($busqueda, $idProductoGenero, $idProductoCategoria);
			
			$productoGeneros = $this->getProductoGeneros($busqueda);
			
			$pager = new Doctrine_Pager
			(
				$productos,
				$request->getParameter('pag', 1),
				$rppValue
			);
		}
		else
		{
			$pager = false;
			$marcas = array();
			$productoGeneros = array();			
		}
		
		// Seteo de variables en la vista
		$this->busqueda = $busqueda;
		
		$this->pager = $pager;
		
		$this->idMarcas = $idMarcas;
		
		$this->marcas = $marcas;
		$this->productoGeneros = $productoGeneros;
		
		$this->idProductoGenero = $idProductoGenero;
		$this->idProductoCategoria = $idProductoCategoria;
		
		$this->orden = $orden;
		
		$this->rpp = $rpp;
		$this->rppValue = $rppValue;
	}
	
	/**
	 * Executes listaTag action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeListaTag(sfWebRequest $request)
	{
	    // Creo el listado de tags
	    $this->createListaTag($request );
	}

	/**
	 * Executes saveMedidas action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeSaveMedidas(sfWebRequest $request)
	{
	    $medidas = $request->getParameter('medidas');
	    
	    $medidas = explode(',', $medidas);
	    foreach($medidas as $medida)
	    {
	        list($idTalleZona, $medida) = explode('-', $medida);
	        
	        if ( sfContext::getInstance()->getUser()->isAuthenticated() )
	        {
	            $usuario = sfContext::getInstance()->getUser()->getCurrentUser();
	            usuarioTalleZonaTable::getInstance()->save($usuario->getIdUsuario(), $idTalleZona, $medida);
	        }
	    }	    
	    exit;
	}

	/**
	 * Executes recomendar action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeRecomendar(sfWebRequest $request)
	{		
		if (!$this->getRequest()->isXmlHttpRequest())
		{
			$this->redirect('/');
			return;
		}
		
		$recomendarProductoForm = new recomendarProductoForm;	
		$recomendarProductoForm->bind($request->getParameter($recomendarProductoForm->getName()));
		
	    if ($recomendarProductoForm->isValid())
	    {
			// Obtengo el producto
			$email = $recomendarProductoForm->getValue('email');
			$idProducto = $recomendarProductoForm->getValue('id_producto');
			
			$producto = productoTable::getInstance()->find( $idProducto );			
			$campana = campanaTable::getInstance()->getFirstFinishedByIdProducto( $idProducto );
						
			$usuario = sfContext::getInstance()->getUser()->getCurrentUser();
			
			// Se envia el mail			
			if ( $usuario )
			{
			    $subject = $usuario->getNombreCompleto() . ' te ha recomendado un producto de DELUXEBUYS';
			}
			else
			{
			    $subject = 'Te han recomendado un producto de DELUXEBUYS';
			}
			
			$title = 'Te han recomendado un producto de DELUXEBUYS!';
			$vars = array( 'title' => $title, 'producto' => $producto, 'campana' => $campana);
			$mailer = new Mailer('recomendarProducto', $vars);
			$mailer->send( $subject, $email);
			
			echo json_encode(array('status'=>'OK'));
	    }
	    
		else
		{
  			echo json_encode(array('status'=>'KO', 'message' => 'El email no es una direccion válida'));
	    }
	    
		return sfView::NONE;
	}	
	
	
	/**
	 * Executes addWaitList action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeAddWaitList(sfWebRequest $request)
	{
		$idProducto = $request->getParameter('idProducto');
		$idTalleProducto = $request->getParameter('idTalleProducto');
		$idColorProducto = $request->getParameter('idColorProducto');
		$cantidad = $request->getParameter('cantidad');
		
		$productoItem = productoItemTable::getInstance()->getByCompoundKey($idProducto, $idTalleProducto, $idColorProducto);
		
		$usuario = sfContext::getInstance()->getUser()->getCurrentUser();
		
		if ($usuario)
		{
			$waitingList =  new waitingList();
			$waitingList->setIdUsuario( $usuario->getIdUsuario() );
			$waitingList->setIdProductoItem( $productoItem->getIdProductoItem() );
			$waitingList->setCantidad( $cantidad );
			$waitingList->save();
			
			echo json_encode(array('status'=>'OK'));
		}
		else 
		{
			$loginURL = $this->getController()->genUrl(array('sf_route' => 'usuario'), false ); 
			echo json_encode( array('status'=>'REDIRECT', 'url' => $loginURL) );
		}
		
		return sfView::NONE;
	}	
	
	/**
	 * Executes detalleShorten action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeDetalleShorten(sfWebRequest $request)
	{
	    $idProducto = $request->getParameter('idProducto');
	    $producto = productoTable::getInstance()->getById($idProducto);
	    $this->redirect( $producto->getDetalleUrl(), 301 );
	}
	
	protected function getProductoGeneros($busqueda)
	{
		$productoCategorias = productoCategoriaTable::getInstance()->listarProductoCategoriasDeBusqueda($busqueda);
		 
		$productoGeneros = array();
		 
		foreach ($productoCategorias as $productoCategoria)
		{
			$idProductoGenero = $productoCategoria->getProductoGenero()->getIdProductoGenero();
			if (!isset($productoGeneros[$idProductoGenero]))
			{
				$productoGeneros[$idProductoGenero] = array(
				'productoGenero' => $productoCategoria->getProductoGenero(),
				'productoCategorias' => array(),
				);
			}
			$productoGeneros[$idProductoGenero]['productoCategorias'][] = $productoCategoria;
		}

		return $productoGeneros;
	}
	
	/**
	 * Executes outlet action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeOutlet(sfWebRequest $request)
	{
	    // Verifico que el outlet este activo
	    $outlet = configuracionTable::getInstance()->getOutlet();
	    $outlet = json_decode($outlet->getValor(), true);
	    
	    if ( !$outlet['activo'] || strtotime($outlet['fecha_inicio']) > time() || strtotime($outlet['fecha_fin']) < time()  )
	    {
	        $this->redirect('/');
	    }
	
	    // Captura de Filtros
	    $filtros['marcas'] 	    = $request->getParameter('marcas', array());
	    $filtros['categorias']  = $request->getParameter('categorias', array());
	    $filtros['talles'] 	    = $request->getParameter('talles', array());
	    $filtros['colores']     = $request->getParameter('colores', array());
	    $filtros['rango']	    = $request->getParameter('rango', array());
	    $filtros['order']       = $request->getParameter('order', null);
	    $filtros['esOutlet']    = true;
	
	    // Productos y paginación
	    $page = $request->getParameter('page', 1);
	
	    $productoQuery = productoTable::getInstance()->queryOutlet($page, $filtros);

	    $pager = new Doctrine_Pager
	    (
	            $productoQuery,
	            $page,
	            sfConfig::get('app_rpp_outlet')
	    );

	    // Seteo de variables en la vista
	    $this->rango = $filtros['rango'];
	    $this->pager = $pager;
	    $this->productos = $pager->execute();
	    $this->query = $productoQuery;
	    $this->outlet = $outlet;
	
	    // Base URL de Paginacion
        $paginationBaseUrl = preg_replace('/([&|?])page=([0-9]+)/', '', $_SERVER['REQUEST_URI']);
        $paginationBaseUrl .= (stripos($paginationBaseUrl, '?') === false) ? '?' : '&';
	
	    $this->paginationBaseUrl = $paginationBaseUrl . 'page=';
	
	    if ( $page > 1 ) $this->setLayout(false);
	
	
	}
	
}
