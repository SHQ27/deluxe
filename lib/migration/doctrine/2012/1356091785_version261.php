<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version261 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('stock_historico', 'es_outlet');
        $this->addColumn('stock_historico', 'origen', 'string', '6', array(
             'fixed' => '1',
             ));
    }

    public function down()
    {
        $this->addColumn('stock_historico', 'es_outlet', 'boolean', '25', array(
             ));
        $this->removeColumn('stock_historico', 'origen');
    }
}