<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version290 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE pedido SET fecha_informado_oca = fecha_envio where tipo_producto = 'STKPE' AND fecha_envio IS NOT NULL;");
    }

    public function down()
    {
    }
}