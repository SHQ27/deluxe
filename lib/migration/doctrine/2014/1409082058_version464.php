<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version464 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE descuento SET vigencia_hasta = fecha_expiracion;");
    }

    public function down()
    {
    }
}