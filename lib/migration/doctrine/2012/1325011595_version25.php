<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version25 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('stock_historico', 'id_stock', 'integer', '4', array(
             ));
    }

    public function down()
    {

    }
}