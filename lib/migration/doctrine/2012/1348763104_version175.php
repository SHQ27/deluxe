<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version175 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('pedido', 'monto_envio_deluxe', 'decimal', '12', array(
             'scale' => '2',
             ));
    }

    public function down()
    {
        $this->removeColumn('pedido', 'monto_envio_deluxe');
    }
}