<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version416 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addIndex('localidad', 'fk_localidad_id_mercado_libre', array(
             'fields' => 
             array(
              0 => 'id_mercado_libre',
             ),
             ));
        $this->addIndex('provincia', 'fk_provincia_id_mercado_libre', array(
             'fields' => 
             array(
              0 => 'id_mercado_libre',
             ),
             ));
        $this->addIndex('provincia', 'fk_provincia_id_oca', array(
             'fields' => 
             array(
              0 => 'id_oca',
             ),
             ));
    }

    public function down()
    {
        $this->removeIndex('localidad', 'fk_localidad_id_mercado_libre', array(
             'fields' => 
             array(
              0 => 'id_mercado_libre',
             ),
             ));
        $this->removeIndex('provincia', 'fk_provincia_id_mercado_libre', array(
             'fields' => 
             array(
              0 => 'id_mercado_libre',
             ),
             ));
        $this->removeIndex('provincia', 'fk_provincia_id_oca', array(
             'fields' => 
             array(
              0 => 'id_oca',
             ),
             ));
    }
}