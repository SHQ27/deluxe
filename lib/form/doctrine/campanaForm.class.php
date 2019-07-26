<?php

/**
 * campana form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class campanaForm extends BasecampanaForm
{
		
  public function getJavaScripts()
  {
  	$js = array('../sfFormExtraPlugin/js/double_list.js', 'formCampana.js');
  	
    return array_merge($js, $this->widgetSchema->getJavaScripts());
  }
	
  public function configure()
  {
    $this->validatorSchema->setOption('allow_extra_fields', true);
      
	$campana = $this->getObject();
  	
    // Se cambian los campos de descripcion por texto enriquecido
    $this->setWidget( "descripcion", new sfWidgetFormTextareaTinyMCE(array( 'width'   => 800, 'height'  => 300 )));
	
	// Imagen Header		
	$this->setWidget( "header", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('campana_header', $campana) ) );
  	
	$this->setValidator( "header", new sfValidatorFile
										(
											imageHelper::getInstance()->getOptionForValidator('campana_header', $campana),
											imageHelper::getInstance()->getMessagesForValidator('campana_header')
										));	
										
	$this->setValidator( "header_delete", new sfValidatorBoolean() );
										
	// Imagen Banner Principal	
	$this->setWidget( 'banner_principal', new sfWidgetFormInputFile( array(), array( 'multiple' => 'multiple', 'name' => 'banner_principal[]' ) ) );
	$this->setValidator( 'banner_principal', new sfValidatorPass() );
	
		
	// Imagen Banner
	$this->setWidget( "banner", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('campana_banner', $campana) ) );
	
	$this->setValidator( "banner", new sfValidatorFile
	        (
	                imageHelper::getInstance()->getOptionForValidator('campana_banner', $campana),
	                imageHelper::getInstance()->getMessagesForValidator('campana_banner')
	        ));
	
	$this->setValidator( "banner_delete", new sfValidatorBoolean() );

	// Imagen Banner Hover
	$this->setWidget( "banner_hover", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('campana_banner', $campana, 'hover') ) );
	
	$this->setValidator( "banner_hover", new sfValidatorFile
	        (
	                imageHelper::getInstance()->getOptionForValidator('campana_banner', $campana, 'hover'),
	                imageHelper::getInstance()->getMessagesForValidator('campana_banner')
	        ));
	
	$this->setValidator( "banner_hover_delete", new sfValidatorBoolean() );


	// Fechas
	
	$this->setWidget('fecha_inicio', new pmWidgetFormDateTime( array('time' => array('minutes' => array('0' => '00', '30' => '30'))) ));
	
	$this->setValidator('fecha_inicio', new sfValidatorDateTime(
												array('required' => false),
												array('invalid' => 'Fecha inválida.')));
												
	$this->setWidget('fecha_fin', new pmWidgetFormDateTime( array('time' => array('minutes' => array('0' => '00', '30' => '30'))) ));
												
	$this->setValidator('fecha_fin', new sfValidatorDateTime(
												array('required' => false),
												array('invalid' => 'Fecha inválida.')));	

	$this->setWidget('estimacion_envio_fecha', new pmWidgetFormDate());
	
	$this->setValidator('estimacion_envio_fecha', new sfValidatorDate(
			array('required' => false),
			array('invalid' => 'Fecha inválida.')));
	
	$this->setWidget('estimacion_envio_fecha', new pmWidgetFormDate());
	
	$this->setValidator('estimacion_envio_fecha', new sfValidatorDate(
	    array('required' => false),
	    array('invalid' => 'Fecha inválida.')));
	
	$choices = array('' => '', '24' => '24hs', '48' => '48hs', '72' => '72hs');
	$this->setWidget('estimacion_envio_horas', new sfWidgetFormSelect( array('choices' => $choices) ));
	$this->setValidator('estimacion_envio_horas', new sfValidatorChoice( array('choices' => array_keys($choices), 'required' => false)));


	// Marcas
	$marcas = marcaTable::getInstance()->listAll();
	$choices = array();
	foreach ($marcas as $marca) $choices[$marca->getIdMarca()] = $marca->getNombre(); 	
	$this->setWidget( "marcas", new sfWidgetFormSelectDoubleList( array('choices' => $choices, 'label_unassociated' => 'No Asociadas', 'label_associated' => 'Asociadas') ) );
	
	$this->setValidator( "marcas", new sfValidatorChoice( array('choices' => array_keys($choices), 'multiple' => true ) ) );
	
	$marcasExistentes = campanaMarcaTable::getInstance()->listByIdCampana( $campana->getIdCampana() );
	$default = array();
	foreach ($marcasExistentes as $marca) $default[] = $marca->getIdMarca();
	$this->getWidget("marcas")->setDefault( $default );
	
	// Comercial
    $this->setWidget( 'id_comercial', new sfWidgetFormDoctrineChoice(array('model' => 'comercial', 'add_empty' => false)));
    $this->setValidator('id_comercial', new sfValidatorPass() );
	
	// Apertura Marca
	$this->setWidget( "apertura_marca", new sfWidgetFormInputText() );
	$this->setValidator('apertura_marca', new sfValidatorPass() );
		
	// Comision Comercial
	$choices = array();
	for($i = 0 ; $i <= 100 ; $i = $i + 1 ) $choices[ sprintf('%.2f', $i/100) ] = "$i%";
	$this->setWidget( "comision_comercial", new sfWidgetFormSelect( array( 'choices' => $choices ) ) );
	$this->setValidator('comision_comercial', new sfValidatorPass() );
	
	// Email para el envio de la orden de compra
	$this->setWidget( "email_orden_compra", new sfWidgetFormInputText() );
	$this->setValidator('email_orden_compra', new sfValidatorPass() );
	
	// Telefono para el envio de la orden de compra
	$this->setWidget( "telefono_orden_compra", new sfWidgetFormInputText() );
	$this->setValidator('telefono_orden_compra', new sfValidatorPass() );
	
	// Booleano para el envio de la orden de compra
	$this->setWidget( "enviar_aviso_orden_compra", new sfWidgetFormInputCheckbox( array(), array('checked' => 'checked') ) );
	$this->setValidator('enviar_aviso_orden_compra', new sfValidatorPass() );
	
	
	// Usuarios
	$this->setWidget( "usuarios", new pmWidgetCampanaUsuarios() );
	$this->setValidator( "usuarios", new sfValidatorPass());
	
	$campanaUsuarios = campanaUsuarioTable::getInstance()->listByIdCampana( $campana->getIdCampana() );
	
	$itemsDefault = array();
	foreach($campanaUsuarios as $campanaUsuario)
	{
		$itemsDefault['email'][] = $campanaUsuario->getEmail();
		$itemsDefault['usuario'][] = $campanaUsuario->getUsuario();
	}
	$this->getWidget('usuarios')->setDefault( $itemsDefault );
	
		
	$this->validatorSchema->setPostValidator(
	        new sfValidatorCallback( array( 'callback' => array($this, 'validateEmailOrdenCompra')) )
	);
	
	// Texto Promocion
	if ( !$this->isNew() )
	{
	    $min = (int) productoTable::getInstance()->getMinPrice( $campana->getIdCampana() );
	    $textoPromocionMin = sprintf('desde $%d', $min);
	
	    $percentage = (int) productoTable::getInstance()->getMaxDiscountPercentage( $campana->getIdCampana() );
	    $textoPromocionPorc = sprintf('hasta %d%% Off', $percentage );
	     
	    $choices = array('PORC' => $textoPromocionPorc, 'MIN' => $textoPromocionMin);
	}
	else
	{
	    $choices = array('PORC' => 'hasta xx% Off', 'MIN' => 'desde $xxx');
	}
	
	// Orden
	$this->setWidget( "orden", new sfWidgetFormInputHidden() );
	
	// Texto Promocion
	$this->setWidget( "texto_promocion", new sfWidgetFormSelectRadio( array('choices' => $choices) ) );
	$this->setValidator( "texto_promocion", new sfValidatorChoice( array('choices' => array_keys($choices) ) ) );

	// Color
    $this->setWidget('color', new sfWidgetFormInputText()) ;
    $this->setValidator("color", new sfValidatorString(
       array(
           "required" => 'false'
       )
    ));
	
	$textoPromocion = ( stripos($campana->getTextoPromocion(), '$') !== false ) ? 'MIN' : 'PORC';
	$campana->setTextoPromocion($textoPromocion);

	
  }

  protected function doSave($con = null)
  {
	$campana = $this->getObject();

  	$bannerFile = $this->getValue('banner');
  	$bannerHoverFile = $this->getValue('banner_hover');
  	$headerFile = $this->getValue('header');
  	
	unset($this->values['header']);
	unset($this->values['banner']);
	unset($this->values['banner_hover']);
	
	$this->updateObject();
	
	if ( $_POST['estimacion_tipo'] == 'FECHAS' ) {
	    $campana->setEstimacionEnvioHoras(null);
	} else {
	    $campana->setEstimacionEnvioFecha(null);
	}
		
	$textoPromocion = $campana->calculateTextoPromocion( $campana->getTextoPromocion() );
	$campana->setTextoPromocion( $textoPromocion );
	
	$campana->save($con);
  	
	// Marcas
	$marcas = $this->getValue('marcas');
	$marcasExistentes = campanaMarcaTable::getInstance()->listByIdCampana( $campana->getIdCampana() );
	$existentes = array();
	foreach ($marcasExistentes as $marca) $existentes[] = $marca->getIdMarca();	
	
	$bajas = array_diff($existentes, $marcas);
	
	foreach ( $bajas as $idMarca )
	{
	    $campanaMarca = campanaMarcaTable::getInstance()->getByCompoundKey($campana->getIdCampana(), $idMarca);
	    $campanaMarca->delete();
	} 
	
	$values = $this->getTaintedValues();
			
	foreach ($marcas as $idMarca)
	{
	    $campanaMarca = campanaMarcaTable::getInstance()->getByCompoundKey($campana->getIdCampana(), $idMarca);
	    
	    if (!$campanaMarca)
	    {
	        $campanaMarca = new campanaMarca();
	    }
	    
	    
		$campanaMarca->setIdCampana( $campana->getIdCampana() );
		$campanaMarca->setIdMarca( $idMarca );
		
		if ( isset( $values[$idMarca] ) )
		{
		    
		    $campanaMarca->setIdComercial( $values[$idMarca]["id_comercial"] );
		    $campanaMarca->setComisionComercial( $values[$idMarca]["comision_comercial"] );
		    $campanaMarca->setAperturaMarca( $values[$idMarca]["apertura_marca"] );
		    
		    $mails = array_filter( $values[$idMarca]["email_orden_compra"], 'strlen' );
		    $campanaMarca->setEmailOrdenCompra( implode(',', $mails) );
		    $campanaMarca->setTelefonoOrdenCompra( $values[$idMarca]["telefono_orden_compra"] );		    
		    $campanaMarca->setEnviarAvisoOrdenCompra( isset($values[$idMarca]["enviar_aviso_orden_compra"]) );
		}
		
		$campanaMarca->save();
	}	

	
	// Imagenes
  	imageHelper::getInstance()->processDeleteFile('campana_header', $campana, $this->getValue('header_delete') );
  	imageHelper::getInstance()->processDeleteFile('campana_banner', $campana, $this->getValue('banner_delete') );
  	imageHelper::getInstance()->processDeleteFile('campana_banner', $campana, $this->getValue('banner_hover_delete'), 'hover' );
  	
  	$bannersPrincipal = $_FILES['banner_principal'];
  	$cantidadImagenes = ( isset($bannersPrincipal['tmp_name']) && $bannersPrincipal['tmp_name'][0] )? count($bannersPrincipal['tmp_name']) : 0;
  	  	
  	for ( $i = 0 ; $i < $cantidadImagenes ; $i++ )
  	{
  	    $tmpName = $bannersPrincipal['tmp_name'][$i];
  	      	    
  	    $unique = md5(uniqid(rand(), true));
  	    $savePath = imageHelper::getInstance()->getPath('campana_banner_principal', $campana, $unique );
  	    imageHelper::getInstance()->processSaveFile('campana_banner_principal', $campana, $tmpName, $savePath );
  	    
  	    $imagenBannerPrincipal = new imagenBannerPrincipal();
  	    $imagenBannerPrincipal->setId( $campana->getIdCampana() );
  	    $imagenBannerPrincipal->setTipo( imagenBannerPrincipal::TIPO_CAMPANA );
  	    $imagenBannerPrincipal->setSrc( $campana->getIdCampana() . '_' .  $unique . '.jpg' );
  	    $imagenBannerPrincipal->save();  	
  	}

  	imageHelper::getInstance()->processSaveFile('campana_header', $campana, $headerFile);
  	imageHelper::getInstance()->processSaveFile('campana_banner', $campana, $bannerFile);
  	imageHelper::getInstance()->processSaveFile('campana_banner', $campana, $bannerHoverFile, null, 'hover');
  	
  	// Usuarios
  	$campanaUsuarios = campanaUsuarioTable::getInstance()->findByIdCampana( $campana->getIdCampana() );

  	$existentes = array();
  	foreach($campanaUsuarios as $campanaUsuario)
  	{
  		$existentes[] = $campanaUsuario->getEmail();
  	}
  	  	
  	$usuarios = $this->getValue('usuarios');	
  	$usuarios = ( isset($usuarios['email']) && $usuarios['email'] )? $usuarios['email'] : array();
  	
  	$sinCambios = array_intersect($existentes, $usuarios);
  	$altas = array_diff($usuarios, $sinCambios);
  	$bajas = array_diff($existentes, $usuarios);
  	
    foreach ($altas as $email)
  	{
  		if ($email)
  		{
	  		$usuario = $campana->getSlug() . '.' . $campana->getIdCampana() . '.' . $email;
	  		$password = campanaUsuarioTable::getInstance()->generateRandomPassword();  		
	  		
	  		$sfGuardUser = new sfGuardUser();
			$sfGuardUser->setFirstName('');
			$sfGuardUser->setLastName('');
			$sfGuardUser->setEmailAddress($email);
			$sfGuardUser->setUsername( $usuario );
			$sfGuardUser->setPassword($password);
			$sfGuardUser->setIsActive(true);
			$sfGuardUser->setIsSuperAdmin(false);
			$sfGuardUser->save();
			
			

			$sfGuardUserPermission = new sfGuardUserPermission();
			$sfGuardUserPermission->setUserId( $sfGuardUser->getId() );
			$sfGuardUserPermission->setPermissionId( sfConfig::get('app_id_permiso_reporte_venta_online') );
			$sfGuardUserPermission->save();
					
			$campanaUsuario = new campanaUsuario();
			$campanaUsuario->setEmail( $email );
			$campanaUsuario->setUsuario( $usuario );
			$campanaUsuario->setIdCampana( $campana->getIdCampana() );
			$campanaUsuario->setIdSfGuardUser( $sfGuardUser->getId() );
			$campanaUsuario->save();
  		}
		
		campanaUsuarioTable::getInstance()->sendMailAccessData($campana, $usuario, $email, $password);
  	}
  	
  	foreach ($bajas as $email)
  	{ 	
  		$campanaUsuario = campanaUsuarioTable::getInstance()->findOneByEmail( $email );
  		$sfGuardUser = sfGuardUserTable::getInstance()->findOneById( $campanaUsuario->getIdSfGuardUser() );
  		
  		$campanaUsuario->delete();
  		$sfGuardUser->delete();  		
  	}
  }  
  

  public function validateEmailOrdenCompra($validator, $value)
  {
      $values = $this->getTaintedValues();
                  
      foreach( $values['marcas'] as $idMarca )
      {
          $cumpleRequired = false;
          if ( $values[$idMarca]['email_orden_compra'] )
          {
              foreach( $values[$idMarca]['email_orden_compra'] as $email )
              {
                  $email = trim($email);
                  
                  if ( $email  && !preg_match(sfValidatorEmail::REGEX_EMAIL, $email) )
                  {
                      throw new sfValidatorError($validator, 'Uno o mas direcciones de email para el envío de orden de compra no tienen un formato válido.');
                  }
                  else if ( $email )
                  {
                      $cumpleRequired = true;
                  }
              }
          }
          
          if ( !$cumpleRequired )
          {
              throw new sfValidatorError($validator, 'Existen marcas para las cuales no se cargó una direccion de email para el envío de orden de compra.');
          }
          
      }
      
      return $value;
  }
  
}