<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version533 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('descuento', 'recibe_premio', 'boolean', '25', array(
             'default' => '0',
             ));
    }

    public function down()
    {
        $this->removeColumn('descuento', 'recibe_premio');
    }
}