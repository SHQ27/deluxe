<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version674 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE eshop SET freeshipping = 999999;");
    }

    public function down()
    {
    }
}