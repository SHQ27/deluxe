<?php

/**
 * producto filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoFormFilter extends BaseproductoFormFilter
{
  public function configure()
  {
        // Widget para Codigo
        $this->setWidget( 'codigo', new sfWidgetFormInputText());
        $this->setValidator( 'codigo', new sfValidatorPass(array('required' => false)));

        // Widget para Genero
        $this->setWidget( 'id_producto_genero', new sfWidgetFormDoctrineChoice(array('model' => 'productoGenero', 'add_empty' => true)));
        $this->setValidator( 'id_producto_genero', new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'productoGenero', 'column' => 'id_producto_genero')));
                      
        // Widget para Categorias
      	$this->setWidget( 'id_producto_categoria', new sfWidgetFormChoice( array( 'choices' => array() ) ) );
      	$this->setValidator( 'id_producto_categoria', new sfValidatorPass() );
      
	  	// Widget para Campañas
	  	$choices = array();
	  	$campanas = campanaTable::getInstance()->listUltimas(30);
	  	$choices[''] = '';
	  	$choices['STKPER'] = 'Stock Permanente';
	  	foreach ($campanas as $campana)
	  	{
	  		$desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
	  		$hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
	  		$choices[$campana->getIdCampana()] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
	  	}
	  	
	  	$this->setWidget( 'campana', new sfWidgetFormChoice( array( 'choices' => $choices, 'multiple' => true ) ) );
	  	$this->getWidget('campana')->setLabel('Stk. Perm. / Campaña');
	  	$this->setValidator('campana', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false, 'multiple' => true ) ));
	  	
	  	// Widget para Marcas
	  	$choices = array();
	  	$marcas = marcaTable::getInstance()->listAll();
	  	$choicesMarcas[''] = 'Todas';
	  	foreach ($marcas as $marca)
	  	{
	  	    $choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
	  	}
	  	$this->setWidget( 'id_marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
                
	  	// Widget para Tags
        $choices = array();
	  	$tags = tagTable::getInstance()->findAll();
        $choicesTags[''] = '';
	  	foreach ($tags as $tag)
	  	{
	  	    $choicesTags[$tag->getIdTag()] = $tag->getDenominacion();
	  	}
	  	$this->setWidget( 'tags', new sfWidgetFormChoice( array( 'choices' => $choicesTags ) ) );
        $this->setValidator( 'tags', new sfValidatorChoice(array('choices' => array_keys($choicesTags), 'required' => false ) ));
        
        // Widget para Stock
        $choicesStock = array(
            "" => "",
            "TIOUTL" => "Tiene en Outlet",
            "NOOUTL" => "No Tiene en Outlet",
            "TICAMP" => "Tiene en Campaña",
            "NOCAMP" => "No Tiene en Campaña",
            "TIPERM" => "Tiene en Permanente",
            "NOPERM" => "No Tiene en Permanente",
            "TIREFU" => "Tiene Refuerzo",
            "NOREFU" => "No Tiene Refuerzo",
            "TIASIG" => "Tiene en donde esta asignado",
            "NOASIG" => "No Tiene en donde esta asignado"
        );
        
        $this->setWidget('stock', new sfWidgetFormChoice(array('choices' => $choicesStock)) );
        $this->setValidator('stock', new sfValidatorChoice(array('required' => false, 'choices' => array_keys($choicesStock))) );
                
        
        // Widget para Tiene Categorias de ML
        $this->setWidget('tiene_categoria_ml', new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))));
        $this->setValidator('tiene_categoria_ml', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))));
        
        // Widget para Esta Publicado en ML
        $this->setWidget('esta_publicado_ml', new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))));
        $this->setValidator('esta_publicado_ml', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))));
        
        // Widget para eShops
        $choices = array();
        $eshops = eshopTable::getInstance()->listAll();
        $choices[''] = 'Todos';
        $choices[ eshop::ESHOP_DELUXE ] = 'Deluxe Buys';
        foreach ($eshops as $eshop)
        {
            $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
        }
        $this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
        $this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );
  }
  
  public function addIdEshopColumnQuery(Doctrine_Query $query, $field, $values) { }
  
  public function buildQuery(array $values)
  {
  	$values = $this->processValues($values);

  	$q = parent::doBuildQuery($values);
  	$rootAlias = $q->getRootAlias();

  	// Select General
    $q->addSelect( $rootAlias . '.*, pgen.*, pcat.*, m.*, pml.*');

    $q->addSelect('ts.denominacion as talle_set_denominacion');
    
    // Select para Es oferta
    $subQ = $q->createSubquery()
              ->select('COUNT(s1_pc.id_campana)')
              ->from('productoCampana s1_pc')
              ->addWhere('s1_pc.id_producto = ' . $rootAlias . '.id_producto');
        
    $q->addSelect('(' . $subQ->getDql() . ') as es_oferta_calculado' );

    // Select para Stock de Permanente
    $subQ = $q ->createSubquery()
               ->select('SUM(s2_pi.stock_permanente)')
               ->from('productoItem s2_pi')
               ->addWhere('s2_pi.id_producto = ' . $rootAlias . '.id_producto');
    
    $q->addSelect('(' . $subQ->getDql() . ') as stock_permanente_calculado' );

    // Select para Stock de Campaña
    $subQ = $q  ->createSubquery()
                ->select('SUM(s3_pi.stock_campana) as stock_campana_calculado')
                ->from('productoItem s3_pi')
                ->addWhere('s3_pi.id_producto = ' . $rootAlias . '.id_producto');
    
    $q->addSelect('(' . $subQ->getDql() . ') as stock_campana_calculado' );

    // Select para Stock de Outlet
    $subQ = $q  ->createSubquery()
                ->select('SUM(s4_pi.stock_outlet) as stock_outlet_calculado')
                ->from('productoItem s4_pi')
                ->addWhere('s4_pi.id_producto = ' . $rootAlias . '.id_producto');
    
    $q->addSelect('(' . $subQ->getDql() . ') as stock_outlet_calculado' );

    // Select para Stock de Refuerzo
    $subQ = $q  ->createSubquery()
                ->select('SUM(s5_pi.stock_refuerzo) as stock_refuerzo_calculado')
                ->from('productoItem s5_pi')
                ->addWhere('s5_pi.id_producto = ' . $rootAlias . '.id_producto');
    
    $q->addSelect('(' . $subQ->getDql() . ') as stock_refuerzo_calculado' );
    
    // Select para Stock
    $subQ = $q  ->createSubquery()
                ->select('SUM(s6_pi.stock) as stock_calculado')
                ->from('productoItem s6_pi')
                ->addWhere('s6_pi.id_producto = ' . $rootAlias . '.id_producto');
    
    $q->addSelect('(' . $subQ->getDql() . ') as stock_calculado' );
    
    // Select para Imagen de Producto
    $subQ = $q  ->createSubquery()
                ->select('s7_pi.id_producto_imagen')
                ->from('productoImagen s7_pi')
                ->addWhere('s7_pi.id_producto = ' . $rootAlias . '.id_producto')
                ->orderBy('s7_pi.orden')
                ->limit(1);
                
    $q->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_calculado' );
    
        
    $q->leftJoin( $rootAlias . '.productoItem pi');
    $q->leftJoin( $rootAlias . '.publicacionMl pml');
    $q->leftJoin( $rootAlias . '.talleSet ts');
    $q->innerJoin( $rootAlias . '.productoCategoria pcat');
    $q->innerJoin( 'pcat.productoGenero pgen');
    $q->innerJoin( $rootAlias . '.marca m');
    
    if ( !isset($_GET['sort']) )
    {
        $q->orderBy('pcat.denominacion ASC, pgen.denominacion ASC, ' . $rootAlias . '.id_producto ASC');
    }

    
    if ( isset($values['codigo']) && $values['codigo'] )
    {

        $q->addWhere( 'pi.codigo like ?', "%" . $values['codigo'] . "%");
    }    
    
    if ( isset($values['id_producto_genero']) && $values['id_producto_genero'] )
    {
        $q->addWhere( 'pcat.id_producto_genero = ?', $values['id_producto_genero']);
    }
    
    if ( isset($values['campana']) && $values['campana'] && $values['campana'][0] )
	{
		$idsCampana = $values['campana'];
		
		$key = array_search('STKPER', $idsCampana);
				
		if ( $key !== false )
		{
		    unset($idsCampana[$key]);
		    $q->leftJoin( $rootAlias . '.productoCampana pc');
		    		    
		    if ( count($idsCampana) )
		    {
		        $q->addWhere( 'pc.id_campana IS NULL OR pc.id_campana in (?)', implode(',', $idsCampana)  );
		    }
		    else
		    {
		        $q->addWhere( 'pc.id_campana IS NULL' );
		    }
		}
		else
		{
		    $q->innerJoin( $rootAlias . '.productoCampana pc');
		    $q->andWhereIn( 'pc.id_campana', $idsCampana );		    
		}
	}
	
    if ( isset($values['tags']) && $values['tags'] )
    {
        $q->leftJoin( $rootAlias . '.productoTag pt');
        $q->addWhere( 'pt.id_tag = ?', $values['tags'] );
    }
    
    if ( isset($values['stock']))
    {
        switch ($values['stock']) {
            case "TIOUTL": //Tiene en Outlet
                $q->addHaving( 'stock_outlet_calculado > 0' );
            break;
            case "NOOUTL": //No Tiene en Outlet
                $q->addHaving( 'stock_outlet_calculado <= 0' );
            break;
            case "TICAMP": //Tiene en Campaña
                $q->addHaving( 'stock_campana_calculado > 0' );
            break;
            case "NOCAMP": //No Tiene en Campaña
                $q->addHaving( 'stock_campana_calculado <= 0 ' );
            break;
            case "TIPERM": //Tiene en Permanente
                $q->addHaving( 'stock_permanente_calculado > 0' );
            break;
            case "NOPERM": //No Tiene en Permanente
                $q->addHaving( 'stock_permanente_calculado <= 0' );
            break;
            case "TIREFU": //Tiene Refuerzo
                $q->addHaving( 'stock_refuerzo_calculado > 0' );
            break;
            case "NOREFU": //No Tiene Refuerzo
                $q->addHaving( 'stock_refuerzo_calculado <= 0' );
            break;
            case "TIASIG": //Tiene en donde esta asignado
                $q->addHaving( 'stock_calculado > 0' );
            break;
            case "NOASIG": //No Tiene en donde esta asignado
                $q->addHaving( 'stock_calculado <= 0' );
            break;
        }
    }
    
    if ( isset($values['tiene_categoria_ml']) )
    {
        if ( $values['tiene_categoria_ml'] )
        {
            $q->addWhere( $rootAlias . '.id_categoria_ml IS NOT NULL' );
        }
        else
        {
            $q->addWhere( $rootAlias . '.id_categoria_ml IS NULL' );
        }
    }
    
    if ( isset($values['esta_publicado_ml']) )
    {
        if ( $values['esta_publicado_ml'] )
        {
            $q->addWhere( 'pml.fecha_inicio IS NOT NULL');
            $q->addWhere( 'pml.fecha_fin IS NOT NULL');
            $q->addWhere( '(pml.fecha_inicio <= now() AND now() <= pml.fecha_fin )');
        }
        else
        {
            $q->addWhere( '(pml.fecha_inicio IS NULL OR pml.fecha_fin IS NULL OR pml.fecha_inicio > now() OR now() > pml.fecha_fin)' );
        }
    }
    
    if ( isset($values['id_eshop']) && $values['id_eshop'] )
    {
        if ( $values['id_eshop'] == eshop::ESHOP_DELUXE )
        {
            $q->addWhere( $rootAlias . '.id_eshop IS NULL');
        }
        else
        {
            $q->addWhere( $rootAlias . '.id_eshop = ?', $values['id_eshop']);
        }
    }
    
    
    
    
    return $q;
  }  
}