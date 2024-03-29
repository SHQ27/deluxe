<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version452 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('notificacion_backend', 'created_at');
        $this->removeColumn('notificacion_backend', 'updated_at');
        $this->addColumn('notificacion_backend', 'fecha_alta', 'timestamp', '25', array(
             'notnull' => '1',
             ));
    }

    public function down()
    {
        $this->addColumn('notificacion_backend', 'created_at', 'timestamp', '25', array(
             'notnull' => '1',
             ));
        $this->addColumn('notificacion_backend', 'updated_at', 'timestamp', '25', array(
             'notnull' => '1',
             ));
        $this->removeColumn('notificacion_backend', 'fecha_alta');
    }
}