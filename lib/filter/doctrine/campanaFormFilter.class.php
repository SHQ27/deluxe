<?php

/**
 * campana filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class campanaFormFilter extends BasecampanaFormFilter
{
  public function configure()
  {
  	$esLogistica = stripos($_SERVER['REQUEST_URI'], 'logistica') !== false;

  	// Widget para Fechas
  	$this->setWidget('fecha_inicio',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate())));
  	$this->setWidget('fecha_fin',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate())));
  	
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
    
    // Widget para Despachada
    $this->setWidget( 'despachada', new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))));
    $this->setValidator('despachada', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))));
    
    // Widget para Pagada
    $this->setWidget( 'pagada', new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))));
    $this->setValidator('pagada', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))));

    // Widget de Estado
    $choicesEstados = array(
		'INDISTINTO' => 'Indistinto',
		'NOINICIADA' => 'No Iniciada',
		'ENCURSO' 	 => 'En Curso',
		'FINALIZADA' => 'Finalizada'
	);

	if ( $esLogistica ) {
		unset($choicesEstados['NOINICIADA']);
	}
	
    $this->setWidget( 'estado', new sfWidgetFormChoice(array('choices' => $choicesEstados)));
    $this->setValidator('estado', new sfValidatorChoice(array('required' => false, 'choices' => array_keys($choicesEstados))));
  }
  
  public function buildQuery(array $values)
  {
  	$esLogistica = stripos($_SERVER['REQUEST_URI'], 'logistica') !== false;

  	$values = $this->processValues($values);

  	$q = parent::doBuildQuery($values);
    $rootAlias = $q->getRootAlias();
    $q->select( $rootAlias . '.*');
    $q->innerJoin( $rootAlias . '.campanaMarca cm' );
  	
  	if ( $esLogistica )
	{
	    $q->addWhere('cm.email_orden_compra IS NOT NULL');
	    $q->addWhere( $rootAlias . '.fecha_inicio <= now()' );	
	}

  	// Filtro de Marca
    if ( isset($values['marca']) && $values['marca'] )
	{
		$q->addWhere('cm.id_marca = ?', $values['marca']);
	}

	// Filtro de estado de campaña
	if ( isset($values['estado']) ) {

		if ( !$esLogistica && $values['estado'] == 'NOINICIADA' ) {
			$q->addWhere( $rootAlias . '.fecha_inicio >= now()' );	
		}

		if ($values['estado'] == 'ENCURSO' ) {
			$q->addWhere( '(' . $rootAlias . '.fecha_inicio <= now() AND now() <=' . $rootAlias . '.fecha_fin )' );	
		}

		if ($values['estado'] == 'FINALIZADA' ) {
			$q->addWhere( $rootAlias . '.fecha_fin <= now()' );	
		}
	}

	
	// Filtro de campaña despachada
	if ( isset($values['despachada']) )
	{		    
	    $idsCampanasDespachadas = campanaTable::getInstance()->getIdsCampanasDespachadas();
	    
	    if ( $values['despachada'] )
	    {
	        $q->andWhereIn($rootAlias . '.id_campana', $idsCampanasDespachadas);
	    }
	    else
	    {
	        $q->andWhereNotIn($rootAlias . '.id_campana', $idsCampanasDespachadas);
	    }
	}
	
	// Filtro de campaña pagada
	if ( isset($values['pagada']) )
	{
	    if ( $values['pagada'] )
	    {
	        $q->addWhere('cm.pagada = true');
	    }
	    else
	    {
	        $q->addWhere('cm.pagada = false');
	    }
	}
	
	
    return $q;
	
  }
  
}
