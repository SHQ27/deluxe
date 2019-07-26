<?php

class pmWebResponse extends sfWebResponse
{
  
  public function addMeta($key, $value, $replace = true, $escape = true)
  {
      if ($key == 'title' && stripos($value, 'DeluxeBuys - ') === false)
      {
          $value = 'DeluxeBuys - ' . $value;
      }
      
      parent::addMeta($key, $value, $replace, $escape);
  }
  
}
