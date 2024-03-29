<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version633 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('eshop', 'texto_home_banners');
        $this->removeColumn('eshop', 'texto_home_productos');
        $this->addColumn('eshop', 'usa_lookbook', 'boolean', '25', array(
             'notnull' => '1',
             'default' => '0',
             ));
        $this->addColumn('eshop', 'usa_campaign', 'boolean', '25', array(
             'notnull' => '1',
             'default' => '0',
             ));
    }

    public function down()
    {
        $this->addColumn('eshop', 'texto_home_banners', 'string', '255', array(
             ));
        $this->addColumn('eshop', 'texto_home_productos', 'string', '255', array(
             ));
        $this->removeColumn('eshop', 'usa_lookbook');
        $this->removeColumn('eshop', 'usa_campaign');
    }
}