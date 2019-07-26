<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version44 extends Doctrine_Migration_Base
{
    public function up()
    {    	
        $this->dropForeignKey('factura_ws_request_Factura', 'fifi_1');
        $this->dropForeignKey('factura_ws_request_Factura', 'factura_ws_request_Factura_id_factura_factura_id_factura');
        
        $this->renameTable('factura_ws_request_Factura', 'factura_ws_request_factura');
        
        $this->createForeignKey('factura_ws_request_factura', 'fifi_3', array(
             'name' => 'fifi_3',
             'local' => 'id_factura_ws_request',
             'foreign' => 'id_factura_ws_request',
             'foreignTable' => 'factura_ws_request',
             ));
        $this->createForeignKey('factura_ws_request_factura', 'factura_ws_request_factura_id_factura_factura_id_factura', array(
             'name' => 'factura_ws_request_factura_id_factura_factura_id_factura',
             'local' => 'id_factura',
             'foreign' => 'id_factura',
             'foreignTable' => 'factura',
             ));
        $this->createForeignKey('ncredito', 'ncredito_id_factura_factura_id_factura', array(
             'name' => 'ncredito_id_factura_factura_id_factura',
             'local' => 'id_factura',
             'foreign' => 'id_factura',
             'foreignTable' => 'factura',
             ));
        $this->createForeignKey('ncredito_ws_request_ncredito', 'ncredito_ws_request_ncredito_id_ncredito_ncredito_id_ncredito', array(
             'name' => 'ncredito_ws_request_ncredito_id_ncredito_ncredito_id_ncredito',
             'local' => 'id_ncredito',
             'foreign' => 'id_ncredito',
             'foreignTable' => 'ncredito',
             ));
        $this->createForeignKey('ncredito_ws_request_ncredito', 'nini_1', array(
             'name' => 'nini_1',
             'local' => 'id_ncredito_ws_request',
             'foreign' => 'id_ncredito_ws_request',
             'foreignTable' => 'ncredito_ws_request',
             ));

        $this->addIndex('ncredito', 'ncredito_id_factura', array(
             'fields' => 
             array(
              0 => 'id_factura',
             ),
             ));
        $this->addIndex('ncredito_ws_request_ncredito', 'ncredito_ws_request_ncredito_id_ncredito', array(
             'fields' => 
             array(
              0 => 'id_ncredito',
             ),
             ));
        $this->addIndex('ncredito_ws_request_ncredito', 'ncredito_ws_request_ncredito_id_ncredito_ws_request', array(
             'fields' => 
             array(
              0 => 'id_ncredito_ws_request',
             ),
             ));
    }

    public function down()
    {
        $this->createForeignKey('factura_ws_request_Factura', 'fifi_1', array(
             'name' => 'fifi_1',
             'local' => 'id_factura_ws_request',
             'foreign' => 'id_factura_ws_request',
             'foreignTable' => 'factura_ws_request',
             ));
        $this->createForeignKey('factura_ws_request_Factura', 'factura_ws_request_Factura_id_factura_factura_id_factura', array(
             'name' => 'factura_ws_request_Factura_id_factura_factura_id_factura',
             'local' => 'id_factura',
             'foreign' => 'id_factura',
             'foreignTable' => 'factura',
             ));
        $this->dropForeignKey('factura_ws_request_factura', 'fifi_3');
        $this->dropForeignKey('factura_ws_request_factura', 'factura_ws_request_factura_id_factura_factura_id_factura');
        $this->dropForeignKey('ncredito', 'ncredito_id_factura_factura_id_factura');
        $this->dropForeignKey('ncredito_ws_request_ncredito', 'ncredito_ws_request_ncredito_id_ncredito_ncredito_id_ncredito');
        $this->dropForeignKey('ncredito_ws_request_ncredito', 'nini_1');
        $this->removeIndex('factura_ws_request_factura', 'factura_ws_request_factura_id_factura_ws_request', array(
             'fields' => 
             array(
              0 => 'id_factura_ws_request',
             ),
             ));
        $this->removeIndex('factura_ws_request_factura', 'factura_ws_request_factura_id_factura', array(
             'fields' => 
             array(
              0 => 'id_factura',
             ),
             ));
        $this->removeIndex('ncredito', 'ncredito_id_factura', array(
             'fields' => 
             array(
              0 => 'id_factura',
             ),
             ));
        $this->removeIndex('ncredito_ws_request_ncredito', 'ncredito_ws_request_ncredito_id_ncredito', array(
             'fields' => 
             array(
              0 => 'id_ncredito',
             ),
             ));
        $this->removeIndex('ncredito_ws_request_ncredito', 'ncredito_ws_request_ncredito_id_ncredito_ws_request', array(
             'fields' => 
             array(
              0 => 'id_ncredito_ws_request',
             ),
             ));
    }
}