<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version561 extends Doctrine_Migration_Base
{
    public function up()
    {
        $eshop = eshopTable::getInstance()->findOneByIdEshop(2);
        $eshop->setSoporteEmail('riearriba.ml@gmail.com');
        $eshop->setSoportePass('crrzycmgwubmfaiu');
        $eshop->setMlIdOfficialStore('171688249');
        $eshop->save();
        
        $eshop = eshopTable::getInstance()->findOneByIdEshop(3);
        $eshop->setSoporteEmail('roshmoda.ml@gmail.com');
        $eshop->setSoportePass('cvsfyfgqikujrwfx');
        $eshop->setMlIdOfficialStore('171688713');
        $eshop->save();
    }

    public function down()
    {
    }
}