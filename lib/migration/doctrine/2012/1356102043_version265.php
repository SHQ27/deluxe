<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version265 extends Doctrine_Migration_Base
{
    public function up()
    {
        $config = configuracionTable::getInstance()->findOneByIdConfiguracion('FOUTL');
        $config->delete();
    }

    public function down()
    {

    }
}