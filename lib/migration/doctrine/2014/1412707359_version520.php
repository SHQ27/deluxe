<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version520 extends Doctrine_Migration_Base
{
    public function up()
    {
       
        $this->addColumn('costo_envio', 'costo_eshop_estandar', 'decimal', '12', array(
             'scale' => '2',
             ));
        $this->addColumn('costo_envio', 'costo_eshop_sucursal', 'decimal', '12', array(
             'scale' => '2',
             ));
    }
        
    public function down()
    {
    }
}