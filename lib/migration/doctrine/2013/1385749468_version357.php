<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version357 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('banner_principal', 'destacar', 'integer', '1', array(
             'default' => '5',
             ));
        $this->changeColumn('campana', 'destacar', 'integer', '1', array(
             'default' => '5',
             ));
        $this->changeColumn('promo_permanente', 'destacar', 'integer', '1', array(
             'default' => '5',
             ));
    }

    public function down()
    {
        $this->removeColumn('banner_principal', 'destacar');
    }
}