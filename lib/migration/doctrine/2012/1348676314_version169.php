<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version169 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('reporte_cronologico', 'reporte_cronologico_id_referido_pedido_id_pedido');
        $this->dropForeignKey('reporte_cronologico', 'reporte_cronologico_id_referido_devolucion_id_devolucion');
        $this->dropForeignKey('reporte_cronologico', 'reporte_cronologico_id_referido_faltante_id_faltante');
        $this->removeIndex('reporte_cronologico', 'fk_reporte_cronologico_pedido', array(
             'fields' => 
             array(
              0 => 'id_referido',
             ),
             ));
        $this->removeIndex('reporte_cronologico', 'fk_reporte_cronologico_devolucion', array(
             'fields' => 
             array(
              0 => 'id_referido',
             ),
             ));
        $this->removeIndex('reporte_cronologico', 'fk_reporte_cronologico_faltante', array(
             'fields' => 
             array(
              0 => 'id_referido',
             ),
             ));
    }

    public function down()
    {
        $this->createForeignKey('reporte_cronologico', 'reporte_cronologico_id_referido_pedido_id_pedido', array(
             'name' => 'reporte_cronologico_id_referido_pedido_id_pedido',
             'local' => 'id_referido',
             'foreign' => 'id_pedido',
             'foreignTable' => 'pedido',
             ));
        $this->createForeignKey('reporte_cronologico', 'reporte_cronologico_id_referido_devolucion_id_devolucion', array(
             'name' => 'reporte_cronologico_id_referido_devolucion_id_devolucion',
             'local' => 'id_referido',
             'foreign' => 'id_devolucion',
             'foreignTable' => 'devolucion',
             ));
        $this->createForeignKey('reporte_cronologico', 'reporte_cronologico_id_referido_faltante_id_faltante', array(
             'name' => 'reporte_cronologico_id_referido_faltante_id_faltante',
             'local' => 'id_referido',
             'foreign' => 'id_faltante',
             'foreignTable' => 'faltante',
             ));
        $this->addIndex('reporte_cronologico', 'fk_reporte_cronologico_pedido', array(
             'fields' => 
             array(
              0 => 'id_referido',
             ),
             ));
        $this->addIndex('reporte_cronologico', 'fk_reporte_cronologico_devolucion', array(
             'fields' => 
             array(
              0 => 'id_referido',
             ),
             ));
        $this->addIndex('reporte_cronologico', 'fk_reporte_cronologico_faltante', array(
             'fields' => 
             array(
              0 => 'id_referido',
             ),
             ));
    }
}