<?php

class Version339 extends Doctrine_Migration_Base
{
    public function up()
    {
        $permiso = new sfGuardPermission();
        $permiso->setName('desc_y_bonif_premios');
        $permiso->setDescription('Desc. y Bonif. / Premios');
        $permiso->save();
    }

    public function down()
    {
    }
}

