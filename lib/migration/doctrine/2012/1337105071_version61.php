<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version61 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('devolucion', 'id_devolucion', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
    }

    public function down()
    {

    }
}