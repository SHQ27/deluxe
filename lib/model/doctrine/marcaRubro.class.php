<?php

/**
 * marcaRubro
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class marcaRubro extends BasemarcaRubro
{
    public function preSave($event)   {
        $this->clearCache($event);
    }
    public function preDelete($event) {
        $this->clearCache($event);
    }

    public function clearCache($event)
    {
    }

    public function __toString()
    {
        return $this->getDenominacion();
    }
}