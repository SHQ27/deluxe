<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version111 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('devolucion_stock_programada', 'id_devolucion', 'integer', '4', array(
             'notnull' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('devolucion_stock_programada', 'id_devolucion');
    }
}