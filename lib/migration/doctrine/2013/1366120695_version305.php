<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version305 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('oca_pedido_anulado', 'fecha', 'date', '25', array(
             ));
    }

    public function down()
    {

    }
}