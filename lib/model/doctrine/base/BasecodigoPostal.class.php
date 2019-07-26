<?php

/**
 * BasecodigoPostal
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_codigo_postal
 * @property string $valor
 * @property integer $id_provincia
 * @property provincia $provincia
 * 
 * @method integer      getIdCodigoPostal()   Returns the current record's "id_codigo_postal" value
 * @method string       getValor()            Returns the current record's "valor" value
 * @method integer      getIdProvincia()      Returns the current record's "id_provincia" value
 * @method provincia    getProvincia()        Returns the current record's "provincia" value
 * @method codigoPostal setIdCodigoPostal()   Sets the current record's "id_codigo_postal" value
 * @method codigoPostal setValor()            Sets the current record's "valor" value
 * @method codigoPostal setIdProvincia()      Sets the current record's "id_provincia" value
 * @method codigoPostal setProvincia()        Sets the current record's "provincia" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasecodigoPostal extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('codigo_postal');
        $this->hasColumn('id_codigo_postal', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('valor', 'string', 8, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 8,
             ));
        $this->hasColumn('id_provincia', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));


        $this->index('fk_codigo_postal_provincia1', array(
             'fields' => 
             array(
              0 => 'id_provincia',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('provincia', array(
             'local' => 'id_provincia',
             'foreign' => 'id_provincia',
             'owningSide' => true));
    }
}