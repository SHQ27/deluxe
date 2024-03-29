<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version187 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('pedido', 'pibi');
    }
    
    public function down()
    {
        $this->createForeignKey('pedido', 'pibi', array(
                'name' => 'pibi',
                'local' => 'id_bonificacion_baja_fuera_plazo',
                'foreign' => 'id_bonificacion',
                'foreignTable' => 'bonificacion',
        ));
    }

}