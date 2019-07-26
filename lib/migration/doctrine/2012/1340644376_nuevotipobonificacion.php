<?php

class Nuevotipobonificacion extends Doctrine_Migration_Base
{
  public function up()
  {
  	$tipoBonificacion = new tipoBonificacion();
  	$tipoBonificacion->setIdTipoBonificacion('SUSCR');
  	$tipoBonificacion->setDenominacion('Suscripción');
  	$tipoBonificacion->save();
  }

  public function down()
  {
  }
}
