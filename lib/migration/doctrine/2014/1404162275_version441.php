<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version441 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addIndex('pedido', 'ix_pedido_codigo_envio', array(
             'fields' => 
             array(
              0 => 'codigo_envio',
             ),
             ));
    }

    public function down()
    {
        $this->removeIndex('pedido', 'ix_pedido_codigo_envio', array(
             'fields' => 
             array(
              0 => 'codigo_envio',
             ),
             ));
    }
}