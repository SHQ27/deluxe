<?php

class ordenarHomeForm extends sfFormSymfony
{
  	public function configure()
  	{  	      	      	      	    
      $this->setWidget('data', new sfWidgetFormInputHidden() );
      $this->setValidator('data', new sfValidatorPass() );
        
  		$this->getWidgetSchema()->setNameFormat('ordenarHome[%s]');
  	}

  	
  	public function save()
  	{
  	    $data = $this->getValue('data');
        $data = json_decode($data, true);

        foreach ($data as $id => $orden) {
          $arr = explode('-', $id);;
          $class = $arr[0];
          $id = $arr[1];

          if ( $class == 'campana' ) {
            campanaTable::getInstance()->updateOrden( $id, $orden );
          } else if ( $class == 'bannerPrincipal' ) {
            bannerPrincipalTable::getInstance()->updateOrden( $id, $orden );
          } else {
            $outlet = configuracionTable::getInstance()->getOutlet();
    
            $data = json_decode($outlet->getValor(), true);
            $data['orden'] = $orden;
            
            $outlet->setValor( json_encode($data) );
            $outlet->save();
          }
          
          
        }
  	}
}