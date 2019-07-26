<?php


class invitacionTable extends Doctrine_Table
{
    /**
     * @return invitacionTable
     */    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('invitacion');
    }
    /**
     * @return Doctrine_Query_Abstract
     */
    public function createQueryByUsuario(usuario $usuario)
    {
        return $this->createQuery('i')->where('id_usuario = ?', $usuario->getIdUsuario());
    }
    
    public function findOneByUsuarioAndEmail($usuario, $email)
    {
        return $this->createQuery('i')
            ->where('id_usuario = ?', $usuario)
            ->addWhere('email_invitado = ?', $email)
            ->fetchOne();
    }
    
    public function listByEmail($email)
    {
    	return $this->createQuery('i')
    	->addWhere('LOWER(email_invitado) = ?', strtolower($email))
    	->execute();
    }
    
    public function findPedidosPendientes()
    {
        return $this->createQuery('i')
                  ->innerJoin('i.pedido p ON  i.id_usuario_invitado = p.id_usuario')
                  ->where('i.id_pedido_realizado IS NULL')
                  ->execute();
    }

    public function findByEmail($email)
    {
        return $this->createQuery('i')
            ->addWhere('LOWER(email_invitado) = ?', strtolower($email))
            ->fetchOne();
    }

    public function findByIdUsuarioInvitado($idUsuarioInvitado)
    {
        return $this->createQuery('i')
            ->addWhere('id_usuario_invitado = ?', $idUsuarioInvitado)
            ->fetchOne();
    }

    public function listPorProcesar()
    {
        return $this->createQuery('i')
            ->addWhere('bonificacion = ?', false)
            ->addWhere('id_pedido_realizado IS NOT NULL')
            ->addWhere('id_usuario_invitado IS NOT NULL')
            ->execute();
    }
}