<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version2 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('producto_talle', 'orden', 'integer', '1', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('producto_talle', 'orden');
    }
}