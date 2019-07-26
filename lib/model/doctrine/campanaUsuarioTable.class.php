<?php


class campanaUsuarioTable extends Doctrine_Table
{
	/**
	 * Retorna una instancia de campanaUsuarioTable;
	 *
	 * @return campanaUsuarioTable
	 */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('campanaUsuario');
    }

    /**
     * Envia el mail al usuario con sus datos de acceso
     *
     */
    public function sendMailAccessData($campana, $usuario, $email, $password)
    {
        $subject = 'Urgente Deluxebuys';
        $vars = array( 'title' => $subject, 'campana' => $campana, 'usuario' => $usuario, 'password' => $password );
        $mailer = new Mailer('proveedoresAccessData', $vars);
        $mailer->send( $subject, $email );
    }
    
    /**
     * Retorna un campanaUsuario
     *
     */
    public function getByCompoundKey($idCampana, $email)
    {
    	return $this->createQuery('cu')
    	->addWhere('cu.id_campana = ?', $idCampana)
    	->addWhere('cu.email = ?', $email)
    	->fetchOne();
    }
    
    /**
     * Genera un password al azar
     *
     */
    public function generateRandomPassword()
    {
    	return substr(md5(mt_rand()), 0, 8);
    }
    
    
    public function listByIdCampana($idCampana)
    {
    	return $this->createQuery('cu')
    	->addWhere('cu.id_campana = ?', $idCampana)
    	->execute();
    }
    

}