<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version509 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('source_inversion', 'id_eshop', 'integer', '4', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('source_inversion', 'id_eshop');
    }
}