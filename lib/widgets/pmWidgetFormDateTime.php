<?php

class pmWidgetFormDateTime extends sfWidgetFormJQueryDate
{

  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options,$attributes);
    
    $this->addOption('time', ( isset( $options['time'] ) ) ? $options['time'] : array() );
    $this->setOption('culture', 'es');
    $this->setOption('image', '/backend/images/icons/small/calendar_jq.png');
    $this->setOption('date_widget', new sfWidgetFormDateTime( array('date' => array( 'format'=>'%day% %month% %year%' ), 'time' => $this->getOption('time') ) ) );
  }

}
?>