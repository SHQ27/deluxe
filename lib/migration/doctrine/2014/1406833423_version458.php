<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version458 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE campana SET mostrar_descripcion = 1;");
        $q->execute("UPDATE promo_permanente SET mostrar_descripcion = 1;");
    }

    public function down()
    {
    
    }
}