<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version215 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('talle_zona', 'orden', 'integer', '4', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('talle_zona', 'orden');
    }
}