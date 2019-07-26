<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version477 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('eshop_banner_principal', array(
             'id_eshop_banner_principal' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             'id_eshop' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'denominacion' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'url' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'ventana_nueva' => 
             array(
              'type' => 'boolean',
              'length' => '25',
             ),
             'orden' => 
             array(
              'type' => 'integer',
              'length' => '2',
             ),
             'activo' => 
             array(
              'type' => 'boolean',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id_eshop_banner_principal',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('eshop_banner_secundario', array(
             'id_eshop_banner_secundario' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             'id_eshop' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'denominacion' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'primera_linea' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'segunda_linea' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'url' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'ventana_nueva' => 
             array(
              'type' => 'boolean',
              'length' => '25',
             ),
             'orden' => 
             array(
              'type' => 'integer',
              'length' => '2',
             ),
             'activo' => 
             array(
              'type' => 'boolean',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id_eshop_banner_secundario',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->addColumn('eshop', 'texto_home', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->dropTable('eshop_banner_principal');
        $this->dropTable('eshop_banner_secundario');
        $this->removeColumn('eshop', 'texto_home');
    }
}