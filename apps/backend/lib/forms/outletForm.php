<?php

class outletForm extends sfFormSymfony
{
  	public function configure()
  	{  	    
  	    $outlet = $this->getOption('outlet');
  	    
  	    $data = json_decode($outlet->getValor(), true);
  	      	      	    
  	    // Denominacion
        $this->setWidget('denominacion', new sfWidgetFormInputText() );
  	    $this->getWidget('denominacion')->setDefault( $data['denominacion'] );
        $this->setValidator('denominacion', new sfValidatorString(array('max_length' => 255, 'required' => true)));
        
        // Fechas
        $this->setWidget('fecha_inicio', new pmWidgetFormDateTime( array('time' => array('minutes' => array('0' => '00', '30' => '30'))) ));
        $this->getWidget('fecha_inicio')->setDefault( $data['fecha_inicio'] );
        
        $this->setValidator('fecha_inicio', new sfValidatorDateTime(
                array('required' => false),
                array('invalid' => 'Fecha inválida.')));
        
        $this->setWidget('fecha_fin', new pmWidgetFormDateTime( array('time' => array('minutes' => array('0' => '00', '30' => '30'))) ));
        $this->getWidget('fecha_fin')->setDefault( $data['fecha_fin'] );
        
        $this->setValidator('fecha_fin', new sfValidatorDateTime(
                array('required' => false),
                array('invalid' => 'Fecha inválida.')));
        
        // Activo
        $this->setWidget('activo', new sfWidgetFormInputCheckbox() );
        $this->getWidget('activo')->setDefault( $data['activo'] );
        $this->setValidator('activo', new sfValidatorBoolean(array('required' => false)));

        // Mostrar Banner
        $this->setWidget('mostrar_banner', new sfWidgetFormInputCheckbox() );
        $this->getWidget('mostrar_banner')->setDefault( $data['mostrar_banner'] );
        $this->setValidator('mostrar_banner', new sfValidatorBoolean(array('required' => false)));
        

        // Mostrar Descripcion
        $this->setWidget('mostrar_descripcion', new sfWidgetFormInputCheckbox() );
        $this->getWidget('mostrar_descripcion')->setDefault( $data['mostrar_descripcion'] );
        $this->getWidget('mostrar_descripcion')->setLabel( 'Mostrar banda inferior en home' );        
        $this->setValidator('mostrar_descripcion', new sfValidatorBoolean(array('required' => false)));
        
        $outlet = new outlet();
        
        // Imagen Header
        $this->setWidget( "header", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('outlet_header', $outlet) ) );
        
        $this->setValidator( "header", new sfValidatorFile
                (
                        imageHelper::getInstance()->getOptionForValidator('outlet_header', $outlet),
                        imageHelper::getInstance()->getMessagesForValidator('outlet_header')
                ));
        
        $this->setValidator( "header_delete", new sfValidatorBoolean() );
        
        // Imagen Banner Principal
        $this->setWidget( 'banner_principal', new sfWidgetFormInputFile( array(), array( 'multiple' => 'multiple', 'name' => 'banner_principal[]' ) ) );
        $this->setValidator( 'banner_principal', new sfValidatorPass() );
        
        // Imagen Banner
        $this->setWidget( "banner", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('outlet_banner', $outlet) ) );
        
        $this->setValidator( "banner", new sfValidatorFile
                (
                        imageHelper::getInstance()->getOptionForValidator('outlet_banner', $outlet),
                        imageHelper::getInstance()->getMessagesForValidator('outlet_banner')
                ));
        
        $this->setValidator( "banner_delete", new sfValidatorBoolean() );

        // Imagen Banner Hover
        $this->setWidget( "banner_hover", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('outlet_banner', $outlet, 'hover') ) );
        
        $this->setValidator( "banner_hover", new sfValidatorFile
                (
                        imageHelper::getInstance()->getOptionForValidator('outlet_banner', $outlet, 'hover'),
                        imageHelper::getInstance()->getMessagesForValidator('outlet_banner')
                ));
        
        $this->setValidator( "banner_hover_delete", new sfValidatorBoolean() );
	    
        // Off
        $choices = array('0' => 'No mostrar');
        for ( $i = 5 ; $i <= 100 ; $i=$i+5 ) $choices[$i] = $i . '%';
        $this->setWidget('off', new sfWidgetFormSelect( array('choices' => $choices) ) );
        $this->getWidget('off')->setLabel('Porcentaje de Descuento');
        $this->setValidator('off', new sfValidatorPass() );

        if ( isset( $data['off'] ) )
        {
            $this->getWidget('off')->setDefault( $data['off'] );
        }
        
        // Permitir Pago Offline
        $this->setWidget('permitir_pago_offline', new sfWidgetFormInputCheckbox() );
                
        if ( isset( $data['permitir_pago_offline'] ) )
        {
            $this->getWidget('permitir_pago_offline')->setDefault( $data['permitir_pago_offline'] );
        }
        
        $this->setValidator('permitir_pago_offline', new sfValidatorBoolean(array('required' => false)));	

		// Estimacion Envio
		
		$this->setWidget('estimacion_envio_fecha', new pmWidgetFormDate());
		
		$this->setValidator('estimacion_envio_fecha', new sfValidatorDate(
		    array('required' => false),
		    array('invalid' => 'Fecha inválida.')));
		
		$this->setWidget('estimacion_envio_fecha', new pmWidgetFormDate());
		
		$this->setValidator('estimacion_envio_fecha', new sfValidatorDate(
		    array('required' => false),
		    array('invalid' => 'Fecha inválida.')));
				
		if ( isset( $data['estimacion_envio_fecha'] ) )
		{
		    $this->getWidget('estimacion_envio_fecha')->setDefault( $data['estimacion_envio_fecha'] );
		}
		
		$choices = array('' => '', '24' => '24hs', '48' => '48hs', '72' => '72hs');
		$this->setWidget('estimacion_envio_horas', new sfWidgetFormSelect( array('choices' => $choices) ));
		$this->setValidator('estimacion_envio_horas', new sfValidatorChoice( array('choices' => array_keys($choices), 'required' => false)));
		
		if ( isset( $data['estimacion_envio_horas'] ) )
		{
		    $this->getWidget('estimacion_envio_horas')->setDefault( $data['estimacion_envio_horas'] );
		}
		
		// Form Name Format
		$this->getWidgetSchema()->setNameFormat('outlet[%s]');
  	}

  	
  	public function save($outlet)
  	{

  	    $denominacion = $this->getValue('denominacion');
  	    $fechaInicio = $this->getValue('fecha_inicio');
  	    $fechaFin = $this->getValue('fecha_fin');
  	    $activo = $this->getValue('activo');
  	    $mostrarBanner = $this->getValue('mostrar_banner');
  	    $mostrarDescripcion = $this->getValue('mostrar_descripcion');  	    
  	    $bannerFile = $this->getValue('banner');
        $bannerHoverFile = $this->getValue('banner_hover');
  	    $headerFile = $this->getValue('header');
  	    $off = $this->getValue('off');
  	    $permitirPagoOffline = $this->getValue('permitir_pago_offline');
  	    $estimacionEnvioFecha = $this->getValue('estimacion_envio_fecha');
  	    $estimacionEnvioHoras = $this->getValue('estimacion_envio_horas');

        $data = json_decode($outlet->getValor(), true);
        $orden = $data['orden'];
  	    
  	    if ( $_POST['estimacion_tipo'] == 'FECHAS' ) {
  	        $estimacionEnvioHoras = null;
  	    } else {
  	        $estimacionEnvioFecha = null;
  	    }  	    
  	    
  	    unset($this->values['header']);
        unset($this->values['banner']);
        unset($this->values['banner_hover']);
  	    
  	    // Data
  	    $data = array(
            'denominacion' => $denominacion,
            'activo' => $activo,
            'mostrar_banner' => $mostrarBanner,
  	        'mostrar_descripcion' => $mostrarDescripcion,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'off' => $off,
            'permitir_pago_offline' => $permitirPagoOffline,
            'estimacion_envio_fecha' => $estimacionEnvioFecha,
            'estimacion_envio_horas' => $estimacionEnvioHoras,
            'orden' => $orden
        );
  	    
  	    
  	    $outlet->setValor( json_encode($data) );
  	    $outlet->save();
  	    
        // Imagenes
  	    $outlet = new outlet();
  	    
        imageHelper::getInstance()->processDeleteFile('outlet_header', $outlet, $this->getValue('header_delete') );
        imageHelper::getInstance()->processDeleteFile('outlet_banner', $outlet, $this->getValue('banner_delete') );
        imageHelper::getInstance()->processDeleteFile('outlet_banner', $outlet, $this->getValue('banner_hover_delete'), 'hover');
        
        $bannersPrincipal = $_FILES['banner_principal'];
        $cantidadImagenes = ( isset($bannersPrincipal['tmp_name']) && $bannersPrincipal['tmp_name'][0] )? count($bannersPrincipal['tmp_name']) : 0;
            
        for ( $i = 0 ; $i < $cantidadImagenes ; $i++ )
        {
            $tmpName = $bannersPrincipal['tmp_name'][$i];
            
            $unique = md5(uniqid(rand(), true));
            $savePath = imageHelper::getInstance()->getPath('outlet_banner_principal', $outlet, $unique );
            imageHelper::getInstance()->processSaveFile('outlet_banner_principal', $outlet, $tmpName, $savePath );
            
            $imagenBannerPrincipal = new imagenBannerPrincipal();
            $imagenBannerPrincipal->setId( 1 );
            $imagenBannerPrincipal->setTipo( imagenBannerPrincipal::TIPO_OUTLET );
            $imagenBannerPrincipal->setSrc( 'outlet_' .  $unique . '.jpg' );
            $imagenBannerPrincipal->save();
        }
  	    
        imageHelper::getInstance()->processSaveFile('outlet_header', $outlet, $headerFile);
        imageHelper::getInstance()->processSaveFile('outlet_banner', $outlet, $bannerFile);
        imageHelper::getInstance()->processSaveFile('outlet_banner', $outlet, $bannerHoverFile, null, 'hover');

  	}
  	
}