<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Deletepermisoslook extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("DELETE FROM sf_guard_group_permission where permission_id = 13;");
        $q->execute("DELETE FROM sf_guard_permission where id = 13;");
    }

    public function down()
    {

    }
}