<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version156 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropTable('suscripcion_bonificacion');
    }

    public function down()
    {
        $this->createTable('suscripcion_bonificacion', array(
             'id_suscripcion_bonificacion' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_newsletter' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'fecha_suscripcion' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_suscripcion_bonificacion_newsletter1' => 
              array(
              'fields' => 
              array(
               0 => 'id_newsletter',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_suscripcion_bonificacion',
             ),
             'collate' => '',
             'charset' => '',
             ));
    }
}