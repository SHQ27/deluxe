<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version167 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('reporte_cronologico', array(
             'id_reporte_cronologico' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'fecha' => 
             array(
              'type' => 'timestamp',
              'notnull' => '1',
              'length' => '25',
             ),
             'tipo' => 
             array(
              'type' => 'string',
              'fixed' => '1',
              'notnull' => '1',
              'length' => '5',
             ),
             'id_referido' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_reporte_cronologico_pedido' => 
              array(
              'fields' => 
              array(
               0 => 'id_referido',
              ),
              ),
              'fk_reporte_cronologico_devolucion' => 
              array(
              'fields' => 
              array(
               0 => 'id_referido',
              ),
              ),
              'fk_reporte_cronologico_faltante' => 
              array(
              'fields' => 
              array(
               0 => 'id_referido',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_reporte_cronologico',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('reporte_cronologico');
    }
}