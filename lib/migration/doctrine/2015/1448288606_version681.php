<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version681 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("delete from sf_guard_permission where name = 'reportes_reporte_life_time_value';");
    }

    public function down()
    {

    }
}