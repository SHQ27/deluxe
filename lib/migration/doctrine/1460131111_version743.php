<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version743 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop_lookbook', 'texto', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('eshop_lookbook', 'texto');
    }
}