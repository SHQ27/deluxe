<?php
/**
 * waitingList actions.
 *
 * @package    deluxebuys
 * @subpackage aws
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class waitingListActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {    	
	  	$form = new waitingListFormFilter();

	  	$params = ( isset( $_SESSION['waitingList_params'] ) ) ? $_SESSION['waitingList_params'] : array();
	  	
	  	if ( $request->isMethod('post') )
	  	{
	  		$params = $request->getParameter($form->getName());
	  		$_SESSION['waitingList_params'] = $params;
	  		$params["_csrf_token"] = $form->getCSRFToken();
	  		
	  	}
	  	
	  	$form->bind($params);
	  	
	  	$pager = new Doctrine_Pager
	  	(
  	        productoTable::getInstance()->queryWaitingListStatics( $params ),
  	        $request->getParameter('page', 1),
  	        30
	  	);
	  	
	  	$this->pagerRange = new Doctrine_Pager_Range_Sliding( array( 'chunk' => 10 ), $pager );	  	
	  	$this->form = $form;
    	
    }
    
    public function executeGetDetails(sfWebRequest $request)
    {
    	$idProducto = $request->getParameter('idProducto');
    	$this->waitList = waitingListTable::getInstance()->listByIdProducto($idProducto);
    }
    
    
    
   
}
