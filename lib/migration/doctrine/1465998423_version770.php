<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version770 extends Doctrine_Migration_Base
{
    public function up()
    {
    	$this->addColumn('eshop', 'tags', 'clob', '65535', array());
    }

    public function down()
    {
        
    }
}