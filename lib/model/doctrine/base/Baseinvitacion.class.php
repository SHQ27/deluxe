<?php

/**
 * Baseinvitacion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_invitacion
 * @property integer $id_usuario
 * @property string $email_invitado
 * @property string $hash
 * @property string $fue_enviada
 * @property date $fecha
 * @property integer $id_usuario_invitado
 * @property integer $id_pedido_realizado
 * @property boolean $bonificacion
 * @property usuario $usuario_invitados
 * @property usuario $usuario
 * @property pedido $pedido
 * 
 * @method integer    getIdInvitacion()        Returns the current record's "id_invitacion" value
 * @method integer    getIdUsuario()           Returns the current record's "id_usuario" value
 * @method string     getEmailInvitado()       Returns the current record's "email_invitado" value
 * @method string     getHash()                Returns the current record's "hash" value
 * @method string     getFueEnviada()          Returns the current record's "fue_enviada" value
 * @method date       getFecha()               Returns the current record's "fecha" value
 * @method integer    getIdUsuarioInvitado()   Returns the current record's "id_usuario_invitado" value
 * @method integer    getIdPedidoRealizado()   Returns the current record's "id_pedido_realizado" value
 * @method boolean    getBonificacion()        Returns the current record's "bonificacion" value
 * @method usuario    getUsuarioInvitados()    Returns the current record's "usuario_invitados" value
 * @method usuario    getUsuario()             Returns the current record's "usuario" value
 * @method pedido     getPedido()              Returns the current record's "pedido" value
 * @method invitacion setIdInvitacion()        Sets the current record's "id_invitacion" value
 * @method invitacion setIdUsuario()           Sets the current record's "id_usuario" value
 * @method invitacion setEmailInvitado()       Sets the current record's "email_invitado" value
 * @method invitacion setHash()                Sets the current record's "hash" value
 * @method invitacion setFueEnviada()          Sets the current record's "fue_enviada" value
 * @method invitacion setFecha()               Sets the current record's "fecha" value
 * @method invitacion setIdUsuarioInvitado()   Sets the current record's "id_usuario_invitado" value
 * @method invitacion setIdPedidoRealizado()   Sets the current record's "id_pedido_realizado" value
 * @method invitacion setBonificacion()        Sets the current record's "bonificacion" value
 * @method invitacion setUsuarioInvitados()    Sets the current record's "usuario_invitados" value
 * @method invitacion setUsuario()             Sets the current record's "usuario" value
 * @method invitacion setPedido()              Sets the current record's "pedido" value
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Baseinvitacion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('invitacion');
        $this->hasColumn('id_invitacion', 'integer', 4, array(
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
        $this->hasColumn('email_invitado', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('hash', 'string', 32, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 32,
             ));
        $this->hasColumn('fue_enviada', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             ));
        $this->hasColumn('fecha', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('id_usuario_invitado', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('id_pedido_realizado', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('bonificacion', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));


        $this->index('fk_invitacion_usuario1', array(
             'fields' => 
             array(
              0 => 'id_usuario',
             ),
             ));
        $this->index('fk_invitacion_usuario2', array(
             'fields' => 
             array(
              0 => 'id_usuario_invitado',
             ),
             ));
        $this->index('fk_invitacion_pedido1', array(
             'fields' => 
             array(
              0 => 'id_pedido_realizado',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('usuario as usuario_invitados', array(
             'local' => 'id_usuario',
             'foreign' => 'id_usuario',
             'owningSide' => true));

        $this->hasOne('usuario', array(
             'local' => 'id_usuario_invitado',
             'foreign' => 'id_usuario',
             'owningSide' => true));

        $this->hasOne('pedido', array(
             'local' => 'id_pedido_realizado',
             'foreign' => 'id_pedido',
             'owningSide' => true));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             'created' => 
             array(
              'name' => 'fecha',
              'type' => 'timestamp',
              'format' => 'Y-m-d',
             ),
             'updated' => 
             array(
              'disabled' => true,
             ),
             ));
        $this->actAs($timestampable0);
    }
}