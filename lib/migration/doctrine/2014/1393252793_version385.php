<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version385 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("INSERT INTO fallado SELECT null, id_pedido_producto_item, 0  FROM devolucion_producto_item where esta_fallado;");
    }

    public function down()
    {

    }
}