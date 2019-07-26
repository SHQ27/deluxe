<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version551 extends Doctrine_Migration_Base
{
    public function up()
    {
        $reporte = reporteCronologicoTable::getInstance()->createQuery('r')
                    ->addSelect('r.fecha, r.id_pedido, r.venta_db_total, r.costo_envio, r.descuento, r.total_facturado, r.forma_pago, r.id_eshop')
                    ->addWhere('r.accion = ?', 'Pedido Total' )
                    ->addWhere('r.id_eshop IS NOT NULL')
                    ->fetchArray();
        
        foreach ($reporte as $row) {
            $reciboEshop = reciboEshopTable::getInstance()->insert( $row['id_eshop'], array( $row['id_pedido'] ), $row['total_facturado'], reciboEshop::TIPO_FACTURA );
                        
            $q = Doctrine_Manager::getInstance()->getCurrentConnection();
            $q->execute("UPDATE recibo_eshop set fecha = '" . $row['fecha'] . "' where id_recibo_eshop = " . $reciboEshop->getIdReciboEshop() . ";");
        }
        
        
        
    }

    public function down()
    {
        
    }
}