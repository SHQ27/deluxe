<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version569 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('carrito_envio', 'id_locker_oca', 'integer', '4', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('carrito_envio', 'id_locker_oca');
    }
}