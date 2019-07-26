<?php

/**
 * publicacionMl filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class publicacionMlFormFilter extends BasepublicacionMlFormFilter
{
  public function configure()
  {
      // Widget para Codigo
      $this->setWidget( 'codigo', new sfWidgetFormInput());
      $this->setValidator( 'codigo', new sfValidatorString(array('required' => false)));
      
      // Widget para Denominacion
      $this->setWidget( 'denominacion', new sfWidgetFormInput());
      $this->setValidator( 'denominacion', new sfValidatorString(array('required' => false)));
      
      // Widget para Genero
      $this->setWidget( 'id_producto_genero', new sfWidgetFormDoctrineChoice(array('model' => 'productoGenero', 'add_empty' => true)));
      $this->setValidator( 'id_producto_genero', new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'productoGenero', 'column' => 'id_producto_genero')));
      
      // Widget para Categorias
      $this->setWidget( 'id_producto_categoria', new sfWidgetFormDoctrineChoice(array('model' => 'productoCategoria', 'table_method' => 'listAll', 'add_empty' => true)));
      $this->setValidator( 'id_producto_categoria', new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'productoCategoria', 'column' => 'id_producto_categoria')));
       
      // Widget para Marcas
      $choices = array();
      $marcas = marcaTable::getInstance()->listAll();
      $choicesMarcas[''] = 'Todas';
      foreach ($marcas as $marca)
      {
          $choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
      }
      $this->setWidget( 'id_marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
      $this->setValidator( 'id_marca', new sfValidatorChoice( array( 'required' => false, 'choices' => array_keys($choicesMarcas) ) ) );
      
      // Widgets para Fechas      
  	  $this->setWidget('fecha_inicio',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false)));
  	  $this->setWidget('fecha_fin',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false)));
  	
      // Widget para vigente
  	  $this->setWidget('vigente', new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))));
  	  $this->setValidator('vigente', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))));
  	  
      // Filtro de intervencion manual
      $countIntervencionManual = publicacionMlTable::getInstance()->countActivasErroneamenteEnML();
      $this->setWidget('intervencionManual', new sfWidgetFormInputCheckbox( ) );
      $requierePlural = ($countIntervencionManual > 1)? 'n' : '';
      $this->getWidget('intervencionManual')->setLabel("<img src='/backend/images/warning.png' /> Hay $countIntervencionManual publ. que requiere$requierePlural intervención manual");
      $this->setValidator( 'intervencionManual', new sfValidatorBoolean( array('required' => false) ) );
  	  
  	  // Widget para status ml
  	  $choices = array();
  	  $choices[ '' ] = 'Todos';
  	  $choices[ publicacionMl::STATUS_ACTIVE ] = publicacionMl::STATUS_ACTIVE;
  	  $choices[ publicacionMl::STATUS_CLOSED ] = publicacionMl::STATUS_CLOSED;
  	  $choices[ publicacionMl::STATUS_PAUSED ] = publicacionMl::STATUS_PAUSED;
  	  $this->setWidget('status_ml', new sfWidgetFormChoice(array('choices' => $choices)));
  	  $this->setValidator( 'status_ml', new sfValidatorString(array('required' => false)));
  }
  
  public function buildQuery(array $values)
  {
      $values = $this->processValues($values);
      
      $q = parent::doBuildQuery($values);
      $rootAlias = $q->getRootAlias();
      $q->innerJoin( $rootAlias . '.producto p');
      $q->innerJoin( 'p.productoCategoria pcat');
  
      $q->addWhere( $rootAlias . '.item_id IS NOT NULL');
      
      if ( isset($values['codigo']) && $values['codigo'] )
      {
          $q->addWhere( 'p.codigo LIKE ?', "%" . $values['codigo'] . "%");
      }
      
      if ( isset($values['denominacion']) && $values['denominacion'] )
      {
          $q->addWhere( 'p.denominacion LIKE ?', "%" . $values['denominacion'] . "%");
      }
      
      if ( isset($values['id_producto_genero']) && $values['id_producto_genero'] )
      {
          $q->addWhere( 'pcat.id_producto_genero = ?', $values['id_producto_genero']);
      }

      if ( isset($values['id_producto_categoria']) && $values['id_producto_categoria'] )
      {
          $q->addWhere( 'pcat.id_producto_categoria = ?', $values['id_producto_categoria']);
      }
      
      if ( isset($values['status_ml']) && $values['status_ml'] )
      {
          $q->addWhere( $rootAlias . '.status_ml = ?', $values['status_ml']);
      }      
      
      if ( isset($values['id_marca']) && $values['id_marca'] )
      {
          $q->addWhere( 'p.id_marca = ?', $values['id_marca']);
      }

      if ( isset( $values['vigente'] ) )
      {
          if ( $values['vigente'] === '1' ) {
              $q->addWhere( '(' . $rootAlias . '.fecha_inicio <= NOW() AND NOW() <= ' . $rootAlias . '.fecha_fin)');
          }
      
          if ( $values['vigente'] === '0' ) {
              $q->addWhere( '(' . $rootAlias . '.fecha_inicio IS NULL OR ' . $rootAlias . '.fecha_fin IS NULL OR ( ' . $rootAlias . '.fecha_inicio > NOW() OR ' . $rootAlias . '.fecha_fin < NOW() ) )');
          }
      }
      
      // Filtro de IntervencionManual
      if ( isset($values['intervencionManual']) && $values['intervencionManual'] )
      {
          $q->addWhere($rootAlias . '.status_ml IS NOT NULL');
          $q->addWhere('(' . $rootAlias . '.status_ml <> ?)', publicacionMl::STATUS_CLOSED);
          $q->addWhere('(' . $rootAlias . '.fecha_inicio IS NULL OR ' . $rootAlias . '.fecha_fin IS NULL OR ( ' . $rootAlias . '.fecha_inicio > NOW() OR ' . $rootAlias . '.fecha_fin < NOW() ) )');
      }
  
      return $q;
  }
  
}