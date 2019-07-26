<?php

/**
 * direccionEnvio
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class direccionEnvio extends BasedireccionEnvio
{
	
	public function convertToArray()
	{				
   		return array
   		(
   			'nombre'	=> $this->getUsuario()->getNombre(),
   			'apellido' 	=> $this->getUsuario()->getApellido(),
   			'calle' => $this->getCalle(),
	   		'numero' => $this->getNumero(),
	   		'piso' => $this->getPiso(),
	   		'depto' => $this->getDepto(),
   			'localidad' =>	$this->getLocalidad(),
   			'provincia' =>	array
   							(
   								'idProvincia'	=> $this->getProvincia()->getIdProvincia(),
   								'nombre'		=> $this->getProvincia()->getNombre()
   							),
   			'codigoPostal' => $this->getCodigoPostal()
   		);
	}
	
}