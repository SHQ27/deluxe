<?php

/**
 * faltante filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faltanteFormFilter extends BasefaltanteFormFilter
{
  public function configure()
  {      
      $this->setWidget('fecha_aviso',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false)));
      
      // Widget para id pedido
      $this->setWidget('id_pedido',  new sfWidgetFormInputText());
      $this->setValidator('id_pedido', new sfValidatorPass(array('required' => false)));
      
      // Widget para id faltante
      $this->setWidget('id_faltante',  new sfWidgetFormInputText());
      $this->setValidator('id_faltante', new sfValidatorPass(array('required' => false)));
      
      // Widget para Marcas
      $choices = array();
      $marcas = marcaTable::getInstance()->listAll();
      $choicesMarcas[''] = 'Todas';
      foreach ($marcas as $marca)
      { 
      	$choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
      }
      $this->setWidget( 'marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );    
      $this->setValidator('marca', new sfValidatorChoice( array( 'choices' => array_keys($choicesMarcas), 'required' => false ) ) );
      
      // Widget para Campañas
      $choices = array();
      $campanas = campanaTable::getInstance()->listAll();
      $choicesCampanas[''] = 'Todas';
      foreach ($campanas as $campana)
      {
     	$desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
     	$hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
    	$choicesCampanas[$campana->getIdCampana()] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
      }
      $this->setWidget( 'campana', new sfWidgetFormChoice( array( 'choices' => $choicesCampanas ) ) );
      $this->setValidator('campana', new sfValidatorString(array('required' => false)));
      
      // Widget para buscador
      $this->setWidget( 'buscador', new sfWidgetFormInput() );
      $this->setValidator('buscador', new sfValidatorString(array('required' => false)));
      
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
      
      unset($this['id_producto_item'], $this['cantidad']);
  }
  
  public function addIdEshopColumnQuery(Doctrine_Query $query, $field, $values) { }
  
  public function buildQuery(array $values)
  {      
      $values = $this->processValues($values);
  
      $q = parent::doBuildQuery($values);
      $rootAlias = $q->getRootAlias();
      $q->select( $rootAlias . '.*, p.*, u.*, pi.*, pt.*, pc.*, pr.*, m.*' );
      $q->addSelect( 'ppi.id_pedido_producto_item' );
      $q->addSelect( 'ppic.id_campana' );
      $q->addSelect( 'c.denominacion as campana' );
      $q->innerJoin( $rootAlias . '.pedido p' );
      $q->innerJoin( 'p.pedidoProductoItem ppi' );
      $q->leftJoin( 'ppi.pedidoProductoItemCampana ppic' );
      $q->leftJoin( 'ppic.campana c' );
      $q->innerJoin( 'p.usuario u' );
      $q->innerJoin( $rootAlias . '.productoItem pi' );
      $q->innerJoin( 'pi.productoTalle pt' );
      $q->innerJoin( 'pi.productoColor pc' );
      $q->innerJoin( 'pi.producto pr' );
      $q->innerJoin( 'pr.marca m' );
      $q->addWhere( 'ppi.id_producto_item = pi.id_producto_item' );
      
      $q->orderBy( $rootAlias . '.id_pedido DESC');

      // Filtro de Id Faltante
      if ( isset($values['id_faltante']) && $values['id_faltante'] )
      {
          $q->addWhere( $rootAlias . '.id_faltante = ?', $values['id_faltante'] );
      }      
      
        // Filtro de Buscador
      if ( isset($values['buscador']) && $values['buscador'] )
      {
          $txt = $values['buscador'];
    
          $subFilters = array();
          $subFilters[] = array( 'field' => 'p.nombre', 'operator' => 'LIKE');
          $subFilters[] = array( 'field' => 'p.apellido', 'operator' => 'LIKE');
          $subFilters[] = array( 'field' => 'p.email', 'operator' => 'LIKE');
          $wheres = array();
          foreach ($subFilters as $subFilter)
          {
  
              $wheres[] = $subFilter['field'] . ' ' . $subFilter['operator'] . ' ?';
          }
  
          $q->addWhere( implode(' OR ', $wheres), array("%$txt%", "%$txt%", "%$txt%") );
      }
      
      // Filtro de Marca
      if ( isset($values['marca']) && $values['marca'] )
      {
          $q->addWhere( 'm.id_marca = ?', $values['marca'] );
      }
      
      // Filtro de Campana
      if ( isset($values['campana']) && $values['campana'] )
      {
          $q->addWhere( 'ppic.id_campana = ?', $values['campana'] );
      }
      
      // Filtro de eShop      
      if ( isset($values['id_eshop']) && $values['id_eshop'] )
      {
          if ( $values['id_eshop'] == eshop::ESHOP_DELUXE )
          {
              $q->addWhere( 'p.id_eshop IS NULL');
          }
          else
          {
              $q->addWhere( 'p.id_eshop = ?', $values['id_eshop']);
          }
      }
  
      return $q;
  }
  
  
  
}
