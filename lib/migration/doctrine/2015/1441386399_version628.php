<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version628 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop_home_multimedia', 'indice', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('eshop_home_multimedia', 'indice');
    }
}