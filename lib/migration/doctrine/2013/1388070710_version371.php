<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version371 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('faltante', 'monto_devuelto', 'decimal', '12', array(
             'scale' => '2',
             ));
    }

    public function down()
    {
        $this->removeColumn('faltante', 'monto_devuelto');
    }
}