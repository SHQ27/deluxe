<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version592 extends Doctrine_Migration_Base
{
    public function up()
    {
        $eshop = eshopTable::getInstance()->findOneByIdEshop(5);
        $eshop->setEmailNoReply('eShop - Janet Wise <noreply@janetwise.com.ar>');
        $eshop->save();
    }

    public function down()
    {
    }
}