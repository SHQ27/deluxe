<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version407 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('producto', 'data_mercado_libre', 'clob', '65535', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('producto', 'data_mercado_libre');
    }
}