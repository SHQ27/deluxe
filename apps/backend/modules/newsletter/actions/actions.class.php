<?php

require_once dirname(__FILE__).'/../lib/newsletterGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/newsletterGeneratorHelper.class.php';

/**
 * newsletter actions.
 *
 * @package    sf_sandbox
 * @subpackage newsletter
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterActions extends autoNewsletterActions
{
	
  public function executeDownload(sfWebRequest $request)
  {
      $form = new newsletterDownloadForm();
  
      if( $request->isMethod('post') )
      {
          $form->bind( $request->getParameter('newsletterDownloadForm') );
            
          if ( $form->isValid() )
          {
              $form->download();
          }
      }
      
      $this->form = $form;
  }
  
}
