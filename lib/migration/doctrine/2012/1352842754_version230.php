<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version230 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('provincia', 'id_oca', 'string', '100', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('provincia', 'id_oca');
    }
}