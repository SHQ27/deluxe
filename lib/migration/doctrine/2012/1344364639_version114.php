<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version114 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('descuento', 'info_adicional', 'clob', '65535', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('descuento', 'info_adicional');
    }
}