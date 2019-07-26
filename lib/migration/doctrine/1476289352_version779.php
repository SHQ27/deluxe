<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version779 extends Doctrine_Migration_Base
{
    public function up()
    {
 

        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
		$data = $q->fetchAll("select p.codigo, pi.id_producto_item from producto p inner join producto_item pi on pi.id_producto = p.id_producto where p.codigo is not null;");

		$c = count($data);
		foreach ($data as $row) {
			$q->execute("update producto_item set codigo = '" . str_replace('\'', '', $row['codigo']) . "' where id_producto_item = " . $row['id_producto_item']);
			var_dump($c--);
		}
    }

    public function down()
    {
        $this->removeColumn('producto_item', 'codigo');
    }
}