<?php

class pmWidgetFormDate extends sfWidgetFormJQueryDate
{

  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options,$attributes);
    
    $this->setOption('date_widget', new sfWidgetFormDate( array('format'=>'%day% %month% %year%' )));
    $this->setOption('culture', 'es');
    $this->setOption('image', '/backend/images/icons/small/calendar_jq.png');
  }

}
?>