<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version644 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('eshop', 'usa_lookbook', 'boolean', '25', array(
             'default' => '0',
             ));
        $this->changeColumn('eshop', 'usa_campaign', 'boolean', '25', array(
             'default' => '0',
             ));
    }

    public function down()
    {

    }
}