<?php

/**
 * BasefacturaWsRequestFactura
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_factura_ws_request
 * @property integer $id_factura
 * @property facturaWsRequest $facturaWsRequest
 * @property factura $factura
 * 
 * @method integer                 getIdFacturaWsRequest()    Returns the current record's "id_factura_ws_request" value
 * @method integer                 getIdFactura()             Returns the current record's "id_factura" value
 * @method facturaWsRequest        getFacturaWsRequest()      Returns the current record's "facturaWsRequest" value
 * @method factura                 getFactura()               Returns the current record's "factura" value
 * @method facturaWsRequestFactura setIdFacturaWsRequest()    Sets the current record's "id_factura_ws_request" value
 * @method facturaWsRequestFactura setIdFactura()             Sets the current record's "id_factura" value
 * @method facturaWsRequestFactura setFacturaWsRequest()      Sets the current record's "facturaWsRequest" value
 * @method facturaWsRequestFactura setFactura()               Sets the current record's "factura" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasefacturaWsRequestFactura extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('factura_ws_request_factura');
        $this->hasColumn('id_factura_ws_request', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_factura', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));


        $this->index('fk_factura_ws_request_has_factura_factura1', array(
             'fields' => 
             array(
              0 => 'id_factura',
             ),
             ));
        $this->index('fk_factura_ws_request_has_factura_factura_ws_request1', array(
             'fields' => 
             array(
              0 => 'id_factura_ws_request',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('facturaWsRequest', array(
             'local' => 'id_factura_ws_request',
             'foreign' => 'id_factura_ws_request',
             'owningSide' => true));

        $this->hasOne('factura', array(
             'local' => 'id_factura',
             'foreign' => 'id_factura',
             'owningSide' => true));
    }
}