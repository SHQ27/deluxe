<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version22 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('stock', 'fecha', 'timestamp', '25', array(
             'notnull' => '1',
             ));
    }

    public function down()
    {

    }
}