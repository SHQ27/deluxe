<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version81 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('marca', 'email_comercial', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('marca', 'email_comercial');
    }
}