<?php

/**
 * Basebanner
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_banner
 * @property string $url
 * @property integer $orden
 * @property boolean $activo
 * @property boolean $ventana_nueva
 * 
 * @method integer getIdBanner()      Returns the current record's "id_banner" value
 * @method string  getUrl()           Returns the current record's "url" value
 * @method integer getOrden()         Returns the current record's "orden" value
 * @method boolean getActivo()        Returns the current record's "activo" value
 * @method boolean getVentanaNueva()  Returns the current record's "ventana_nueva" value
 * @method banner  setIdBanner()      Sets the current record's "id_banner" value
 * @method banner  setUrl()           Sets the current record's "url" value
 * @method banner  setOrden()         Sets the current record's "orden" value
 * @method banner  setActivo()        Sets the current record's "activo" value
 * @method banner  setVentanaNueva()  Sets the current record's "ventana_nueva" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basebanner extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('banner');
        $this->hasColumn('id_banner', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('orden', 'integer', 2, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('activo', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('ventana_nueva', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
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