<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version428 extends Doctrine_Migration_Base
{
    public function up()
    {
    	$formaPago = new formaPago();
    	$formaPago->setIdFormaPago('MELIB');
    	$formaPago->setDenominacion('Mercado Libre');
    	$formaPago->save();
    }

    public function down()
    {
    	
    }
}