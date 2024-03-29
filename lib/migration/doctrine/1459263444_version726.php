<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version726 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('carrito_envio', 'envio_id_correo');
        $this->removeColumn('carrito_envio', 'envio_servicio');
        $this->addColumn('carrito_envio', 'id_correo', 'string', '20', array(
             ));
        $this->addColumn('carrito_envio', 'servicio', 'char', '1', array(
             ));
    }

    public function down()
    {
        $this->addColumn('carrito_envio', 'envio_id_correo', 'string', '20', array(
             ));
        $this->addColumn('carrito_envio', 'envio_servicio', 'char', '1', array(
             ));
        $this->removeColumn('carrito_envio', 'id_correo');
        $this->removeColumn('carrito_envio', 'servicio');
    }
}