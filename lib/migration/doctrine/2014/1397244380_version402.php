<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version402 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('producto_sticker', 'slug', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('producto_sticker', 'slug');
    }
}