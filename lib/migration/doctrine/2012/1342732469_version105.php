<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version105 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('devolucion', 'id_localidad', 'integer', '4', array(
             'notnull' => '',
             ));
    }

    public function down()
    {

    }
}