<?php

require_once dirname(__FILE__).'/../lib/faqCategoriasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/faqCategoriasGeneratorHelper.class.php';

/**
 * faqCategorias actions.
 *
 * @package    deluxebuys
 * @subpackage faqCategorias
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faqCategoriasActions extends autoFaqCategoriasActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $filters = $this->getFilters();
        $idEshop = ( isset( $filters['id_eshop'] ) ) ? $filters['id_eshop'] : null;        
        
        // sorting
        if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
        {
            $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
        }
    
        // pager
        if ($request->getParameter('page'))
        {
            $this->setPage($request->getParameter('page'));
        }
    
        $this->pager = $this->getPager();
        $this->sort = $this->getSort();
        $this->idEshop = $idEshop;
    }
    
    public function executeListGoToFaqs(sfWebRequest $request)
    {
        $faqCategoria = $this->getRoute()->getObject();
        $this->redirect('/backend/faqs?id_faq_categoria=' . $faqCategoria->getIdFaqCategoria());
    }
    
    public function executeBajar(sfWebRequest $request)
    {
        $faqCategoria = $this->getRoute()->getObject();
    
        $currentOrden = $faqCategoria->getOrden();
        $faqCategoriaAnterior = FaqCategoriaTable::getInstance()->getPrev( $faqCategoria->getIdEshop(), $faqCategoria->getOrden() );
    
        $ordenAnterior = $faqCategoriaAnterior->getOrden();
    
        //intercambio los ordenes
        $faqCategoriaAnterior->setOrden($currentOrden);
        $faqCategoriaAnterior->save();
    
        $faqCategoria->setOrden($ordenAnterior);
    
        $faqCategoria->save();
        $this->redirect('@faq_categoria');
    }
    
    public function executeSubir(sfWebRequest $request)
    {
        $faqCategoria = $this->getRoute()->getObject();
    
        $currentOrden = $faqCategoria->getOrden();
        $faqCategoriaSiguiente = FaqCategoriaTable::getInstance()->getNext( $faqCategoria->getIdEshop(), $faqCategoria->getOrden() );
        $ordenSiguiente = $faqCategoriaSiguiente->getOrden();
    
        //intercambio los ordenes
        $faqCategoriaSiguiente->setOrden($currentOrden);
        $faqCategoriaSiguiente->save();
    
        $faqCategoria->setOrden($ordenSiguiente);
    
        $faqCategoria->save();
        $this->redirect('@faq_categoria');
    }
    
}
