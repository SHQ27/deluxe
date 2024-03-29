<?php

/**
 * Baseconfiguracion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $id_configuracion
 * @property string $denominacion
 * @property clob $valor
 * @property string $tipo
 * 
 * @method string        getIdConfiguracion()  Returns the current record's "id_configuracion" value
 * @method string        getDenominacion()     Returns the current record's "denominacion" value
 * @method clob          getValor()            Returns the current record's "valor" value
 * @method string        getTipo()             Returns the current record's "tipo" value
 * @method configuracion setIdConfiguracion()  Sets the current record's "id_configuracion" value
 * @method configuracion setDenominacion()     Sets the current record's "denominacion" value
 * @method configuracion setValor()            Sets the current record's "valor" value
 * @method configuracion setTipo()             Sets the current record's "tipo" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Baseconfiguracion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('configuracion');
        $this->hasColumn('id_configuracion', 'string', 5, array(
             'type' => 'string',
             'fixed' => 1,
             'primary' => true,
             'length' => 5,
             ));
        $this->hasColumn('denominacion', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('valor', 'clob', 65535, array(
             'type' => 'clob',
             'length' => 65535,
             ));
        $this->hasColumn('tipo', 'string', 5, array(
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
        
    }
}