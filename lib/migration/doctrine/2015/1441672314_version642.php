<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version642 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('eshop_lookbook_producto', 'id_eshop_lookbook', 'integer', '4', array(
             'notnull' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('eshop_lookbook_producto', 'id_eshop_lookbook');
    }
}