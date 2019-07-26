<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version38 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('factura', 'factura_id_pedido_pedido_id_pedido', array(
             'name' => 'factura_id_pedido_pedido_id_pedido',
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'foreignTable' => 'pedido',
             ));
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
        $this->addIndex('factura', 'factura_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
        $this->addIndex('factura_ws_request_Factura', 'factura_ws_request_Factura_id_factura_ws_request', array(
             'fields' => 
             array(
              0 => 'id_factura_ws_request',
             ),
             ));
        $this->addIndex('factura_ws_request_Factura', 'factura_ws_request_Factura_id_factura', array(
             'fields' => 
             array(
              0 => 'id_factura',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('factura', 'factura_id_pedido_pedido_id_pedido');
        $this->dropForeignKey('factura_ws_request_Factura', 'fifi_1');
        $this->dropForeignKey('factura_ws_request_Factura', 'factura_ws_request_Factura_id_factura_factura_id_factura');
        $this->removeIndex('factura', 'factura_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
        $this->removeIndex('factura_ws_request_Factura', 'factura_ws_request_Factura_id_factura_ws_request', array(
             'fields' => 
             array(
              0 => 'id_factura_ws_request',
             ),
             ));
        $this->removeIndex('factura_ws_request_Factura', 'factura_ws_request_Factura_id_factura', array(
             'fields' => 
             array(
              0 => 'id_factura',
             ),
             ));
    }
}