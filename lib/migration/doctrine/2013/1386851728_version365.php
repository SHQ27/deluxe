<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version365 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('imagen_banner_principal', 'tipo', 'string', '5', array(
             'fixed' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('imagen_banner_principal', 'tipo');
    }
}