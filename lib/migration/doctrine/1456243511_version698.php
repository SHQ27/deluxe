<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version698 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('campana', 'resetear_al_finalizar', 'boolean', '25', array(
             'default' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('campana', 'resetear_al_finalizar');
    }
}