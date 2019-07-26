<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version449 extends Doctrine_Migration_Base
{
    public function up()
    {
        $faltantes = faltanteTable::getInstance()->findAll();
        
        foreach( $faltantes as $faltante )
        {           
            if ( $faltante->getFechaProcesado() )
            {
                $faltante->setMontoDevuelto( $faltante->getMontoADevolver() );
                $faltante->save();
            }
        }
    }

    public function down()
    {

    }
}