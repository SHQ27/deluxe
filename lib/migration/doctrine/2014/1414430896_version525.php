<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version525 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop', 'link_color', 'char', '7', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('eshop', 'link_color');
    }
}