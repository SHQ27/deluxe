<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version666 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE stock_tipo SET denominacion = 'Carga inicial' WHERE id_stock_tipo = 1;");
    }

    public function down()
    {

    }
}