<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version359 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('promo_permanente', 'texto_promocion', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('promo_permanente', 'texto_promocion');
    }
}