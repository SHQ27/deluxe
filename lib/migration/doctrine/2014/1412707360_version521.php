<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version521 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        
        $q->execute("UPDATE costo_envio SET valor_eshop_estandar = valor_estandar;");
        $q->execute("UPDATE costo_envio SET valor_eshop_sucursal = valor_sucursal;");
        $q->execute("UPDATE costo_envio SET costo_eshop_estandar = costo_estandar;");
        $q->execute("UPDATE costo_envio SET costo_eshop_sucursal = costo_sucursal;");
        
    }
        
    public function down()
    {
    }
}