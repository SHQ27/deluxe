<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version469 extends Doctrine_Migration_Base
{
    public function up()
    {       
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE pedido P SET P.documento = (SELECT U1.documento FROM usuario as U1 WHERE U1.id_usuario = P.id_usuario), tipo_documento = (SELECT U1.tipo_documento FROM usuario U1 WHERE U1.id_usuario = P.id_usuario);");
    }

    public function down()
    {
    }
}