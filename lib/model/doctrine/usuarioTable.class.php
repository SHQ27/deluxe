<?php


class usuarioTable extends Doctrine_Table
{
    /**
     * 
     * @return usuarioTable
     */    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('usuario');
    }
    
    public function findOneByCredentials($email, $pass, $idEshop)
    {
        $usuario = new usuario();
        $usuario->setEmail($email);
        $usuario->setPassword($pass);
        $usuario->setIdEshop( $idEshop );
        
        
        $q = $this->createQuery('u')
                  ->where('email = ?', $usuario->getEmail() )
                  ->addWhere('password = ?', $usuario->getPassword() )
                  ->addWhere('(fecha_baja IS NULL OR fecha_baja = ?)', '')
                  ->addWhere('activo = ?', true);
                    
        if ( $usuario->getIdEshop() ) {
            $q->addwhere('u.id_eshop = ?', $usuario->getIdEshop() );
        } else {
            $q->addwhere('u.id_eshop IS NULL');
        }
                    
        return $q->fetchOne();
    }
    
    public function findOneByFid($email, $fid)
    {
        $usuario = new usuario();
        $usuario->setEmail($email);
        $usuario->setFid($fid);
        return $this->createQuery('u')
                    ->where('u.email = ?', $usuario->getEmail())
                    ->andWhere('u.fid = ?', $usuario->getFid())
                    ->addWhere('activo = ?', true)
                    ->fetchOne();
    }
    
    public function searchByEmail($email)
    {

        return $this->createQuery('u')
                    ->where('email LIKE ?', "$email%")
                    ->execute();
    }
        
    public function getByEmail($email, $idEshop ){
    
        $q = $this->createQuery('u')
                  ->addWhere('u.email = ?', $email );
        
        if ( $idEshop ) {
            $q->addwhere('u.id_eshop = ?', $idEshop );
        } else {
            $q->addwhere('u.id_eshop IS NULL');
        }
    
        return $q->fetchOne();
    }
        
    /**
     * Devuelve el listado de usuarios que compraron en una campaña
     *
     * @param $idCampana
     *
     * @return Doctrine_Collection
     */
    public function compraronEnCampana($idCampana)
    {
        $filepath = sfConfig::get('sf_temp_dir') . '/' . 'usuarios_compraron_' .  time() . '.csv';
        
        $con = Doctrine_Manager::getInstance()->connection();
                
        $query = $this->createQuery('u')
                     ->select('u.nombre, u.apellido, u.email, u.sexo')
                     ->innerJoin('u.pedido p')
                     ->innerJoin('p.pedidoProductoItem ppi')
                     ->innerJoin('ppi.pedidoProductoItemCampana ppic')
                     ->addWhere('ppic.id_campana = ?', $idCampana)
                     ->addWhere('p.fecha_pago IS NOT NULL')
                     ->addWhere('p.fecha_baja IS NULL')
                     ->getSqlQuery();
        
        $query .= " INTO OUTFILE '" . $filepath . "' FIELDS TERMINATED BY ',' ENCLOSED BY '' LINES TERMINATED BY '\n';";
        $query = str_replace('u.id_usuario AS u__id_usuario,', '', $query);        
        
        $con->execute($query, array( $idCampana ) );
        
        return $filepath;
        
    }    

    public function getCount( $desde, $hasta, $idEshop = null )
    {
        $response = array();
        
        
        // Registrados
        $q = $this->createQuery('u')
                  ->addWhere('? <= date(u.fecha_alta) AND date(u.fecha_alta) <= ?', array($desde, $hasta));
        
        if ( $idEshop ) {
            $q->addWhere('u.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('u.id_eshop IS NULL' );
        }
        
        $response['registrados'] = $q->count();
        
        
        // Compraron
        $q = $this->createQuery('u')
                  ->addWhere('? <= date(u.fecha_alta) AND date(u.fecha_alta) <= ?')
                  ->addWhere('(SELECT count(*) FROM pedido p WHERE (p.id_usuario = u.id_usuario) AND (? <= date(p.fecha_pago) AND date(p.fecha_pago) <= ?) AND p.fecha_baja IS NULL) >= 1', array($desde, $hasta, $desde, $hasta));
        
        if ( $idEshop ) {
            $q->addWhere('u.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('u.id_eshop IS NULL' );
        }
        
        $response['compraron'] = $q->count();
        
        
        // Repitieron
        $q = $this->createQuery('u')
                  ->addWhere('? <= date(u.fecha_alta) AND date(u.fecha_alta) <= ?')
                  ->addWhere('(SELECT count(*) FROM pedido p WHERE (p.id_usuario = u.id_usuario) AND (? <= date(p.fecha_pago) AND date(p.fecha_pago) <= ?) AND p.fecha_baja IS NULL) > 1', array($desde, $hasta, $desde, $hasta));
        
        if ( $idEshop ) {
            $q->addWhere('u.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('u.id_eshop IS NULL' );
        }
        
        $response['repitieron'] = $q->count();
        
        return $response;
    }
    
    /*
     * Verifica si el usuario cumple condicion de unicidad
    *
    * @param string $email
    * @param int $idUsuario
    * @param int $idEshop
    *
    * @return bool
    */
    public function isUnique($email, $idUsuario, $idEshop ){
    
        $q = $this->createQuery('u')
                  ->addWhere('u.email = ?', $email );
        
        if ( $idUsuario ) {
            $q->addwhere('u.id_usuario <> ?', $idUsuario );
        }
        
    	if ( $idEshop ) {
    	    $q->addwhere('u.id_eshop = ?', $idEshop );
    	} else {
    	    $q->addwhere('u.id_eshop IS NULL');
    	}
                	
        return (bool) $q->count() == 0;
    }

    public function queryForRemarkety($desde, $hasta){

      $q = $this->createQuery('u');

      if ( $desde ) {
        $q->addWhere('u.fecha_alta >= ?', $desde);  
      }
      
      if ( $hasta ) {
        $q->addWhere('u.fecha_alta <= ?', $hasta);
      }

      $q->addwhere('u.id_eshop IS NULL');

      return $q;
    }

    public function listForRemarkety($desde, $hasta, $limit, $page){
      $q = $this->queryForRemarkety( $desde, $hasta );
      $q->orderBy('u.fecha_alta asc');
      return $q->limit($limit)
               ->offset($limit * $page)
               ->execute();
    }

    public function countForRemarkety($desde, $hasta){
      return $this->queryForRemarkety( $desde, $hasta )->count();
    }
    
    
}