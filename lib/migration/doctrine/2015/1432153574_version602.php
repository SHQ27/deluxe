<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version602 extends Doctrine_Migration_Base
{
    public function up()
    {		
		$this->dropTable('post_comentario');
		$this->dropTable('post');	
		$this->dropTable('post_categoria');
 
    }

    public function down()
    {

    }
}