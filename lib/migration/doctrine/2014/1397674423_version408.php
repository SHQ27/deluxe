<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version408 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('producto', 'data_mercado_libre');
        $this->addColumn('producto', 'id_categoria_ml', 'string', '20', array(
             ));
        $this->addColumn('producto_item', 'data_mercado_libre', 'clob', '65535', array(
             ));
    }

    public function down()
    {
        $this->addColumn('producto', 'data_mercado_libre', 'clob', '65535', array(
             ));
        $this->removeColumn('producto', 'id_categoria_ml');
        $this->removeColumn('producto_item', 'data_mercado_libre');
    }
}