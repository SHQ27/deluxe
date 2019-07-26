<?php


class faqTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de faqTable;
     *
     * @return faqTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('faq');
    }
    
	/**
	* Retorna el faq con orden mas bajo
	* 
	* @return faq
	*/
	public function getFirst($idFaqCategoria)
	{    	
    	return $this->createQuery('f')
    	                ->addWhere('f.id_faq_categoria = ?', $idFaqCategoria)
						->orderBy('f.orden ASC')
						->limit(1)
						->fetchOne();
	}
	
	/**
	* Retorna el faq con orden mas alto
	* 
	* @return faq
	*/
	public function getLast($idFaqCategoria)
	{    	
    	return $this->createQuery('f')
    	                ->addWhere('f.id_faq_categoria = ?', $idFaqCategoria)
						->orderBy('f.orden DESC')
						->limit(1)
						->fetchOne();						
	}
	
	/**
	* Retorna el anterior faq en para un $orden
	* 
    * @param integer $orden
	* 
	* @return faq
	*/
	public function getPrev( $idFaqCategoria, $orden )
	{    	
    	return $this->createQuery('f')
    	                ->addWhere('f.id_faq_categoria = ?', $idFaqCategoria)
						->addWhere('f.orden > ?', array( $orden ) )
						->orderBy('f.orden ASC')
						->limit(1)
						->fetchOne();
	}
	
	/**
	* Retorna el faq para un $orden
	* 
	* @param integer $orden
	* 
	* @return faq
	*/
	public function getNext( $idFaqCategoria, $orden )
	{    	
    	return $this->createQuery('f')
    	                ->addWhere('f.id_faq_categoria = ?', $idFaqCategoria)
						->addwhere('f.orden < ?', array( $orden ) )
						->orderBy('f.orden DESC')
						->limit(1)
						->fetchOne();		
	}
	
	/**
	 * Retorna el faq de como comprar
	 *
	 * @param integer $idEshop
	 *
	 * @return faq
	 */
	public function getComoComprar( $idEshop = null )
    {
        $q = $this->createQuery('f')
                  ->innerJoin('f.faqCategoria fc')
                  ->addwhere('f.es_como_comprar = ?', true);
        
        if ( $idEshop ) {
            $q->addwhere('fc.id_eshop = ?', $idEshop );
        } else {
            $q->addwhere('fc.id_eshop IS NULL');
        }
        
        return $q->limit(1)
                 ->fetchOne();
    }
	
	/**
	 * Elimina todos los Faq de un $idFaqCategoria
	 *
	 * @param number $idFaqCategoria
	 *
	 */
	public function deleteByIdFaqCategoria($idFaqCategoria)
	{
	    return $this->createQuery('f')
            	    ->addwhere('f.id_faq_categoria = ?', $idFaqCategoria)
            	    ->delete()
            	    ->execute();
	}
	
}