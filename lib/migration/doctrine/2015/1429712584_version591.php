<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version591 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('eshop', 'mercado_pago_enc');
        $this->removeColumn('eshop', 'mercado_pago_token');
        $this->removeColumn('eshop', 'mercado_pago_acc_id');
    }

    public function down()
    {
        $this->addColumn('eshop', 'mercado_pago_enc', 'string', '255', array(
             ));
        $this->addColumn('eshop', 'mercado_pago_token', 'string', '255', array(
             ));
        $this->addColumn('eshop', 'mercado_pago_acc_id', 'string', '255', array(
             ));
    }
}