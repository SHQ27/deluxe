<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version364 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('imagen_banner_principal', array(
             'id_imagen_banner_principal' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'src' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'ibp_id' => 
              array(
              'fields' => 
              array(
               0 => 'id',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_imagen_banner_principal',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('imagen_banner_principal');
    }
}