<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version559 extends Doctrine_Migration_Base
{
    public function up()
    {
        
        $this->addColumn('eshop', 'soporte_email', 'string', '255', array());
        $this->addColumn('eshop', 'soporte_pass', 'string', '255', array());
    }

    public function down()
    {
        $this->removeColumn('eshop', 'soporte_email');
        $this->removeColumn('eshop', 'soporte_pass');
    }
}