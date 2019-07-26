<?php

/**
 * BaseusuarioTalleZona
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_talle_zona
 * @property integer $id_usuario
 * @property integer $medida
 * @property talleZona $talleZona
 * @property usuario $usuario
 * 
 * @method integer          getIdTalleZona()   Returns the current record's "id_talle_zona" value
 * @method integer          getIdUsuario()     Returns the current record's "id_usuario" value
 * @method integer          getMedida()        Returns the current record's "medida" value
 * @method talleZona        getTalleZona()     Returns the current record's "talleZona" value
 * @method usuario          getUsuario()       Returns the current record's "usuario" value
 * @method usuarioTalleZona setIdTalleZona()   Sets the current record's "id_talle_zona" value
 * @method usuarioTalleZona setIdUsuario()     Sets the current record's "id_usuario" value
 * @method usuarioTalleZona setMedida()        Sets the current record's "medida" value
 * @method usuarioTalleZona setTalleZona()     Sets the current record's "talleZona" value
 * @method usuarioTalleZona setUsuario()       Sets the current record's "usuario" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseusuarioTalleZona extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('usuario_talle_zona');
        $this->hasColumn('id_talle_zona', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_usuario', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('medida', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));


        $this->index('fk_talle_zona_has_usuario_usuario1', array(
             'fields' => 
             array(
              0 => 'id_usuario',
             ),
             ));
        $this->index('fk_talle_zona_has_usuario_talle_zona1', array(
             'fields' => 
             array(
              0 => 'id_talle_zona',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('talleZona', array(
             'local' => 'id_talle_zona',
             'foreign' => 'id_talle_zona',
             'owningSide' => true));

        $this->hasOne('usuario', array(
             'local' => 'id_usuario',
             'foreign' => 'id_usuario',
             'owningSide' => true));
    }
}