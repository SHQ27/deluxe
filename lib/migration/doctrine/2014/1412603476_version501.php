<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version501 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('newsletter', 'id_eshop', 'integer', '4', array(
        ));
    }

    public function down()
    {
        $this->removeColumn('newsletter', 'id_eshop');
    }
}