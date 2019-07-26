<?php

class Version355 extends Doctrine_Migration_Base
{
    public function up()
    {
        $permiso = new sfGuardPermission();
        $permiso->setName('gestion_logistica_campanas');
        $permiso->setDescription('Gestión. / Logistica de Campañas');
        $permiso->save();
    }

    public function down()
    {
    }
}

