<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version138 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('campana', 'mostrar_filtros', 'boolean', '25', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('campana', 'mostrar_filtros');
    }
}