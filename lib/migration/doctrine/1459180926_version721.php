<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version721 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('provincia', 'provincia_id_pais_pais_id_pais');
        $this->dropForeignKey('usuario', 'usuario_id_pais_pais_id_pais');

        $this->removeIndex('provincia', 'fk_provincia_pais1', array(
             'fields' => 
             array(
              0 => 'id_pais',
             ),
             ));
        $this->removeIndex('usuario', 'fk_usuario_pais1', array(
             'fields' => 
             array(
              0 => 'id_pais',
             ),
             ));
    }

    public function down()
    {

    }
}