<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version425 extends Doctrine_Migration_Base
{
    public function up()
    {
    	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
    	$response = $q->execute("UPDATE localidad SET id_provincia = 3 where id_provincia = 2;");
    }

    public function down()
    {
    	
    }
}