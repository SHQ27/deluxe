<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version685 extends Doctrine_Migration_Base
{
    public function up()
    {
        $eshop = eshopTable::getInstance()->findOneByIdEshop(1);
        $eshop->setDecidirNroComercio('00240315');
        $eshop->save();
    }

    public function down()
    {
        $this->removeColumn('eshop', 'decidir_nroComercio');
    }
}