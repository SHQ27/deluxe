<?php

/**
 * BaseimagenBannerPrincipal
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_imagen_banner_principal
 * @property integer $id
 * @property string $tipo
 * @property string $src
 * 
 * @method integer               getIdImagenBannerPrincipal()    Returns the current record's "id_imagen_banner_principal" value
 * @method integer               getId()                         Returns the current record's "id" value
 * @method string                getTipo()                       Returns the current record's "tipo" value
 * @method string                getSrc()                        Returns the current record's "src" value
 * @method imagenBannerPrincipal setIdImagenBannerPrincipal()    Sets the current record's "id_imagen_banner_principal" value
 * @method imagenBannerPrincipal setId()                         Sets the current record's "id" value
 * @method imagenBannerPrincipal setTipo()                       Sets the current record's "tipo" value
 * @method imagenBannerPrincipal setSrc()                        Sets the current record's "src" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseimagenBannerPrincipal extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('imagen_banner_principal');
        $this->hasColumn('id_imagen_banner_principal', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('tipo', 'string', 5, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 5,
             ));
        $this->hasColumn('src', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));


        $this->index('ibp_id', array(
             'fields' => 
             array(
              0 => 'id',
             ),
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