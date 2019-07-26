<?php

class PermisosPromoEnPermanente extends Doctrine_Migration_Base
{
    public function up()
    {
        $permiso = new sfGuardPermission();
        $permiso->setName('prod_y_campanas_promociones_permanente');
        $permiso->setDescription('Prod. y Campañas / Promociones de Permanente');
        $permiso->save();
    }

    public function down()
    {
    }
}

