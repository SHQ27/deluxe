<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version457 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('campana', 'mostrar_descripcion', 'boolean', '25', array(
             'default' => '1',
             ));
        $this->addColumn('promo_permanente', 'mostrar_descripcion', 'boolean', '25', array(
             'default' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('campana', 'mostrar_descripcion');
        $this->removeColumn('promo_permanente', 'mostrar_descripcion');
    }
}