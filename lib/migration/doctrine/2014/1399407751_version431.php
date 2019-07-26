<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version431 extends Doctrine_Migration_Base
{
    public function up()
    {
    	
    	$data = campanaTable::getInstance()->createQuery('c')
							       ->select('pc.id_producto, c.id_campana')
							       ->innerJoin('c.productoCampana pc')
							       ->addWhere('date(c.fecha_fin) >= ?', date('Y-m-d'))
							       ->execute( array(), Doctrine::HYDRATE_SCALAR );
    	
    	$ids = array();
    	foreach ($data as $row)
    	{
    		$ids[] = $row['pc_id_producto'];
    	}
    	    	
    	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
    	$response = $q->execute("UPDATE producto SET activo = false where id_producto NOT IN (" . implode(',', $ids) . ");");
    }

    public function down()
    {

    }
}