<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version646 extends Doctrine_Migration_Base
{
    public function up()
    {
        $eshop = eshopTable::getInstance()->findOneByIdEshop(6);
        $eshop->setLinkColor('#000000');
        $eshop->save();
        
    }

    public function down()
    {
        
    }
}