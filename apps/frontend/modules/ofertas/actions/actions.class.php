<?php

/**
 * ofertas actions.
*
* @package    deluxebuys
* @subpackage ofertas
* @author     Your name here
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class ofertasActions extends deluxebuysActions
{

    /**
     * Executes details action
     *
     * @param sfRequest $request A request object
     */
    public function executeDetails(sfWebRequest $request)
    {
        // Obtengo la campaña        
        $slugCampana = $request->getParameter('slugCampana');
        $campana = campanaTable::getInstance()->getBySlug($slugCampana);
        
        if (!$campana || !$campana->getActivo()) {
            $this->redirect('/');
        }
                
        // Captura de Filtros
        $filtros['marcas'] 	    = $request->getParameter('marcas', array());
        $filtros['categorias']  = $request->getParameter('categorias', array());
        $filtros['talles'] 	    = $request->getParameter('talles', array());
        $filtros['colores']     = $request->getParameter('colores', array());
        $filtros['rango']	    = $request->getParameter('rango', array());
        $filtros['order']       = $request->getParameter('order', null);
        $filtros['idCampana']   = $campana->getIdCampana();

        // Obtengo las categorias donde la campaña tiene productos
        $productoCategorias = productoCategoriaTable::getInstance()->listKeysByIdCampana( $campana->getIdCampana() );
        
		// Get current page, is not set default will be 1
        $page = $request->getParameter('page', 1);
        
        // Products 
        $productoQuery = productoTable::getInstance()->queryActivosByIdCampana(  
        	$page,
        	$filtros
        );
        
        // Paginator
        $pager = new Doctrine_Pager
        (
                $productoQuery,
                $page,
                sfConfig::get('app_rpp_productos_oferta')
        );
        
        // Seteo de variables en la vista
        $this->pager = $pager;
        $this->productos = $pager->execute();
        
        $this->productoCategorias = $productoCategorias;
        $this->campana = $campana;
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

}
