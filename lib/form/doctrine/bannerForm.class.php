<?php

/**
 * banner form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannerForm extends BasebannerForm
{
  protected $message;
	
  public function configure()
  {
	$banner = $this->getObject();
  	
  	//WIDGET URL
	$w = new sfWidgetFormInput();
  	
    $this->setWidget('url', $w);
	
	$this->setValidator( "url", new sfValidatorUrl
            (
                array(),
                array
                (
                        'required' => 'No ha insertado una dirección URL (ej: http://www.google.com)',
                        'invalid' => 'No ha insertado una dirección URL válida (ej: http://www.google.com)'
                )
            )
	);
	
    //WIDGET ORDEN
	$this->setWidget('orden', new sfWidgetFormInputHidden()) ;
	
	
	if ( $this->isNew() )
	{
	    $ultimoOrden = BannerTable::getInstance()->getLast();
	    $ultimoOrden = ($ultimoOrden)? $ultimoOrden->getOrden() + 1 : 1;
	    $this->setDefault('orden', $ultimoOrden);
	}
	
        
    //WIDGET IMAGEN
    $this->setWidget("imagen", new sfWidgetFormInputFile());

    $required = true;
    
    if (!$this->isNew()) {
        $required = !file_exists(imageHelper::getInstance()->getPath("banner_imagen", $this->getObject()));
    }
    
    $this->setValidator("imagen", new sfValidatorFile(
        array(
            "required" => $required,
            "path" => '/tmp',
        ), array(
            'required' => 'No ha seleccionado ningún elemento.'
        )
    ));
  	
  }   
  
  protected function doSave($con = null)
  {  	
  	$banner = $this->getObject();
  	  	
  	$file = $this->getValue('imagen');

  	unset($this->values['imagen']);
  	
  	$notice = $banner->isNew() ? 'El nuevo banner se creó correctamente.' : 'El banner fue modificado.';
  			      	
    $this->updateObject();

    $banner->save($con);
    
  	$this->setMessage($notice);    
  	
    if (isset($file))
    {
       imageHelper::getInstance()->processDeleteFile('banner_imagen', $banner, true);
       imageHelper::getInstance()->processSaveFile('banner_imagen', $banner, $file);
    }
        
  }
    
  public function getMessage()
  {
  	return $this->message;
  }
  
  public function setMessage($message)
  {
  	$this->message = $message;
  }
  
}
