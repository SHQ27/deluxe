<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version724 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
		$q->execute("UPDATE provincia SET iso = REPLACE(id_mercado_libre, 'AR-', '');");
    }

    public function down()
    {

    }
}