<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version687 extends Doctrine_Migration_Base
{
    public function up()
    {
        $permiso = new sfGuardPermission();
        $permiso->setName('reportes_reporte_marketing');
        $permiso->setDescription('Reportes / Reporte de Marketing');
        $permiso->save();
    }

    public function down()
    {
    }
}