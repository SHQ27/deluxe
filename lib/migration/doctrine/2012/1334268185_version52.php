<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version52 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('ncredito', 'importe', 'decimal', '12', array(
             'scale' => '2',
             ));
        $this->changeColumn('ncredito', 'entorno', 'string', '4', array(
             'fixed' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('ncredito', 'importe');
    }
}