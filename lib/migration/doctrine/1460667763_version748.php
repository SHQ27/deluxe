<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version748 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop', 'usa_acerca', 'boolean', '25', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('eshop', 'usa_acerca');
    }
}