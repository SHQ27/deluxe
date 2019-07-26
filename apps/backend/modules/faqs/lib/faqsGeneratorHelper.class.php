<?php

/**
 * faqs module helper.
 *
 * @package    deluxebuys
 * @subpackage faqs
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faqsGeneratorHelper extends BaseFaqsGeneratorHelper
{
    
    public function linkToNew($params)
    {
        return '<li class="sf_admin_action_new">'.link_to(__($params['label'], array(), 'sf_admin'), url_for($this->getUrlForAction('new')) . '?id_faq_categoria=' . $_GET["id_faq_categoria"] ).'</li>';
    }
    
    public function linkToEdit($object, $params)
    {
        return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), url_for($this->getUrlForAction('edit'), $object) . '?id_faq_categoria=' . $_GET["id_faq_categoria"] ).'</li>';
    }
    
    public function linkToList($params)
    {
        $faq = (isset($params["faq"]))? $params["faq"] : null;
        $idFaqCategoria = ($faq)? $faq->getIdFaqCategoria() : $_GET["id_faq_categoria"];
        return '<li class="sf_admin_action_list">'.link_to(__($params['label'], array(), 'sf_admin'), url_for($this->getUrlForAction('list')) . '?id_faq_categoria=' . $idFaqCategoria ).'</li>';
    }
    
    public function linkVolver()
    {
        return '<li class="sf_admin_action_list">'.link_to("Volver al listado de Categorias de Faq", '/backend/faqCategorias' ).'</li>';
    }
        
}