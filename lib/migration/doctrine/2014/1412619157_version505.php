<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version505 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('descuento', 'descuento_id_eshop_eshop_id_eshop', array(
             'name' => 'descuento_id_eshop_eshop_id_eshop',
             'local' => 'id_eshop',
             'foreign' => 'id_eshop',
             'foreignTable' => 'eshop',
             ));
        $this->addIndex('descuento', 'descuento_id_eshop', array(
             'fields' => 
             array(
              0 => 'id_eshop',
             ),
             ));
        $this->addIndex('usuario', 'unique_row', array(
             'fields' => 
             array(
              'email' => 
              array(
              'sorting' => 'ASC',
              ),
              'sexo' => 
              array(
              'sorting' => 'ASC',
              ),
              'id_eshop' => 
              array(
              'sorting' => 'ASC',
              ),
             ),
             'type' => 'unique',
             ));
    }

    public function down()
    {
        $this->dropForeignKey('descuento', 'descuento_id_eshop_eshop_id_eshop');
        $this->removeIndex('descuento', 'descuento_id_eshop', array(
             'fields' => 
             array(
              0 => 'id_eshop',
             ),
             ));
        $this->removeIndex('usuario', 'unique_row', array(
             'fields' => 
             array(
              'email' => 
              array(
              'sorting' => 'ASC',
              ),
              'sexo' => 
              array(
              'sorting' => 'ASC',
              ),
              'id_eshop' => 
              array(
              'sorting' => 'ASC',
              ),
             ),
             'type' => 'unique',
             ));
    }
}