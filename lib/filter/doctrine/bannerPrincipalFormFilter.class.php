<?php

/**
 * bannerPrincipal filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannerPrincipalFormFilter extends BasebannerPrincipalFormFilter
{
  public function configure()
  {
      $this->setWidget('fecha_desde',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate())));
      $this->setWidget('fecha_hasta',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate())));
  }
}
