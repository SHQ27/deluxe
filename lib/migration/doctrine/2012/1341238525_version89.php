<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version89 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('pedido', 'id_orden_retiro_oca', 'string', '50', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('pedido', 'id_orden_retiro_oca');
    }
}