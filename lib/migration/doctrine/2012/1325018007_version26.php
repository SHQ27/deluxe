<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version26 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('stock', 'empaquetado', 'boolean', '25', array(
             'default' => '0',
             ));
        $this->changeColumn('stock', 'fecha', 'timestamp', '25', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('stock', 'empaquetado');
    }
}