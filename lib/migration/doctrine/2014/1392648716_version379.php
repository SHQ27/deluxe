<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version379 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE bonificacion SET fecha_alta = now();");
    }

    public function down()
    {
    }
}