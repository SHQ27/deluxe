<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version286 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('promo_permanente', 'activo', 'boolean', '25', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('promo_permanente', 'activo');
    }
}