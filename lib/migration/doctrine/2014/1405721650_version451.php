<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version451 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('notificacion_backend', 'created_at', 'timestamp', '25', array(
             'notnull' => '1',
             ));
        $this->addColumn('notificacion_backend', 'updated_at', 'timestamp', '25', array(
             'notnull' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('notificacion_backend', 'created_at');
        $this->removeColumn('notificacion_backend', 'updated_at');
    }
}