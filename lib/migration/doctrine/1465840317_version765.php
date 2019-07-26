<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version765 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('reporte_cronologico', 'cliente_tipo_documento', 'string', '255', array());
        $this->addColumn('reporte_cronologico', 'cliente_documento', 'string', '255', array());
        $this->addColumn('reporte_cronologico', 'cliente_email', 'string', '255', array());
    }

    public function down()
    {
        $this->removeColumn('reporte_cronologico', 'cliente_tipo_documento');
        $this->removeColumn('reporte_cronologico', 'cliente_documento');
        $this->removeColumn('reporte_cronologico', 'cliente_email');
    }
}