<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version181 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('descuento', 'es_interno', 'boolean', '25', array(
             'default' => '0',
             ));
    }

    public function down()
    {
        $this->removeColumn('descuento', 'es_interno');
    }
}