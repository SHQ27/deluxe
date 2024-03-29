<?php

/**
 * campana
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class campana extends Basecampana
{

    public function preSave($event)   {
        $productoCampanas = productoCampanaTable::getInstance()->listByIdCampana($this->getIdCampana());
        foreach ($productoCampanas as $productoCampana)
        {
            cacheHelper::getInstance()->delete('campana_getFirstByIdProducto_' . $productoCampana->getIdProducto() );
        }

        // Si la campaña no esta activa se elimina su orden
        if ( !$this->getActivo() ) {
        	$this->setOrden( null );
        }
    }
    
    public function postSave($event)   {
        $this->clearCache($event);
    }

    public function preDelete($event)
    {    
        $idCampana = $this->getIdCampana();
        campanaMarcaTable::getInstance()->deleteByIdCampana($idCampana);
        
        // Se elimina la relacion con los productos asignados a la campaña y se anota en el log de producto
        $productoCampanas = productoCampanaTable::getInstance()->listByIdCampana($idCampana);
        foreach( $productoCampanas as $productoCampana )
        {
            productoLogTable::getInstance()->generate($productoCampana->getIdProducto(), 'Se quita de la Campaña #' . $idCampana . ' dado que esta fue eliminada.');
            $productoCampana->delete();
        }
    
        $filename = imageHelper::getInstance()->getPath('campana_header', $this);
    
        if (is_file($filename))
        {
            unlink( $filename );
        }
    
        $filename = imageHelper::getInstance()->getPath('campana_banner', $this);
    
        if (is_file($filename))
        {
            unlink( $filename );
        }
        
        $this->clearCache($event);
    }
    
    public function clearCache($event)
    {
        cacheHelper::getInstance()->delete('campana_listProximas');
        cacheHelper::getInstance()->delete('campana_listProximasFecha');
        cacheHelper::getInstance()->deleteByPrefix('campana_listVigentes');
        campanaTable::getInstance()->listVigentes();
        
        cacheHelper::getInstance()->deleteByPrefix('campana_cacheClearInicioFin');
        cacheHelper::getInstance()->deleteByPrefix('campanas_a_desactivar');
        cacheHelper::getInstance()->deleteByPrefix('campanas_a_resetear');
        cacheHelper::getInstance()->deleteByPrefix('productoCategoria_listByIdProductoGenero');
        cacheHelper::getInstance()->deleteByPrefix('campana_getFirstByIdProducto');
    }
    
	public function __toString()
	{
		return ( $this->getDenominacion() ) ? $this->getDenominacion() : '';
	}
	
	
	public function getImageFilename()
	{
		return $this->getIdCampana() . '.jpg';		
	}
	

	
    public function getMarcas($separator = ' - ')
    {   
		$marcas = array();
		
	  	$campanaMarcas = $this->getCampanaMarca();
	  	
	  	if ($separator === false)
	  	{
	  	    if ( count($campanaMarcas) > 1 )
	  	    {
	  	        return 'Marcas Varias';
	  	    }
	  	    else
	  	    {
	  	        return $campanaMarcas[0]->getMarca()->getNombre();
	  	    }
	  	}
	  	else
	  	{
	  	    foreach ($campanaMarcas as $campanaMarca)
	  	    {
	  	        $marcas[] = $campanaMarca->getMarca()->getNombre();
	  	    }
	  	    
	  	    return implode($separator, $marcas);
	  	}
	} 
	
	public function tieneVariasMarcas()
	{
	    $campanaMarcas = $this->getCampanaMarca();
	    
	    return ( count( $campanaMarcas ) > 1);

	}
	
	public function estaOnline()
	{
	    return strtotime($this->getFechaInicio()) < time() && time() < strtotime($this->getFechaFin());
	}

	public function estaFinalizada()
	{
	    return time() > strtotime($this->getFechaFin());
	}
	
	public function getCantidadPedidosDespachados($idMarca = null)
	{
	    return pedidoTable::getInstance()->getCantidadPedidosDespachados($this->getIdCampana(), $idMarca);
	}
	
	public function resetearStock()
	{
	    $conn = Doctrine_Manager::connection();
	    
	    try
	    {
	        $conn->beginTransaction();
	    
	        $productos = productoTable::getInstance()->listByIdCampana( $this->getIdCampana(), false );
	        foreach ($productos as $producto)
	        {
	            $productosItem = $producto->getProductoItem();
	            foreach ($productosItem as $productoItem)
	            {
	                if ( $productoItem->getStockCampana() > 0 )
	                {
	                    $productoItem->restaStock( $productoItem->getStockCampana(), producto::ORIGEN_OFERTA, stockTipo::SISTEMA_RESETEO_CAMPANA, null, 'Campaña #"' . $this->getIdCampana() .' - ' . $this->getDenominacion() .'"' );
	                }

	                if ( $productoItem->getStockRefuerzo() > 0 )
	                {
	                    $productoItem->restaStock( $productoItem->getStockRefuerzo(), producto::ORIGEN_REFUERZO, stockTipo::SISTEMA_RESETEO_REFUERZO, null, 'Campaña #"' . $this->getIdCampana() .' - ' . $this->getDenominacion() .'"' );
	                }
	            }
	        }
	    
	        $conn->commit();
	        return true;
	    }
	    catch(Doctrine_Exception $e)
	    {
	        $conn->rollback();	        
	        return false;
	    }
	}
	
	public function calculateTextoPromocion($tipo)
	{
	    if ( $tipo == 'MIN' ) {
	        $min = (int) productoTable::getInstance()->getMinPrice( $this->getIdCampana() );
	        $textoPromocion = sprintf('desde $%d', $min);
	    } else {
	        $percentage = (int) productoTable::getInstance()->getMaxDiscountPercentage( $this->getIdCampana() );
	        $textoPromocion = sprintf('hasta %d%% Off', $percentage );
	    }
	    
	    return $textoPromocion;
	}

	public function actualizarTextoPromocion()
	{
	  	$tipoTextoPromocion = ( stripos($this->getTextoPromocion(), '$') !== false ) ? 'MIN' : 'PORC';
	  	$textoPromocion = $this->calculateTextoPromocion( $tipoTextoPromocion );
	  	$this->setTextoPromocion( $textoPromocion );
	  	$this->save();
	}
		
}