<?php

/**
 * descuento form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class descuentoForm extends BasedescuentoForm
{
  public function configure()
  {
  	$descuento = $this->getObject();

  	$choicesTipoRestriccion = array('INC' => 'El pedido debe contenter solo productos que respeten la siguiente selección', 'EXC' => 'El pedido NO debe contener ningun producto de la siguiente selección'); 
  	
  	$this->setWidget('vigencia_desde', new pmWidgetFormDateTime() );
  	$this->setWidget('vigencia_hasta', new pmWidgetFormDateTime() );
  	$this->setWidget('utilizados', new sfWidgetFormInputHidden() );
   	
	// Restriccion de Productos								
	$this->setWidget( "asignacion", new pmWidgetProductAssign
											( array
												(
													'formName' => $this->getName(),
													'marcas' => marcaTable::getInstance()->listAll(),
													'filtrosActivos' => array('marca', 'eshop', 'activo')
												)
											));
	
										
	$this->setValidator( "asignacion", new sfValidatorPass());
  	
	$productosAsignados = productoTable::getInstance()->listByIdDescuento( $descuento->getIdDescuento() );  	
	$this->getWidget("asignacion")->setDefault($productosAsignados);


    $this->setWidget("tipo_restriccion_producto", new sfWidgetFormChoice( array( 'choices' => $choicesTipoRestriccion ) ) );
    $this->setValidator( "tipo_restriccion_producto", new sfValidatorPass());
    
    if ( $descuento->getIdDescuento() ) {
    	$esRestriccionExcluyente = descuentoRestriccionTable::getInstance()->esRestriccionExcluyente($descuento->getIdDescuento(), descuentoRestriccion::PRODUCTOS);
    	$this->setDefault("tipo_restriccion_producto", $esRestriccionExcluyente ? 'EXC' : 'INC' );
    }

	
	// Restriccion de Compra Minima
	$this->setWidget('compra_minima', new sfWidgetFormInputText() );
	$this->setValidator('compra_minima', new sfValidatorInteger(array('required' => false)) );
	$restriccionCompraMinima = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::COMPRA_MINIMA);
	if ( $restriccionCompraMinima ) $this->getWidget("compra_minima")->setDefault( $restriccionCompraMinima->getValor() );
	
	// Restriccion de Montos
	$this->setWidget('monto_minimo', new sfWidgetFormInputText() );
	$this->setValidator('monto_minimo', new sfValidatorInteger(array('required' => false)) );
	$restriccionMontoMinimo = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::MONTO_MINIMO);
	if ( $restriccionMontoMinimo ) $this->getWidget("monto_minimo")->setDefault( $restriccionMontoMinimo->getValor() );
	
	$this->setWidget('monto_maximo', new sfWidgetFormInputText() );
	$this->setValidator('monto_maximo', new sfValidatorInteger(array('required' => false)) );
	$restriccionMontoMaximo = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::MONTO_MAXIMO);
	if ( $restriccionMontoMaximo ) $this->getWidget("monto_maximo")->setDefault( $restriccionMontoMaximo->getValor() );
	
	
	// Restriccion de categoria
	$choices = array();
	$categorias = productoCategoriaTable::getInstance()->listAll();
	foreach ($categorias as $categoria)
	{
	    $nombreCategoriaGenero = $categoria->getProductoGenero()->getDenominacion();
	    $idProductoCategoria = $categoria->getIdProductoCategoria();
	    $choices[$idProductoCategoria] = $nombreCategoriaGenero . ' / ' . $categoria->getDenominacion();
	    asort($choices);
	}
		
	$this->setWidget( "categoria", new sfWidgetFormSelectDoubleList( array('choices' => $choices, 'label_unassociated' => 'No Asociadas', 'label_associated' => 'Asociadas') ) );
	$this->setValidator( "categoria", new sfValidatorChoice( array('choices' => array_keys($choices), 'multiple' => true, 'required' => false ) ) );
	
	$default = array();
	$restriccionesCategoria = descuentoRestriccionTable::getInstance()->listByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::CATEGORIA);
	foreach ($restriccionesCategoria as $restriccion) $default[] = $restriccion->getValor();
	$this->getWidget("categoria")->setDefault( $default );

    $this->setWidget("tipo_restriccion_categoria", new sfWidgetFormChoice( array( 'choices' => $choicesTipoRestriccion ) ) );
    $this->setValidator( "tipo_restriccion_categoria", new sfValidatorPass());

    if ( $descuento->getIdDescuento() ) {
    	$esRestriccionExcluyente = descuentoRestriccionTable::getInstance()->esRestriccionExcluyente($descuento->getIdDescuento(), descuentoRestriccion::CATEGORIA);
    	$this->setDefault("tipo_restriccion_categoria", $esRestriccionExcluyente ? 'EXC' : 'INC' );
    }
	
	// Restriccion de outlet
	$this->setWidget('solo_outlet', new sfWidgetFormInputCheckbox() );
	$this->setValidator('solo_outlet', new sfValidatorBoolean(array('required' => false)) );
	$restriccionSoloOutlet = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::SOLO_OUTLET);
	if ( $restriccionSoloOutlet ) $this->getWidget("solo_outlet")->setDefault( true );
	
	// Restriccion de Marca
	$this->setWidget('marca', new sfWidgetFormDoctrineChoice( array('model' => 'marca', 'order_by' => array('nombre', 'asc'), 'add_empty' => true) ) );
	$this->setValidator('marca', new sfValidatorDoctrineChoice( array('model' => 'marca', 'required' => false) ) );
	$restriccionMarca = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::MARCA);
	if ( $restriccionMarca ) $this->getWidget("marca")->setDefault( $restriccionMarca->getValor() );

    $this->setWidget("tipo_restriccion_marca", new sfWidgetFormChoice( array( 'choices' => $choicesTipoRestriccion ) ) );
    $this->setValidator( "tipo_restriccion_marca", new sfValidatorPass());

    if ( $descuento->getIdDescuento() ) {
    	$esRestriccionExcluyente = descuentoRestriccionTable::getInstance()->esRestriccionExcluyente($descuento->getIdDescuento(), descuentoRestriccion::MARCA);
    	$this->setDefault("tipo_restriccion_marca", $esRestriccionExcluyente ? 'EXC' : 'INC' );
    }
	

	// Restriccion de Campaña
	$choices = array();
	$campanas = campanaTable::getInstance()->listAll();
	foreach ($campanas as $campana)
	{
  		$desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
  		$hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
  		$choices[$campana->getIdCampana()] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
	}
	
	$this->setWidget( "campana", new sfWidgetFormSelectDoubleList( array('choices' => $choices, 'label_unassociated' => 'No Asociadas', 'label_associated' => 'Asociadas') ) );
	$this->setValidator( "campana", new sfValidatorChoice( array('choices' => array_keys($choices), 'multiple' => true, 'required' => false ) ) );

	$default = array();
	$restriccionesCampana = descuentoRestriccionTable::getInstance()->listByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::CAMPANA);
	foreach ($restriccionesCampana as $restriccion) $default[] = $restriccion->getValor();
	$this->getWidget("campana")->setDefault( $default );

    $this->setWidget("tipo_restriccion_campana", new sfWidgetFormChoice( array( 'choices' => $choicesTipoRestriccion ) ) );
    $this->setValidator( "tipo_restriccion_campana", new sfValidatorPass());

    if ( $descuento->getIdDescuento() ) {
    	$esRestriccionExcluyente = descuentoRestriccionTable::getInstance()->esRestriccionExcluyente($descuento->getIdDescuento(), descuentoRestriccion::CAMPANA);
    	$this->setDefault("tipo_restriccion_campana", $esRestriccionExcluyente ? 'EXC' : 'INC' );
    }
	
	// Restriccion de Familia de color
	$this->setWidget('familia_color', new sfWidgetFormDoctrineChoice( array('model' => 'familiaColor', 'order_by' => array('denominacion', 'asc'), 'add_empty' => true) ) );
	$this->setValidator('familia_color', new sfValidatorDoctrineChoice( array('model' => 'familiaColor', 'required' => false ) ) );
	$restriccionFamiliaColor = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::FAMILIA_COLOR);
	if ( $restriccionFamiliaColor ) $this->getWidget("familia_color")->setDefault( $restriccionFamiliaColor->getValor() );

    $this->setWidget("tipo_restriccion_familia_color", new sfWidgetFormChoice( array( 'choices' => $choicesTipoRestriccion ) ) );
    $this->setValidator( "tipo_restriccion_familia_color", new sfValidatorPass());

    if ( $descuento->getIdDescuento() ) {
    	$esRestriccionExcluyente = descuentoRestriccionTable::getInstance()->esRestriccionExcluyente($descuento->getIdDescuento(), descuentoRestriccion::FAMILIA_COLOR);
    	$this->setDefault("tipo_restriccion_familia_color", $esRestriccionExcluyente ? 'EXC' : 'INC' );
    }
	
	// Restriccion de tag
	$this->setWidget('tag', new sfWidgetFormInput() );
	$this->setValidator('tag', new sfValidatorString( array( 'required' => false  ) ) );
	$restriccionTag = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::TAG);
	if ( $restriccionTag )
	{
	    $tag = tagTable::getInstance()->findOneByIdTag( $restriccionTag->getValor() );
	    $this->getWidget("tag")->setDefault( $tag->getDenominacion() );
	}

    $this->setWidget("tipo_restriccion_tag", new sfWidgetFormChoice( array( 'choices' => $choicesTipoRestriccion ) ) );
    $this->setValidator( "tipo_restriccion_tag", new sfValidatorPass());

    if ( $descuento->getIdDescuento() ) {
    	$esRestriccionExcluyente = descuentoRestriccionTable::getInstance()->esRestriccionExcluyente($descuento->getIdDescuento(), descuentoRestriccion::TAG);
    	$this->setDefault("tipo_restriccion_tag", $esRestriccionExcluyente ? 'EXC' : 'INC' );
    }
	
	// Widget para eShops
	$choices = array();
	$eshops = eshopTable::getInstance()->listAll();
	$choices[''] = 'Deluxe Buys';
	foreach ($eshops as $eshop)
	{
	    $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
	}
	$this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	$this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );
	
  }
  
  protected function doSave($con = null)
  {  	      
	$descuento = $this->getObject();	
	$this->updateObject();
	$descuento->save($con);

	
	// Compra Minima
	$idTipoDescuento = $this->getValue('id_tipo_descuento');
	
	if ( $idTipoDescuento == tipoDescuento::COMPRA_MINIMA )
	{	    
	    $restriccionCompraMinima = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::COMPRA_MINIMA);
	    	    
	    if ( !$restriccionCompraMinima )
	    {	        
	        $restriccionCompraMinima = new descuentoRestriccion();
	        $restriccionCompraMinima->setIdDescuento( $descuento->getIdDescuento() );
	        $restriccionCompraMinima->setTipo( descuentoRestriccion::COMPRA_MINIMA );
	    }
	    
	    $compraMinima = $this->getValue('compra_minima');
	    $restriccionCompraMinima->setValor( $compraMinima );
	    $restriccionCompraMinima->save();
	}
	else
	{
	    descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::COMPRA_MINIMA);
	}
	
	// Solo Outlet
	$soloOutlet = $this->getValue('solo_outlet');
	if ( $soloOutlet )
	{
	    $restriccionSoloOutlet = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::SOLO_OUTLET);
	    
	    if ( !$restriccionSoloOutlet )
	    {
	        $restriccionMontoMinimo = new descuentoRestriccion();
	        $restriccionMontoMinimo->setIdDescuento( $descuento->getIdDescuento() );
	        $restriccionMontoMinimo->setTipo( descuentoRestriccion::SOLO_OUTLET );
	        $restriccionMontoMinimo->save();
	    }
	}
	else
	{
	    descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::SOLO_OUTLET);
	}
	
	// Monto Minimo
	$montoMinimo = $this->getValue('monto_minimo');
	if ( !is_null($montoMinimo) && $montoMinimo )
	{
	    $restriccionMontoMinimo = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::MONTO_MINIMO);
	    
	    if ( !$restriccionMontoMinimo )
	    {
	        $restriccionMontoMinimo = new descuentoRestriccion();
	        $restriccionMontoMinimo->setIdDescuento( $descuento->getIdDescuento() );
	        $restriccionMontoMinimo->setTipo( descuentoRestriccion::MONTO_MINIMO );
	    }
	        
	    $restriccionMontoMinimo->setValor( $montoMinimo );
	    $restriccionMontoMinimo->save();
	}
	else
	{
	    descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::MONTO_MINIMO);
	}
	
	// Monto Maximo
	$montoMaximo = $this->getValue('monto_maximo');	
	if ( !is_null($montoMaximo) && $montoMaximo )
	{
	    $restriccionMontoMaximo = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::MONTO_MAXIMO);
	    
	    if ( !$restriccionMontoMaximo )
	    {
	        $restriccionMontoMaximo = new descuentoRestriccion();
	        $restriccionMontoMaximo->setIdDescuento( $descuento->getIdDescuento() );
	        $restriccionMontoMaximo->setTipo( descuentoRestriccion::MONTO_MAXIMO );
	    }
	    
	    $restriccionMontoMaximo->setValor( $montoMaximo );
	    $restriccionMontoMaximo->save();	    
	} 
	else
	{
	    descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::MONTO_MAXIMO);
	}
	
	// Productos
  	$excluirProducto = $this->getValue('tipo_restriccion_producto') === 'EXC';
  	$productos = $this->getValue('asignacion');
  	$productos = ( $productos  ) ? explode(',', $productos) : array();
	
	descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::PRODUCTOS);
  
  	foreach ($productos as $idProducto)
  	{
	  	$descuentoRestriccion = new descuentoRestriccion();
	  	$descuentoRestriccion->setIdDescuento($descuento->getIdDescuento());
	  	$descuentoRestriccion->setTipo(descuentoRestriccion::PRODUCTOS);
	  	$descuentoRestriccion->setValor($idProducto);
	  	$descuentoRestriccion->setExcluir( $excluirProducto );
	  	$descuentoRestriccion->save();		  	
  	}
  	
  	// Categorias  	
  	$excluirCategoria = $this->getValue('tipo_restriccion_categoria') === 'EXC';
  	$categorias = $this->getValue('categoria');
  	$categorias = ($categorias)? $categorias : array();
	
	descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::CATEGORIA);

  	foreach ($categorias as $idCategoria)
  	{
  	    $descuentoRestriccion = new descuentoRestriccion();
  	    $descuentoRestriccion->setIdDescuento($descuento->getIdDescuento());
  	    $descuentoRestriccion->setTipo(descuentoRestriccion::CATEGORIA);
  	    $descuentoRestriccion->setValor($idCategoria);
  	    $descuentoRestriccion->setExcluir( $excluirCategoria );
  	    $descuentoRestriccion->save();
  	}
  	
    // Marca
    $excluirMarca = $this->getValue('tipo_restriccion_marca') === 'EXC';
  	$idMarca = $this->getValue('marca');
  	
  	if ( $idMarca )
  	{
  	    $restriccionMarca = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::MARCA);
  	
  	    if ( !$restriccionMarca )
  	    {
  	        $restriccionMarca = new descuentoRestriccion();
  	        $restriccionMarca->setIdDescuento( $descuento->getIdDescuento() );
  	        $restriccionMarca->setTipo( descuentoRestriccion::MARCA );
  	    }
  	
  	    $restriccionMarca->setValor( $idMarca );
  	    $restriccionMarca->setExcluir( $excluirMarca );
  	    $restriccionMarca->save();
  	}
  	else
  	{
  	    descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::MARCA);
  	}
  	
  	// Campaña
  	$excluirCampana = $this->getValue('tipo_restriccion_campana') === 'EXC';  	
  	$campanas = $this->getValue('campana');
  	$campanas = ($campanas)? $campanas : array();
  	
  	descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::CAMPANA);

  	foreach ($campanas as $idCampana)
  	{
  	    $descuentoRestriccion = new descuentoRestriccion();
  	    $descuentoRestriccion->setIdDescuento($descuento->getIdDescuento());
  	    $descuentoRestriccion->setTipo(descuentoRestriccion::CAMPANA);
  	    $descuentoRestriccion->setValor($idCampana);
  	    $descuentoRestriccion->setExcluir( $excluirCampana );
  	    $descuentoRestriccion->save();
  	}
  	  	
	// Tag
	$excluirTag = $this->getValue('tipo_restriccion_tag') === 'EXC';  	
  	$tag = $this->getValue('tag');

  	if ( $tag )
  	{
  	    $restriccionTag = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::TAG);
  	    $tag = tagTable::getInstance()->getTag($tag);
  	
  	    if ( !$restriccionTag )
  	    {
  	        $restriccionTag = new descuentoRestriccion();
  	        $restriccionTag->setIdDescuento( $descuento->getIdDescuento() );
  	        $restriccionTag->setTipo( descuentoRestriccion::TAG );
  	    }
  	
  	    $restriccionTag->setValor( $tag->getIdTag() );
  	    $restriccionTag->setExcluir( $excluirTag );
  	    $restriccionTag->save();
  	}
  	else
  	{
  	    descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::TAG);
  	}
  	
  	// Familia Color
  	$excluirFamiliaColor = $this->getValue('tipo_restriccion_familia_color') === 'EXC';  	
  	$idFamiliaColor = $this->getValue('familia_color');

  	if ( $idFamiliaColor )
  	{
  	    $restriccionFamiliaColor = descuentoRestriccionTable::getInstance()->getOne($descuento->getIdDescuento(), descuentoRestriccion::FAMILIA_COLOR);
  	
  	    if ( !$restriccionFamiliaColor )
  	    {
  	        $restriccionFamiliaColor = new descuentoRestriccion();
  	        $restriccionFamiliaColor->setIdDescuento( $descuento->getIdDescuento() );
  	        $restriccionFamiliaColor->setTipo( descuentoRestriccion::FAMILIA_COLOR );
  	    }
  	
  	    $restriccionFamiliaColor->setValor( $idFamiliaColor );
  	    $restriccionFamiliaColor->setExcluir( $excluirFamiliaColor );
  	    $restriccionFamiliaColor->save();
  	}
  	else
  	{
  	    descuentoRestriccionTable::getInstance()->deleteByCompoundKey($descuento->getIdDescuento(), descuentoRestriccion::FAMILIA_COLOR);
  	}
  	
  }
  
  
}
  	