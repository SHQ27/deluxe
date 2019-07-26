<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version446 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE devolucion_producto_item SET cantidad_fallados = cantidad_stock WHERE esta_fallado = true;");
        
        $this->removeColumn('devolucion_producto_item', 'esta_fallado');
    }

    public function down()
    {
        $this->addColumn('devolucion_producto_item', 'esta_fallado', 'boolean', '25', array());
    }
}