<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version662 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('producto_item', 'stock_limite');
    }

    public function down()
    {
        $this->addColumn('producto_item', 'stock_limite', 'integer', '4', array(
             ));
    }
}