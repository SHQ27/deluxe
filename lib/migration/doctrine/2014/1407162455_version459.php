<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version459 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('banner_principal', 'mostrar_descripcion', 'boolean', '25', array(
             'default' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('banner_principal', 'mostrar_descripcion');
    }
}