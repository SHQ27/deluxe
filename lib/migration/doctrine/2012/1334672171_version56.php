<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version56 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('valor_interno', 'id_valor_interno', 'string', '20', array(
             'primary' => '1',
             ));
    }

    public function down()
    {
        $this->changeColumn('valor_interno', 'id_valor_interno', 'integer', '4', array(
             'primary' => '1',
             ));
    }
}