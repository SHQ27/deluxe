<?php
/**
 * outlet actions.
 *
 * @package    deluxebuys
 * @subpackage outlet
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class outletActions extends sfActions
{
    
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
  public function executeIndex(sfWebRequest $request)
  {
    $outlet = configuracionTable::getInstance()->getOutlet();
        
  	$form = new outletForm( array(), array('outlet' => $outlet));
  	
    if( $request->isMethod('post') )
  	{
  		$form->bind( $request->getParameter('outlet'), $request->getFiles('outlet') );
  		  		
  		if ( $form->isValid() )
  		{
  			$form->save($outlet);
  			$this->redirect('@outlet');
  		}
  	}
  	
  	$this->form = $form;
  }
}
