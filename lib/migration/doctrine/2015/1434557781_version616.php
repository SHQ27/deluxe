<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version616 extends Doctrine_Migration_Base
{
    public function up()
    {
        $permiso = new sfGuardPermission();
        $permiso->setName('gestion_orden_home');
        $permiso->setDescription('Gestión. / Orden de Banners en Home');
        $permiso->save();
    }

    public function down()
    {
    }
}