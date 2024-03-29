<?php

/**
 * Basebonificacion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_bonificacion
 * @property integer $id_usuario
 * @property string $id_tipo_descuento
 * @property char $id_tipo_bonificacion
 * @property decimal $valor
 * @property boolean $fue_utilizada
 * @property date $vencimiento
 * @property boolean $es_interna
 * @property clob $observaciones
 * @property timestamp $fecha_alta
 * @property tipoDescuento $tipoDescuento
 * @property tipoBonificacion $tipoBonificacion
 * @property usuario $usuario
 * @property Doctrine_Collection $carritoBonificacion
 * @property Doctrine_Collection $pedidoBonificacion
 * @property Doctrine_Collection $faltante
 * @property Doctrine_Collection $devolucion
 * @property Doctrine_Collection $premioLog
 * 
 * @method integer             getIdBonificacion()       Returns the current record's "id_bonificacion" value
 * @method integer             getIdUsuario()            Returns the current record's "id_usuario" value
 * @method string              getIdTipoDescuento()      Returns the current record's "id_tipo_descuento" value
 * @method char                getIdTipoBonificacion()   Returns the current record's "id_tipo_bonificacion" value
 * @method decimal             getValor()                Returns the current record's "valor" value
 * @method boolean             getFueUtilizada()         Returns the current record's "fue_utilizada" value
 * @method date                getVencimiento()          Returns the current record's "vencimiento" value
 * @method boolean             getEsInterna()            Returns the current record's "es_interna" value
 * @method clob                getObservaciones()        Returns the current record's "observaciones" value
 * @method timestamp           getFechaAlta()            Returns the current record's "fecha_alta" value
 * @method tipoDescuento       getTipoDescuento()        Returns the current record's "tipoDescuento" value
 * @method tipoBonificacion    getTipoBonificacion()     Returns the current record's "tipoBonificacion" value
 * @method usuario             getUsuario()              Returns the current record's "usuario" value
 * @method Doctrine_Collection getCarritoBonificacion()  Returns the current record's "carritoBonificacion" collection
 * @method Doctrine_Collection getPedidoBonificacion()   Returns the current record's "pedidoBonificacion" collection
 * @method Doctrine_Collection getFaltante()             Returns the current record's "faltante" collection
 * @method Doctrine_Collection getDevolucion()           Returns the current record's "devolucion" collection
 * @method Doctrine_Collection getPremioLog()            Returns the current record's "premioLog" collection
 * @method bonificacion        setIdBonificacion()       Sets the current record's "id_bonificacion" value
 * @method bonificacion        setIdUsuario()            Sets the current record's "id_usuario" value
 * @method bonificacion        setIdTipoDescuento()      Sets the current record's "id_tipo_descuento" value
 * @method bonificacion        setIdTipoBonificacion()   Sets the current record's "id_tipo_bonificacion" value
 * @method bonificacion        setValor()                Sets the current record's "valor" value
 * @method bonificacion        setFueUtilizada()         Sets the current record's "fue_utilizada" value
 * @method bonificacion        setVencimiento()          Sets the current record's "vencimiento" value
 * @method bonificacion        setEsInterna()            Sets the current record's "es_interna" value
 * @method bonificacion        setObservaciones()        Sets the current record's "observaciones" value
 * @method bonificacion        setFechaAlta()            Sets the current record's "fecha_alta" value
 * @method bonificacion        setTipoDescuento()        Sets the current record's "tipoDescuento" value
 * @method bonificacion        setTipoBonificacion()     Sets the current record's "tipoBonificacion" value
 * @method bonificacion        setUsuario()              Sets the current record's "usuario" value
 * @method bonificacion        setCarritoBonificacion()  Sets the current record's "carritoBonificacion" collection
 * @method bonificacion        setPedidoBonificacion()   Sets the current record's "pedidoBonificacion" collection
 * @method bonificacion        setFaltante()             Sets the current record's "faltante" collection
 * @method bonificacion        setDevolucion()           Sets the current record's "devolucion" collection
 * @method bonificacion        setPremioLog()            Sets the current record's "premioLog" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basebonificacion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('bonificacion');
        $this->hasColumn('id_bonificacion', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_usuario', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_tipo_descuento', 'string', 5, array(
             'type' => 'string',
             'fixed' => 1,
             'notnull' => true,
             'length' => 5,
             ));
        $this->hasColumn('id_tipo_bonificacion', 'char', 5, array(
             'type' => 'char',
             'fixed' => 1,
             'notnull' => true,
             'length' => 5,
             ));
        $this->hasColumn('valor', 'decimal', 12, array(
             'type' => 'decimal',
             'scale' => 2,
             'length' => 12,
             ));
        $this->hasColumn('fue_utilizada', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('vencimiento', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('es_interna', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('observaciones', 'clob', 65535, array(
             'type' => 'clob',
             'length' => 65535,
             ));
        $this->hasColumn('fecha_alta', 'timestamp', null, array(
             'type' => 'timestamp',
             ));


        $this->index('fk_bonificacion_tipo_descuento1', array(
             'fields' => 
             array(
              0 => 'id_tipo_descuento',
             ),
             ));
        $this->index('fk_bonificacion_tipo_bonificacion1', array(
             'fields' => 
             array(
              0 => 'id_tipo_bonificacion',
             ),
             ));
        $this->index('fk_bonificacion_usuario1', array(
             'fields' => 
             array(
              0 => 'id_usuario',
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

        $this->hasOne('tipoBonificacion', array(
             'local' => 'id_tipo_bonificacion',
             'foreign' => 'id_tipo_bonificacion',
             'owningSide' => true));

        $this->hasOne('usuario', array(
             'local' => 'id_usuario',
             'foreign' => 'id_usuario',
             'owningSide' => true));

        $this->hasMany('carritoBonificacion', array(
             'local' => 'id_bonificacion',
             'foreign' => 'id_bonificacion'));

        $this->hasMany('pedidoBonificacion', array(
             'local' => 'id_bonificacion',
             'foreign' => 'id_bonificacion'));

        $this->hasMany('faltante', array(
             'local' => 'id_bonificacion',
             'foreign' => 'id_bonificacion'));

        $this->hasMany('devolucion', array(
             'local' => 'id_bonificacion',
             'foreign' => 'id_bonificacion'));

        $this->hasMany('premioLog', array(
             'local' => 'id_bonificacion',
             'foreign' => 'id_bonificacion'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             'created' => 
             array(
              'name' => 'fecha_alta',
              'type' => 'timestamp',
              'format' => 'Y-m-d H:i:s',
             ),
             'updated' => 
             array(
              'disabled' => true,
             ),
             ));
        $this->actAs($timestampable0);
    }
}