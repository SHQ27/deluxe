<?php

class abstractProductosComponents extends sfComponents
{    

    public function executeProbador(sfWebRequest $request)
    {
        $usaProbadorDefault = false;
    
        $producto = $this->producto;
        $this->idProductoGenero = $this->idProductoGenero;
    
        // Preparo el probador
        $medidasUsuarioJson = 'false';
        if ( sfContext::getInstance()->getUser()->isAuthenticated() )
        {
            $usuario = sfContext::getInstance()->getUser()->getCurrentUser();
            $medidasUsuario = usuarioTalleZonaTable::getInstance()->getMedidas( $usuario->getIdUsuario() );
            if ($medidasUsuario) $medidasUsuarioJson = json_encode($medidasUsuario);
        }
    
        $talleSet = $producto->getTalleSet();
        if ( !$talleSet ) {
            $usaProbadorDefault = true;
        };
    
        if ( !$usaProbadorDefault ) {
            $talleSetZonas = talleSetZonaTable::getInstance()->listByIdTalleSet( $talleSet->getIdTalleSet() );
            if ( !count($talleSetZonas) ) {
                $usaProbadorDefault = true;
            };
        }
    
        // Verifica si tiene que cargar los valores de probador por default
        if ( $usaProbadorDefault && $this->idProductoGenero != productoGenero::NINOS )
        {
            $method = 'getDefault' . $this->idProductoGenero;
            $talleSetZonas = talleSetZonaTable::getInstance()->$method();
        }
    
        $data = $zonas = $talleZonas = array();
        foreach ($talleSetZonas as $talleSetZona)
        {
            $talleZona = $talleSetZona->getTalleZona();
            $productoTalle = $talleSetZona->getProductoTalle();
            $idTalleZona = $talleZona->getIdTalleZona();
    
            if (!isset($zonas[$idTalleZona]))
            {
                $talleZonas[$idTalleZona] = $talleZona;
                $zonas[$idTalleZona] = array('idTalleZona' => $talleZona->getIdTalleZona(), 'min' => false, 'max' => false);
            }
    
            if ($zonas[$idTalleZona]['min'] === false || $zonas[$idTalleZona]['min'] > $talleSetZona->getDesde() )
            {
                $zonas[$idTalleZona]['min'] = $talleSetZona->getDesde();
            }
    
            if ($zonas[$idTalleZona]['max'] === false || $zonas[$idTalleZona]['max'] < $talleSetZona->getHasta() )
            {
                $zonas[$idTalleZona]['max'] = $talleSetZona->getHasta();
            }
    
            $data[ $talleSetZona->getIdTalleZona() ]['denominacion'] = $talleZona->getDenominacion();
            $data[ $talleSetZona->getIdTalleZona() ]['data'][ $talleSetZona->getIdProductoTalle() ]['denominacion'] = $productoTalle->getDenominacion();
            $data[ $talleSetZona->getIdTalleZona() ]['data'][ $talleSetZona->getIdProductoTalle() ]['data']['desde'] = $talleSetZona->getDesde();
            $data[ $talleSetZona->getIdTalleZona() ]['data'][ $talleSetZona->getIdProductoTalle() ]['data']['hasta'] = $talleSetZona->getHasta();
            $data[ $talleSetZona->getIdTalleZona() ]['data'][ $talleSetZona->getIdProductoTalle() ]['data']['orden'] = $talleSetZona->getOrden();
        }
    
        $this->talleSetJson = json_encode($data);
        $this->talleZonas = $talleZonas;
        $this->zonasJson = json_encode(array_values($zonas));
        $this->medidasUsuarioJson = $medidasUsuarioJson;
    
    }
}
