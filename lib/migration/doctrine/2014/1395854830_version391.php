<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version391 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('fallado', 'fecha', 'timestamp', '25', array(
             'notnull' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('fallado', 'fecha');
    }
}