<?php

/**
 * BasecarritoBonificacion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_carrito_bonificacion
 * @property integer $id_bonificacion
 * @property string $id_session
 * @property bonificacion $bonificacion
 * @property session $session
 * 
 * @method integer             getIdCarritoBonificacion()   Returns the current record's "id_carrito_bonificacion" value
 * @method integer             getIdBonificacion()          Returns the current record's "id_bonificacion" value
 * @method string              getIdSession()               Returns the current record's "id_session" value
 * @method bonificacion        getBonificacion()            Returns the current record's "bonificacion" value
 * @method session             getSession()                 Returns the current record's "session" value
 * @method carritoBonificacion setIdCarritoBonificacion()   Sets the current record's "id_carrito_bonificacion" value
 * @method carritoBonificacion setIdBonificacion()          Sets the current record's "id_bonificacion" value
 * @method carritoBonificacion setIdSession()               Sets the current record's "id_session" value
 * @method carritoBonificacion setBonificacion()            Sets the current record's "bonificacion" value
 * @method carritoBonificacion setSession()                 Sets the current record's "session" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasecarritoBonificacion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('carrito_bonificacion');
        $this->hasColumn('id_carrito_bonificacion', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_bonificacion', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_session', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));


        $this->index('fk_carrito_bonificacion_bonificacion1', array(
             'fields' => 
             array(
              0 => 'id_bonificacion',
             ),
             ));
        $this->index('fk_carrito_bonificacion_session1', array(
             'fields' => 
             array(
              0 => 'id_session',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('bonificacion', array(
             'local' => 'id_bonificacion',
             'foreign' => 'id_bonificacion',
             'owningSide' => true));

        $this->hasOne('session', array(
             'local' => 'id_session',
             'foreign' => 'id_session',
             'owningSide' => true));
    }
}