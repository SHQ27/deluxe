<?php

/**
 * categoriaMl
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class categoriaMl extends BasecategoriaMl
{
    const ATTR_TYPE_NONE       = 'none';
    const ATTR_TYPE_ATTRIBUTES = 'attributes';
    const ATTR_TYPE_VARIATIONS = 'variations';
    
    public function __toString()
    {
    	return $this->getDenominacion();
    }
    
}