<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version647 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop', 'activo', 'boolean', '25', array(
             ));


    }

    public function down()
    {
        $this->removeColumn('eshop', 'activo');
    }
}