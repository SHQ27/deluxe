<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version410 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE producto SET id_categoria_ml = null;");
                
        $this->changeColumn('producto', 'id_categoria_ml', 'integer', '4', array(
             ));
    }

    public function down()
    {

    }
}