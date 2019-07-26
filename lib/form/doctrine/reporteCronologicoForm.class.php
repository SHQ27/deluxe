<?php

/**
 * reporteCronologico form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporteCronologicoForm extends sfFormSymfony
{
  	public function configure()
  	{  		
  	    // Periodo
	    $this->setWidget('periodo', new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false, 'template' => '<div class="selectPeriodo">from %from_date%<br/>to %to_date%</div>')));
	    $this->setValidator( 'periodo', new sfValidatorDateTime(array('required' => true)) );
	    
	    // eShop
	    $choices = array();
	    $eshops = eshopTable::getInstance()->listAll();
	    $choices[''] = 'Deluxe Buys';
	    foreach ($eshops as $eshop)
	    {
	        $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
	    }
	    $this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	    $this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );
	    $this->getWidget( 'id_eshop' )->setLabel('eShop');
	    
	    $this->getWidgetSchema()->setNameFormat('reporteCronologicoForm[%s]');
	    
  	}

	public function process()
	{
	    set_time_limit(0);
	    
	    $idEshop = $this->getValue('id_eshop');
	    
		$values = $this->getTaintedValues();
		if ( !$values['periodo']['from']['year'] || !$values['periodo']['to']['year'] ) return false;
		
		$periodo = array();
		$periodo['from'] = $values['periodo']['from']['year'] . '-' . sprintf('%02d', $values['periodo']['from']['month']) . '-' . sprintf('%02d', $values['periodo']['from']['day']);
		$periodo['to'] = $values['periodo']['to']['year'] . '-' . sprintf('%02d', $values['periodo']['to']['month']) . '-' . sprintf('%02d', $values['periodo']['to']['day']);

		$client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
		$idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
		
		$task = new Net_Gearman_Task ('ReporteCronologicoWorker', array ('periodo' => $periodo, 'idEshop' => $idEshop, 'idUsuario' => $idUsuario) );
		$task->type = Net_Gearman_Task::JOB_BACKGROUND;
		
		$set = new Net_Gearman_Set();
		$set->addTask ($task);
		
		$client->runSet ($set);
	}
}