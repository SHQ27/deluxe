<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version398 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('producto', 'sticker');
    }

    public function down()
    {
        $this->addColumn('producto', 'sticker', 'char', '6', array(
        ));
    }
}