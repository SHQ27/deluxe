<?php

/**
 * BasepublicacionMl
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_producto
 * @property timestamp $fecha_inicio
 * @property timestamp $fecha_fin
 * @property string $item_id
 * @property clob $data_mercado_libre
 * @property char $status_ml
 * @property producto $producto
 * 
 * @method integer       getIdProducto()         Returns the current record's "id_producto" value
 * @method timestamp     getFechaInicio()        Returns the current record's "fecha_inicio" value
 * @method timestamp     getFechaFin()           Returns the current record's "fecha_fin" value
 * @method string        getItemId()             Returns the current record's "item_id" value
 * @method clob          getDataMercadoLibre()   Returns the current record's "data_mercado_libre" value
 * @method char          getStatusMl()           Returns the current record's "status_ml" value
 * @method producto      getProducto()           Returns the current record's "producto" value
 * @method publicacionMl setIdProducto()         Sets the current record's "id_producto" value
 * @method publicacionMl setFechaInicio()        Sets the current record's "fecha_inicio" value
 * @method publicacionMl setFechaFin()           Sets the current record's "fecha_fin" value
 * @method publicacionMl setItemId()             Sets the current record's "item_id" value
 * @method publicacionMl setDataMercadoLibre()   Sets the current record's "data_mercado_libre" value
 * @method publicacionMl setStatusMl()           Sets the current record's "status_ml" value
 * @method publicacionMl setProducto()           Sets the current record's "producto" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasepublicacionMl extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('publicacion_ml');
        $this->hasColumn('id_producto', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('fecha_inicio', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('fecha_fin', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('item_id', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('data_mercado_libre', 'clob', 65535, array(
             'type' => 'clob',
             'length' => 65535,
             ));
        $this->hasColumn('status_ml', 'char', 6, array(
             'type' => 'char',
             'length' => 6,
             ));


        $this->index('fk_publicacion_ml_id_producto', array(
             'fields' => 
             array(
              0 => 'id_producto',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('producto', array(
             'local' => 'id_producto',
             'foreign' => 'id_producto',
             'owningSide' => true));
    }
}