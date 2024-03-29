<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version486 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('eshop_tienda', 'id_eshop_tienda_categoria');
        
        $this->createForeignKey('eshop_tienda_tienda_categoria', 'eiei_4', array(
             'name' => 'eiei_4',
             'local' => 'id_eshop_tienda',
             'foreign' => 'id_eshop_tienda',
             'foreignTable' => 'eshop_tienda',
             ));
        $this->createForeignKey('eshop_tienda_tienda_categoria', 'eiei_5', array(
             'name' => 'eiei_5',
             'local' => 'id_eshop_tienda_categoria',
             'foreign' => 'id_eshop_tienda_categoria',
             'foreignTable' => 'eshop_tienda_categoria',
             ));
        $this->addIndex('eshop_tienda_tienda_categoria', 'eshop_tienda_tienda_categoria_id_eshop_tienda', array(
             'fields' => 
             array(
              0 => 'id_eshop_tienda',
             ),
             ));
        $this->addIndex('eshop_tienda_tienda_categoria', 'eshop_tienda_tienda_categoria_id_eshop_tienda_categoria', array(
             'fields' => 
             array(
              0 => 'id_eshop_tienda_categoria',
             ),
             ));
    }

    public function down()
    {

        $this->addColumn('eshop_tienda', 'id_eshop_tienda_categoria', 'integer', '4', array(
            'notnull' => '1',
        ));
        
        $this->dropForeignKey('eshop_tienda_tienda_categoria', 'eiei_4');
        $this->dropForeignKey('eshop_tienda_tienda_categoria', 'eiei_5');
        $this->removeIndex('eshop_tienda_tienda_categoria', 'eshop_tienda_tienda_categoria_id_eshop_tienda', array(
             'fields' => 
             array(
              0 => 'id_eshop_tienda',
             ),
             ));
        $this->removeIndex('eshop_tienda_tienda_categoria', 'eshop_tienda_tienda_categoria_id_eshop_tienda_categoria', array(
             'fields' => 
             array(
              0 => 'id_eshop_tienda_categoria',
             ),
             ));
    }
}