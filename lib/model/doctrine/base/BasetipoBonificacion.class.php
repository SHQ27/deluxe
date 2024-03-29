<?php

/**
 * BasetipoBonificacion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $id_tipo_bonificacion
 * @property string $denominacion
 * @property Doctrine_Collection $bonificaciones
 * 
 * @method string              getIdTipoBonificacion()   Returns the current record's "id_tipo_bonificacion" value
 * @method string              getDenominacion()         Returns the current record's "denominacion" value
 * @method Doctrine_Collection getBonificaciones()       Returns the current record's "bonificaciones" collection
 * @method tipoBonificacion    setIdTipoBonificacion()   Sets the current record's "id_tipo_bonificacion" value
 * @method tipoBonificacion    setDenominacion()         Sets the current record's "denominacion" value
 * @method tipoBonificacion    setBonificaciones()       Sets the current record's "bonificaciones" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasetipoBonificacion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tipo_bonificacion');
        $this->hasColumn('id_tipo_bonificacion', 'string', 5, array(
             'type' => 'string',
             'fixed' => 1,
             'primary' => true,
             'length' => 5,
             ));
        $this->hasColumn('denominacion', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('bonificacion as bonificaciones', array(
             'local' => 'id_tipo_bonificacion',
             'foreign' => 'id_tipo_bonificacion'));
    }
}