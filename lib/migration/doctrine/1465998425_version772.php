<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version772 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
		$q->execute("UPDATE eshop SET texto_consultas = 'Consultas';");
		$q->execute("UPDATE eshop SET texto_consultas = 'Contacto' WHERE id_eshop = 10;");
    }

    public function down()
    {
        
    }
}