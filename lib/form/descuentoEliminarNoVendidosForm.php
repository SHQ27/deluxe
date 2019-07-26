<?php

class descuentoEliminarNoVendidosForm extends sfFormSymfony
{		
  	public function configure()
  	{
  	    $this->setWidget('codigos', new sfWidgetFormTextarea() );
  	    $this->getWidget('codigos')->setLabel('Codigos Vendidos<br/><small>Separados por [Enter]</small>');
  	    $this->setValidator('codigos', new sfValidatorPass() );
  	    
  	    $this->widgetSchema->setNameFormat('descuentoEliminarNoVendidos[%s]');
  	}

	public function eliminar()
	{
	   $codigos = $this->getValue('codigos');
	   
	   $codigos = explode("\n", $codigos);
	   	   
	   // Si no hay codigos utilizados
	   if ( !count($codigos) ) {
	       return array( 'status' => false, 'message' => 'No se indicaron codigos de cupones utilizados.');
	   }
	   
	   $arr = array();
	   foreach( $codigos as $codigo ) if ( trim($codigo) ) $arr[] = trim($codigo);
	   $codigos = $arr;
	   
	   $base = $codigos[0];
	   
	   $prefix = substr($base, 0, strpos($base, '-') );
	   	   
	   $descuentoBase = descuentoTable::getInstance()->findOneByCodigo( $base );
	   
	   if ( !$descuentoBase ) {
           return array( 'status' => false, 'message' => 'Hay al menos un codigo que no corresponde a un cupon existente.');
       }
	   
       
       $conn = Doctrine_Manager::connection();
       $conn->beginTransaction();
        
       try {
       
           $cantidad = descuentoTable::getInstance()->deleteNoVendidos( $codigos, $prefix, $descuentoBase );
       
           $conn->commit();
       
           return array( 'status' => true, 'cantidad' => $cantidad);
       }
       catch (Exception $e)
       {
           $descuentosError = descuentoTable::getInstance()->descuentosConErrorAlBorrarVendidos( $codigos, $prefix, $descuentoBase );
           
           $conn->rollback();
           return array( 'status' => false, 'message' => 'Se produjo un error al procesar la solicitud.', 'descuentosError' => $descuentosError );
       }
	   
	}
	
}