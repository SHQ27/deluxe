<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version65 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('producto', 'es_oulet', 'boolean', '25', array(
        		'default' => '0'
             ));
    }

    public function down()
    {
        $this->removeColumn('producto', 'es_oulet');
    }
}