<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version617 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('banner_principal', 'off', 'integer', '4', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('banner_principal', 'off');
    }
}