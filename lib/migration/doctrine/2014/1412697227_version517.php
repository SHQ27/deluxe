<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version517 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop', 'oca_solicitante', 'string', '255', array(
             ));
        $this->addColumn('eshop', 'oca_centro_costo', 'string', '255', array(
             ));
        $this->addColumn('eshop', 'oca_nro_cuenta', 'string', '255', array(
             ));
        $this->addColumn('eshop', 'oca_user', 'string', '255', array(
             ));
        $this->addColumn('eshop', 'oca_pass', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('eshop', 'oca_solicitante');
        $this->removeColumn('eshop', 'oca_centro_costo');
        $this->removeColumn('eshop', 'oca_nro_cuenta');
        $this->removeColumn('eshop', 'oca_user');
        $this->removeColumn('eshop', 'oca_pass');
    }
}