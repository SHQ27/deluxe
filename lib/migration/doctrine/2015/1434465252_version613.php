<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version613 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop_banner_secundario', 'fecha_desde', 'timestamp', '25', array(
             ));
        $this->addColumn('eshop_banner_secundario', 'fecha_hasta', 'timestamp', '25', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('eshop_banner_secundario', 'fecha_desde');
        $this->removeColumn('eshop_banner_secundario', 'fecha_hasta');
    }
}