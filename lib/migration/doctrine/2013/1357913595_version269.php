<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version269 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('orden_compra_oca', 'estado', 'char', '5', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('orden_compra_oca', 'estado');
    }
}