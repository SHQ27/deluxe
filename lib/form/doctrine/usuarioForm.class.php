<?php

/**
 * usuario form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuarioForm extends BaseusuarioForm
{
    public function configure()
    {
    	$isBackend = $this->getOption('isBackend');
    	$eshop = $this->getOption('eshop');
    	
        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);
        
        unset($this->validatorSchema['fecha_alta']);
                
        $years = range(date('Y') - 100, date('Y') - 16 );
        rsort($years);
        $this->setWidget('fecha_nacimiento', new sfWidgetFormDate(array(
            'years' => array_combine($years, $years),
        	'format' => ( !$isBackend ) ? '<div class="customSelect day">%day%</div><div class="customSelect month">%month%</div><div class="customSelect year">%year%</div>' : '%month% / %day% / %year%',
        )));
        
        $sexoChoices = array('m' => 'Mujer', 'h' => 'Hombre');
        
        
        if ($isBackend)
        {
            $this->setWidget('sexo', new sfWidgetFormSelectRadio(array('choices' => $sexoChoices )));
        }
        else
        {
            $this->setWidget('sexo', new sfWidgetFormSelectRadio(array(
                'choices' => $sexoChoices,
                'formatter' => array($this, 'radioFormater'), 
            )));
        }
        

        $this->setValidator('sexo', new sfValidatorChoice(array('choices' => array_keys($sexoChoices))));
        if ( !$this->getDefault('sexo') ) { $this->setDefault('sexo', 'm'); }
        
        $this->setWidget('email', new sfWidgetFormInputText( array(), array('maxlength' => 50)));
        $this->setValidator('email', new sfValidatorEmail(array('max_length' => 50, 'required' => true)));
        
        $this->setWidget('referrer', new sfWidgetFormInputHidden());
        $this->setValidator('referrer', new sfValidatorPass());
        
        
        $choicesDoc = array(''=>'','DNI'=>'DNI', 'LC'=>'LC', 'LE'=>'LE');
		$this->setWidget('tipo_documento', new sfWidgetFormSelect(array( 'choices' => $choicesDoc)));
		$this->setValidator('tipo_documento', new sfValidatorChoice(array('required' => false, 'choices'=>array_keys($choicesDoc))));
		
		$this->setValidator('documento', new pmValidatorDocumento(array('required' => false)));
		$this->setWidget('documento', new sfWidgetFormInput());
		
		$this->setWidget('password', new sfWidgetFormInputPassword());
		
		
        if ($isBackend)
        {
            $this->setValidator('password', new sfValidatorString( array('required'=> false) ));
            $this->setWidget('fecha_alta', new sfWidgetFormInputHidden());
            $this->setWidget('fecha_confirmacion', new sfWidgetFormInputHidden());
        }
        else 
        {
            $this->setValidator('password', new sfValidatorString( array('required'=> true) ));
            $this->setWidget('terminos', new sfWidgetFormInputCheckbox(array(), array('class' => 'check')));
            $this->setValidator('terminos', new sfValidatorString());
        }
	    
	    // Validacion de usuario unico
	    $this->validatorSchema->setPostValidator( new pmValidatorUsuarioUnique( array('eshop' => $eshop) ) );
	    
    }
    
    public function radioFormater($widget, $fields) {
        $html = '';
        
        foreach ($fields as $field) {
            $html .= sprintf('<div class="radio small">%s</div> %s', $field['input'], str_replace('<label', '<label class="radioLabel"', $field['label']) );
        }
        return '<div class="rowRadio">' . $html . '</div>';
    }

  protected function doSave($con = null)
  {
        $eshop = $this->getOption('eshop');
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
      
    	$usuario = $this->getObject();
    	
    	$this->updateObject();
    
    	if ( !$usuario->getDocumento() )
    	{
    		$usuario->setTipoDocumento(null);
    	}
    	
    	$usuario->setIdEshop( $idEshop );
    
    	$usuario->save($con);
  }  
}
