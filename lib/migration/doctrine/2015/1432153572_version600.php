<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version600 extends Doctrine_Migration_Base
{
    public function up()
    {		
		$this->dropTable('oca_pedido_anulado');
    }

    public function down()
    {

    }
}