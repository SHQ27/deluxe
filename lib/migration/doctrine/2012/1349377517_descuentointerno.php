<?php

class Descuentointerno extends Doctrine_Migration_Base
{
  public function up()
  {
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $q->execute("UPDATE descuento SET es_interno = true WHERE codigo = 'goodtimes'");
      $q->execute("UPDATE reporte_cronologico SET descuento_codigo = 'INTERNO' WHERE descuento_codigo = 'goodtimes'");
  }

  public function down()
  {
  }
}
