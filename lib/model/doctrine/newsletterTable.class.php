<?php


class newsletterTable extends Doctrine_Table
{
	/**
	 * 
	 * @return newsletterTable
	 */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('newsletter');
    }   

	public static function listAll( )
	{    	
    	return Doctrine_Query::create()	    	
						->from('newsletter n')
						->orderBy( 'n.email ASC')
						->execute();	
	}
	
	public static function getByEmail( $email )
	{    	
    	return Doctrine_Query::create()	    	
						->from('newsletter n')
						->where("n.email = ?", $email)
						->fetchOne();	
	}

	/**
	 * Retorna todos los newsletter creados un dia determinado
	 *
	 * @param string $fechaAlta
	 *
	 * @return Doctrine_Collection
	 */
	public function listByFechaAlta($fechaAlta, $idEshop, $genre = null)
	{
	    $q = $this->createQuery('n')
				  ->addWhere('date(n.fecha_alta) = ?', $fechaAlta);
				    
		if ( $idEshop ) {
			$q->addwhere('n.id_eshop = ?', $idEshop );
		} else {
			$q->addwhere('n.id_eshop IS NULL');
		}

		if ( $genre ) {
			$q->addWhere('n.sexo = ?', $genre );
		}

		
		
		return $q->execute();
	}
	
    public function subscriberExist($genre, $email, $idEshop)
    {		  
		  $q = $this->createQuery('n')
                    ->addWhere('n.email = ?', $email )
            		->addWhere('n.sexo = ?', $genre );
		  
		  if ( $idEshop ) {
		      $q->addwhere('n.id_eshop = ?', $idEshop );
		  } else {
		      $q->addwhere('n.id_eshop IS NULL');
		  }
		  
		  return (bool) $q->count();
    }    
    
    public function nombreSexo($sexo)
	{
		$denominacionSexo = array('h' => 'Hombre', 'm' => 'Mujer');
		return $denominacionSexo[$sexo];
    }

    public function exportFile()
    { 	
    	$filepath = sfConfig::get('sf_temp_dir') . '/' . 'newsletter_' .  time() . '.csv';
		$query = "select n.nombre, n.apellido, n.email, n.sexo,  COALESCE(e.denominacion, 'Deluxe Buys'), n.fecha_alta from newsletter n LEFT JOIN eshop e ON n.id_eshop = e.id_eshop INTO OUTFILE '" . $filepath . "' FIELDS TERMINATED BY ',' ENCLOSED BY '' LINES TERMINATED BY '\n';";
		$con = Doctrine_Manager::getInstance()->connection();
		$st = $con->execute($query);
		
		return $filepath;
    }
    
    public function getCount( $desde, $hasta, $idEshop = null )
    {
    	$q = $this->createQuery('n')
    			  ->addWhere('? <= date(n.fecha_alta) AND date(n.fecha_alta) <= ?', array($desde, $hasta));
    	
    	if ( $idEshop ) {
    	    $q->addWhere('n.id_eshop = ?', $idEshop );
    	} else {
    	    $q->addWhere('n.id_eshop IS NULL' );
    	}    	
    	
        return $q->count();
    }

    
}
