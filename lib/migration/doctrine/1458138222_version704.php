<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version704 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("DELETE FROM faltante WHERE eliminado = true;");
    }

    public function down()
    {
    }
}
