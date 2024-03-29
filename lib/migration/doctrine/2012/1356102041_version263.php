<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version263 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('producto', 'precio_normal', 'decimal', '12', array(
             'scale' => '2',
             ));
        $this->addColumn('producto', 'precio_outlet', 'decimal', '12', array(
             'scale' => '2',
             ));
    }

    public function down()
    {
        $this->removeColumn('producto', 'precio_normal');
        $this->removeColumn('producto', 'precio_outlet');
    }
}