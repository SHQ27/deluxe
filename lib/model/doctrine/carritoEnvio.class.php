<?php

/**
 * carritoEnvio
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class carritoEnvio extends BasecarritoEnvio
{
	const DOMICILIO = 'DOM';
	const SUCURSAL  = 'SUC';
	

	public function convertToArray()
	{		
		return json_decode( $this->getEnviopackData(), true );
	}
	
	public function getCostoDeluxe($withFormat = true)
	{
		$data = $this->convertToArray();

	    $pesoTotalCarrito = carritoProductoItemTable::getInstance()->getPesoByIdSesion( $this->getIdSession() );	    
	    $campana = campanaTable::getInstance()->getCampanaEnCarrito( $this->getIdSession() );
	    
	    $eshop = eshopTable::getInstance()->getCurrent();
	    $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
	
	    if ( $data['tipo'] === self::DOMICILIO ) {
	    	$codigoPostal = $data['codigoPostal'];
	    } else {
	    	$sucursal = EnvioPack::getInstance( $idEshop )->sucursal( $data['idSucursal'] );	
	    	$codigoPostal = $sucursal['codigo_postal'];
	    }

	    $costo =  EnvioPack::getInstance( $idEshop )->costoDeluxe( $codigoPostal, $data['correo'], $pesoTotalCarrito, $data['tipo'], $data['servicio'] );

	    return ($withFormat) ? formatHelper::getInstance()->decimalNumber( $costo ) : $costo;
	}
	
	public function getCosto($withFormat = true)
	{	
		$eshop = eshopTable::getInstance()->getCurrent();
	    $campana = campanaTable::getInstance()->getCampanaEnCarrito( $this->getIdSession() );
	    $montoFreeShipping = configuracionTable::getInstance()->montoFreeShipping( $eshop, $campana );
		$montoProductos = sessionTable::getInstance()->getMontoProductos( $this->getIdSession() );
		
	    if ( $montoProductos >= $montoFreeShipping ) {
	    	$costo = 0;
	    } else {

			$data = $this->convertToArray();
		    $pesoTotalCarrito = carritoProductoItemTable::getInstance()->getPesoByIdSesion( $this->getIdSession() );	    
		    $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
		
		    if ( $data['tipo'] === self::DOMICILIO ) {

		    	$codigoPostal = $data['codigoPostal'];

			    $costo = EnvioPack::getInstance( $idEshop )->costoProvincia(
			    	$codigoPostal,
			    	$data['idProvincia'],
			    	$pesoTotalCarrito,
			    	$data['servicio']
		    	);

		    } else {

		    	$sucursal = EnvioPack::getInstance( $idEshop )->sucursal( $data['idSucursal'] );	
		    	$codigoPostal = $sucursal['codigo_postal'];

				$costo =  EnvioPack::getInstance( $idEshop )->costoCorreo(
					$codigoPostal,
					$data['correo'],
					$pesoTotalCarrito,
					$data['tipo'],
					$data['servicio']
				);

		    }
	    }
	    	    
	    return ($withFormat) ? formatHelper::getInstance()->decimalNumber( $costo ) : $costo;
	}
	
}
