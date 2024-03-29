<?php

/**
 * Basepremio
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_premio
 * @property integer $monto_minimo
 * @property integer $valor
 * @property integer $dias_vencimiento
 * @property date $fecha_desde
 * @property date $fecha_hasta
 * @property string $tipo_premio
 * @property Doctrine_Collection $premioLog
 * 
 * @method integer             getIdPremio()         Returns the current record's "id_premio" value
 * @method integer             getMontoMinimo()      Returns the current record's "monto_minimo" value
 * @method integer             getValor()            Returns the current record's "valor" value
 * @method integer             getDiasVencimiento()  Returns the current record's "dias_vencimiento" value
 * @method date                getFechaDesde()       Returns the current record's "fecha_desde" value
 * @method date                getFechaHasta()       Returns the current record's "fecha_hasta" value
 * @method string              getTipoPremio()       Returns the current record's "tipo_premio" value
 * @method Doctrine_Collection getPremioLog()        Returns the current record's "premioLog" collection
 * @method premio              setIdPremio()         Sets the current record's "id_premio" value
 * @method premio              setMontoMinimo()      Sets the current record's "monto_minimo" value
 * @method premio              setValor()            Sets the current record's "valor" value
 * @method premio              setDiasVencimiento()  Sets the current record's "dias_vencimiento" value
 * @method premio              setFechaDesde()       Sets the current record's "fecha_desde" value
 * @method premio              setFechaHasta()       Sets the current record's "fecha_hasta" value
 * @method premio              setTipoPremio()       Sets the current record's "tipo_premio" value
 * @method premio              setPremioLog()        Sets the current record's "premioLog" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basepremio extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('premio');
        $this->hasColumn('id_premio', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('monto_minimo', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('valor', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('dias_vencimiento', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('fecha_desde', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('fecha_hasta', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('tipo_premio', 'string', 5, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 5,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('premioLog', array(
             'local' => 'id_premio',
             'foreign' => 'id_premio'));
    }
}