<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version429 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('pago_notificacion', 'id', 'string', '50', array());
    }

    public function down()
    {
        $this->removeColumn('pago_notificacion', 'id');
    }
}