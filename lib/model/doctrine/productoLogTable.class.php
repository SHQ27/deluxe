<?php


class productoLogTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de productoLogTable;
     *
     * @return productoLogTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoLog');
    }
    
    public function generate($idProducto, $observacion)
    {
        $productoLog = new productoLog();
        $productoLog->setIdProducto($idProducto);
        $productoLog->setObservacion($observacion);
        $productoLog->save();
    }

    /**
    * Elimina todos los productoLogs asociados a un producto
    * 
    * @param integer $idProducto
    * 
    */
    public function deleteByIdProducto( $idProducto )
    {
        $this->createQuery('pl')
                    ->delete()
                    ->addWhere('pl.id_producto= ?', array( $idProducto ) )
                    ->execute();
    }
    
}