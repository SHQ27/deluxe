<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version611 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('promo_pago', 'cuotas', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('promo_pago', 'cuotas');
    }
}