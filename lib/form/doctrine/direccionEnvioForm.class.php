<?php

/**
 * direccionEnvio form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class direccionEnvioForm extends BasedireccionEnvioForm
{
    public function configure()
    {
        $this->setWidget('id_provincia', new sfWidgetFormDoctrineChoice(array('model' => 'Provincia','table_method' => 'listAll')) );
        $this->setDefault('id_provincia', $this->getObject()->getIdProvincia());
        $this->setValidator('id_provincia', new sfValidatorPass());
        
        $this->setValidator('calle', new sfValidatorString(array('max_length' => 30, 'required' => true) ) ); 
        $this->setValidator('numero', new sfValidatorNumber(
                                                    array('min' => 0, 'max' => 99999, 'required' => true),
                                                    array('invalid' => 'Debe ser un número') ));
        
        
        $choices = codigoPostalTable::getInstance()->listAll();

        $this->setValidator('codigo_postal', new sfValidatorAnd(
        	array( 
	        	new sfValidatorChoice(
	            	array('choices' => $choices),
	                array('invalid' => 'El codigo postal debe existir y ser un valor de 4 digitos')),
	        	new pmValidatorCpByState(
	        		array('key' => 'id_provincia', 'form' => 'direccion_envio'))
        	),
       		array()
        ));
        
                
        // Definicion de max length para cada campo 
        $this->getWidget('calle')->setAttribute('maxlength', 30);
        $this->getWidget('numero')->setAttribute('maxlength', 5);
        $this->getWidget('piso')->setAttribute('maxlength', 6);
        $this->getWidget('depto')->setAttribute('maxlength', 4);
        $this->getWidget('codigo_postal')->setAttribute('maxlength', 4);
        
    }

    /**
     * 
     * @see sfFormObject::save()
     */
    public function save($conn = null)
    {
    	$values = $this->getValues();
    	
    	$dir = direccionEnvioTable::getInstance()->getByIdUsuario( $values['id_usuario'] );
    	
    	// If send dir does not exist for current user, create one
    	if ( !$dir )
    	{
    		$dir = new direccionEnvio();
    		$dir->setIdUsuario($values['id_usuario']);
    	}

    	$dir->setCalle($values['calle'])
    		->setCodigoPostal($values['codigo_postal'])
    		->setNumero($values['numero'])
    		->setPiso($values['piso'])
    		->setDepto($values['depto'])
    		->setIdProvincia($values['id_provincia'])
    		->setLocalidad($values['localidad']);
    	
    	$dir->save();
    }
    
}
