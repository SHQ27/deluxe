<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version691 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop', 'mail_rrhh', 'string', '255', array());
    }

    public function down()
    {
        $this->removeColumn('eshop', 'mail_rrhh');
    }
}