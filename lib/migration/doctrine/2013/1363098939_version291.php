<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version291 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('faltante', 'id_bonificacion', 'integer', '4', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('faltante', 'id_bonificacion');
    }
}