<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version481 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('eshop', 'texto_home');
        $this->addColumn('eshop_banner_principal', 'texto', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->addColumn('eshop', 'texto_home', 'string', '255', array(
             ));
        $this->removeColumn('eshop_banner_principal', 'texto');
    }
}