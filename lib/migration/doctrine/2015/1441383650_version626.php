<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version626 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('eshop_home_multimedia', 'src');
    }

    public function down()
    {
        $this->addColumn('eshop_home_multimedia', 'src', 'string', '255', array(
             ));
    }
}