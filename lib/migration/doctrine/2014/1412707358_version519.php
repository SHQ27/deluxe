<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version519 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('costo_envio', 'valor_prioritario');
        
        $this->renameColumn('costo_envio', 'valor_estandar_deluxe', 'costo_estandar');
        $this->renameColumn('costo_envio', 'valor_sucursal_deluxe', 'costo_sucursal');
        
        $this->addColumn('costo_envio', 'valor_eshop_estandar', 'decimal', '12', array(
             'scale' => '2',
             ));
        $this->addColumn('costo_envio', 'valor_eshop_sucursal', 'decimal', '12', array(
             'scale' => '2',
             ));
    }
        
    public function down()
    {
    }
}