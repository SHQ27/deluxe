<?php

class eshopFormularioForm extends sfFormSymfony
{
  	public function configure()
  	{  	  		
  		$eshop = eshopTable::getInstance()->getCurrent();

  		$campos = json_decode($eshop->getFormularioCampos(), true);

      if ( $campos && count($campos) ) {
    		foreach ($campos as $i => $row) {
    			if ( $row['es_largo'] ) {
    				$this->setWidget( 'campo_' . $i, new sfWidgetFormTextarea() );  				
    			} else {
    				$this->setWidget( 'campo_' . $i, new sfWidgetFormInput() );
    			}

    			$this->getWidget( 'campo_' . $i)->setLabel( $row['label'] );
    			$this->setValidator( 'campo_' . $i, new sfValidatorPass() );
    		}
      }
	    
		  $this->getWidgetSchema()->setNameFormat('eshopFormularioForm[%s]');
  	}

	public function send()
	{

    $values = $this->getValues();
    $eshop = eshopTable::getInstance()->getCurrent();
    $campos = json_decode($eshop->getFormularioCampos(), true);

    $data = array();
    foreach ($campos as $i => $row) {
      $data[ $row['label'] ] = $values['campo_' . $i];
    }

    $subject = 'Enviado desde el formulario en ' . $eshop->getDominio();
    $mailer = new Mailer('eshopFormulario', array( 'title' => $subject, 'eshop' => $eshop, 'data' => $data ));
    $mailer->send( $subject, $eshop->getFormularioTo(), $eshop->getEmailNoReply() );
	}
};