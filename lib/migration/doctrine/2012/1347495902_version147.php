<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version147 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('usuario', 'fecha_source', 'date', '25', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('usuario', 'fecha_source');
    }
}