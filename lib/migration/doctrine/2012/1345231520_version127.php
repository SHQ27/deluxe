<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version127 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('campana', 'campana_id_comercial_comercial_id_comercial');
        
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE campana SET id_comercial = NULL;");
        
        $this->removeColumn('campana', 'id_comercial');
        $this->removeColumn('campana', 'comision_comercial');
        $this->removeColumn('campana', 'apertura_marca');
        $this->addColumn('campana_marca', 'id_comercial', 'integer', '4', array(
             ));
        $this->addColumn('campana_marca', 'comision_comercial', 'float', '', array(
             ));
        $this->addColumn('campana_marca', 'apertura_marca', 'integer', '4', array(
             ));
    }

    public function down()
    {
        $this->createForeignKey('campana', 'campana_id_comercial_comercial_id_comercial', array(
                'name' => 'campana_id_comercial_comercial_id_comercial',
                'local' => 'id_comercial',
                'foreign' => 'id_comercial',
                'foreignTable' => 'comercial',
        ));
        
        $this->addColumn('campana', 'id_comercial', 'integer', '4', array(
             ));
        $this->addColumn('campana', 'comision_comercial', 'float', '', array(
             ));
        $this->addColumn('campana', 'apertura_marca', 'integer', '4', array(
             ));
        $this->removeColumn('campana_marca', 'id_comercial');
        $this->removeColumn('campana_marca', 'comision_comercial');
        $this->removeColumn('campana_marca', 'apertura_marca');
    }
}