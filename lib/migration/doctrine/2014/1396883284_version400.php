<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version400 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('campana_marca', 'precio_lista');
        $this->addColumn('campana_marca', 'costo_total', 'decimal', '12', array(
             'scale' => '2',
             ));
    }

    public function down()
    {
        $this->addColumn('campana_marca', 'precio_lista', 'decimal', '12', array(
             'scale' => '2',
             ));
        $this->removeColumn('campana_marca', 'costo_total');
    }
}