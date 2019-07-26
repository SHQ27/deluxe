<?php

class PermisosReenviarPedidoDePermanenteAOca extends Doctrine_Migration_Base
{
    public function up()
    {
        
        $permiso = new sfGuardPermission();
        $permiso->setName('gestion_reenviar_pedido_de_permanente_a_oca');
        $permiso->setDescription('Gestión / Reenviar Pedido de Permanente a OCA');
        $permiso->save();
    }

    public function down()
    {
    }
}

