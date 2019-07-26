<?php

class productosComponents extends abstractProductosComponents
{
    
  public function executeWaitList(sfWebRequest $request)
  { 
  	$this->form = new addProductoForm( array('id_producto' => $this->producto->getIdProducto() ) );
  	
  	if ( isset( $this->producto->is_waiting_list_calculado ) )
  	{
  	    $this->isWaiting = $this->producto->getIsWaitingListCalculado();
  	}
  	else 
  	{
  	    $this->isWaiting = waitingListTable::getInstance()->isWaiting( $this->producto->getIdProducto() );
  	}
  }  
  
}