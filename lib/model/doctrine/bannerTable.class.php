<?php


class bannerTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de bannerTable;
	* 
	* @return bannerTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('banner');
    }
    	
	public function homeBanners()
	{
		return $this->createQuery('b')
    			    ->addWhere('b.activo = ?', true)
    			    ->orderBy('b.orden desc')
    			    ->useResultCache(true, null, cacheHelper::getInstance()->genKey("banner_homeBanner") )
    			    ->execute();
	}
	
	/**
	 * Retorna el banner con orden mas bajo
	 *
	 * @return banner
	 */
	public function getFirst()
	{
	    return $this->createQuery('b')
	    ->orderBy('b.orden ASC')
	    ->limit(1)
	    ->fetchOne();
	}
	
	/**
	 * Retorna el banner con orden mas alto
	 *
	 * @return banner
	 */
	public function getLast()
	{
	    return $this->createQuery('b')
	    ->orderBy('b.orden DESC')
	    ->limit(1)
	    ->fetchOne();
	}
	
	/**
	 * Retorna el anterior banner en para un $orden
	 *
	 * @param integer $orden
	 *
	 * @return banner
	 */
	public function getPrev( $orden )
	{
	    return $this->createQuery('b')
	    ->where('b.orden < ?', array( $orden ) )
	    ->orderBy('b.orden DESC')
	    ->limit(1)
	    ->fetchOne();
	}
	
	/**
	 * Retorna el banner contenido en para un $orden
	 *
	 * @param integer $orden
	 *
	 * @return banner
	 */
	public function getNext( $orden )
	{
	    return $this->createQuery('b')
	    ->andwhere('b.orden > ?', array( $orden ) )
	    ->orderBy('b.orden ASC')
	    ->limit(1)
	    ->fetchOne();
	}
	
}