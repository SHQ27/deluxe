<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version62 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('devolucion', 'id_devolucion', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('devolucion', 'cantidad', 'integer', '4', array(
             'notnull' => '1',
             ));
    }

    public function down()
    {

    }
}