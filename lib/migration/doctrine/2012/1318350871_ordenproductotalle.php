<?php

class Ordenproductotalle extends Doctrine_Migration_Base
{
  public function up()
  {
  	$res = Doctrine_Query::create()->update('productoTalle')->set('orden', 'id_producto_talle')->execute();
  	
  }

  public function down()
  {
  }
}
