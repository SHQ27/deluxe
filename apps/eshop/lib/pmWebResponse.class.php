<?php

class pmWebResponse extends sfWebResponse
{
  
  public function addMeta($key, $value, $replace = true, $escape = true)
  {
      $eshop = eshopTable::getInstance()->getCurrent();

      if ($key == 'title' && stripos($value, $eshop->getDenominacion() . ' - ') === false)
      {
          if ( $value ) {
              $value = 'eShop - ' . $eshop->getDenominacion() . ' - ' . $value;
          } else {
              $value = 'eShop - ' . $eshop->getDenominacion();
          }
      }
      
      parent::addMeta($key, $value, $replace, $escape);
  }
  
}
