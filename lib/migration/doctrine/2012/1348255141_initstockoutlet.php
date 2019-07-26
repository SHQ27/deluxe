<?php

class Initstockoutlet extends Doctrine_Migration_Base
{
  public function up()
  {
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      
      $data = $q->fetchAll("SELECT pi.id_producto_item, p.es_outlet FROM producto_item pi INNER JOIN producto p ON pi.id_producto = p.id_producto;");
            
      foreach( $data as $row )
      {          
          $q->execute("UPDATE stock SET es_outlet = ? WHERE id_producto_item = ?", array($row["es_outlet"], $row["id_producto_item"]) );
          $productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $row["id_producto_item"] );
          $productoItem->updateStock();
      }
  }

  public function down()
  {
  }
}
