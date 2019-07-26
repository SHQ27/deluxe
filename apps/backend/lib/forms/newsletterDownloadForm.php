<?php

class newsletterDownloadForm extends sfFormSymfony
{
  	public function configure()
  	{
  	    $this->setWidget('password', new sfWidgetFormInputPassword() );
  	    $this->getWidget('password')->setLabel('Contraseña');
  	    $this->setValidator('password', new sfValidatorString( array('required' => false) ));
  	          	
      	$this->getWidgetSchema()->setNameFormat('newsletterDownloadForm[%s]');
  	}
  	
  	public function download()
  	{
  	    $password = $this->getValue('password');
  	    
  	    if ( $password == 's4nm4rt1n' )
  	    {
      	    $filepath = newsletterTable::getInstance()->exportFile();
      	    
      	    $data = file_get_contents( $filepath);
      	    
      	    header("Content-type: application/octet-stream");
      	    header("Content-Disposition: attachment; filename=newsletter_data.csv");
      	    echo "Nombre,Apellido,Email,Sexo,eShop,Fecha de Suscripcion\n" . $data;
      	    
      	    unlink($filepath);
      	    exit;
  	    }
  	}
  	
}