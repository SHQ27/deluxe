<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version188 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('pedido', 'id_bonificacion_baja_fuera_plazo');
    }

    public function down()
    {
        $this->addColumn('pedido', 'id_bonificacion_baja_fuera_plazo', 'integer', '4', array(
             ));
    }
}