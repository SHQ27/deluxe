<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version630 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop_home_multimedia', 'es_video', 'boolean', '25', array(
             'default' => '0',
             ));

    }

    public function down()
    {
        $this->removeColumn('eshop_home_multimedia', 'es_video');
    }
}