<?php

class abstractMiCuentaComponents extends sfComponents
{    
    public function executeDevoluciones()
    {        
        $usuario = $this->getUser()->getCurrentUser();
        $limiteDevolucion = ( $usuario->getDiasDevolucion() ) ? $usuario->getDiasDevolucion() : sfConfig::get('app_devolucion_dias');
         
        $pedidoProductoItems = pedidoProductoItemTable::getInstance()->listParaDevolucion( $usuario->getIdUsuario(), $limiteDevolucion );
         
        $idCategorias = array();
        $outlet = array();
        foreach( $pedidoProductoItems as $pedidoProductoItem )
        {
            $producto = $pedidoProductoItem->getProductoItem()->getProducto();
            $idCategorias[ $pedidoProductoItem->getIdPedidoProductoItem() ] = $producto->getIdProductoCategoria();
            $outlet[ $pedidoProductoItem->getIdPedidoProductoItem() ] = $pedidoProductoItem->esOutlet();
        }
    
        $this->idCategorias = json_encode( $idCategorias );
        $this->outlet = json_encode( $outlet );

        $eshop = eshopTable::getInstance()->getCurrent();

        if ( $eshop ) {
            $devolucionRestringidaData           = $eshop->getDevolucionRestringidaData();
            $this->idCategoriasRestringidas      = json_encode($devolucionRestringidaData['ids']);
            $this->mensajeCategoriasRestringidas = $devolucionRestringidaData['mensaje'];
        } else {
            $this->idCategoriasRestringidas      = sfConfig::get('app_categoriaDevolucionRestringida_ids');
            $this->mensajeCategoriasRestringidas = sfConfig::get('app_categoriaDevolucionRestringida_mensaje');
        }
             
        $this->pedidoProductoItems = $pedidoProductoItems;
         
        $request = $this->getRequest();
    
        $form = new devolucionesForm();
        $this->form = $form;
         
        $this->procesado = $request->getParameter('procesado', false);
        $this->historial = devolucionTable::getInstance()->listHistorial( $usuario->getIdUsuario() );
    }
}
