<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version161 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('stock', 'es_outlet', 'boolean', '25', array(
             ));
        $this->addColumn('stock_historico', 'es_outlet', 'boolean', '25', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('stock', 'es_outlet');
        $this->removeColumn('stock_historico', 'es_outlet');
    }
}