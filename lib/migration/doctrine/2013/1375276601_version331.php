<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version331 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();        
        $q->execute("DELETE FROM forma_pago WHERE id_forma_pago='MPOFF';");
    }

    public function down()
    {

    }
}