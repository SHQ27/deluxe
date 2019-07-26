<?php

/**
 * Basedescuento
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_descuento
 * @property string $codigo
 * @property string $id_tipo_descuento
 * @property decimal $valor
 * @property timestamp $vigencia_desde
 * @property timestamp $vigencia_hasta
 * @property integer $total
 * @property integer $utilizados
 * @property boolean $es_interno
 * @property integer $id_eshop
 * @property boolean $recibe_premio
 * @property tipoDescuento $tipoDescuento
 * @property eshop $eshop
 * @property Doctrine_Collection $carritoDescuento
 * @property Doctrine_Collection $pedidoDescuento
 * @property Doctrine_Collection $descuentoRestriccion
 * @property Doctrine_Collection $promoPago
 * 
 * @method integer             getIdDescuento()          Returns the current record's "id_descuento" value
 * @method string              getCodigo()               Returns the current record's "codigo" value
 * @method string              getIdTipoDescuento()      Returns the current record's "id_tipo_descuento" value
 * @method decimal             getValor()                Returns the current record's "valor" value
 * @method timestamp           getVigenciaDesde()        Returns the current record's "vigencia_desde" value
 * @method timestamp           getVigenciaHasta()        Returns the current record's "vigencia_hasta" value
 * @method integer             getTotal()                Returns the current record's "total" value
 * @method integer             getUtilizados()           Returns the current record's "utilizados" value
 * @method boolean             getEsInterno()            Returns the current record's "es_interno" value
 * @method integer             getIdEshop()              Returns the current record's "id_eshop" value
 * @method boolean             getRecibePremio()         Returns the current record's "recibe_premio" value
 * @method tipoDescuento       getTipoDescuento()        Returns the current record's "tipoDescuento" value
 * @method eshop               getEshop()                Returns the current record's "eshop" value
 * @method Doctrine_Collection getCarritoDescuento()     Returns the current record's "carritoDescuento" collection
 * @method Doctrine_Collection getPedidoDescuento()      Returns the current record's "pedidoDescuento" collection
 * @method Doctrine_Collection getDescuentoRestriccion() Returns the current record's "descuentoRestriccion" collection
 * @method Doctrine_Collection getPromoPago()            Returns the current record's "promoPago" collection
 * @method descuento           setIdDescuento()          Sets the current record's "id_descuento" value
 * @method descuento           setCodigo()               Sets the current record's "codigo" value
 * @method descuento           setIdTipoDescuento()      Sets the current record's "id_tipo_descuento" value
 * @method descuento           setValor()                Sets the current record's "valor" value
 * @method descuento           setVigenciaDesde()        Sets the current record's "vigencia_desde" value
 * @method descuento           setVigenciaHasta()        Sets the current record's "vigencia_hasta" value
 * @method descuento           setTotal()                Sets the current record's "total" value
 * @method descuento           setUtilizados()           Sets the current record's "utilizados" value
 * @method descuento           setEsInterno()            Sets the current record's "es_interno" value
 * @method descuento           setIdEshop()              Sets the current record's "id_eshop" value
 * @method descuento           setRecibePremio()         Sets the current record's "recibe_premio" value
 * @method descuento           setTipoDescuento()        Sets the current record's "tipoDescuento" value
 * @method descuento           setEshop()                Sets the current record's "eshop" value
 * @method descuento           setCarritoDescuento()     Sets the current record's "carritoDescuento" collection
 * @method descuento           setPedidoDescuento()      Sets the current record's "pedidoDescuento" collection
 * @method descuento           setDescuentoRestriccion() Sets the current record's "descuentoRestriccion" collection
 * @method descuento           setPromoPago()            Sets the current record's "promoPago" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basedescuento extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('descuento');
        $this->hasColumn('id_descuento', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('codigo', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('id_tipo_descuento', 'string', 5, array(
             'type' => 'string',
             'fixed' => 1,
             'notnull' => true,
             'length' => 5,
             ));
        $this->hasColumn('valor', 'decimal', 12, array(
             'type' => 'decimal',
             'scale' => 2,
             'length' => 12,
             ));
        $this->hasColumn('vigencia_desde', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('vigencia_hasta', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('total', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('utilizados', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('es_interno', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('id_eshop', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('recibe_premio', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));


        $this->index('fk_descuento_tipo_descuento1', array(
             'fields' => 
             array(
              0 => 'id_tipo_descuento',
             ),
             ));
        $this->index('decuento_codigo_index', array(
             'fields' => 
             array(
              0 => 'codigo',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('tipoDescuento', array(
             'local' => 'id_tipo_descuento',
             'foreign' => 'id_tipo_descuento',
             'owningSide' => true));

        $this->hasOne('eshop', array(
             'local' => 'id_eshop',
             'foreign' => 'id_eshop',
             'owningSide' => true));

        $this->hasMany('carritoDescuento', array(
             'local' => 'id_descuento',
             'foreign' => 'id_descuento'));

        $this->hasMany('pedidoDescuento', array(
             'local' => 'id_descuento',
             'foreign' => 'id_descuento'));

        $this->hasMany('descuentoRestriccion', array(
             'local' => 'id_descuento',
             'foreign' => 'id_descuento'));

        $this->hasMany('promoPago', array(
             'local' => 'id_descuento',
             'foreign' => 'id_descuento'));
    }
}