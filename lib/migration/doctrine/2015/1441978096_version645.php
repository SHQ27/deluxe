<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version645 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('eshop', 'usa_lookbook', 'boolean', '25', array(
             ));
        $this->changeColumn('eshop', 'usa_campaign', 'boolean', '25', array(
             ));
    }

    public function down()
    {

    }
}