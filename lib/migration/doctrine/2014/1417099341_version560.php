<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version560 extends Doctrine_Migration_Base
{
    public function up()
    {
        $eshop = eshopTable::getInstance()->findOneByIdEshop(2);
        $eshop->setMlClientId('3811360003615813');
        $eshop->setMlClientSecret('JrFwtZzh6L0ZKnkRiepF4KDpq1tIHCNK');
        $eshop->save();
        
        $usuario = usuarioTable::getInstance()->findOneByIdUsuario( 124429 );
        $dataUsuario = $usuario->getData();
        
        
        $usuario = new usuario();
        $usuario->fromArray( $dataUsuario );
        $usuario->setIdUsuario( null );
        $usuario->setIdEshop( 2 );
        $usuario->save();
        
        $eshop = eshopTable::getInstance()->findOneByIdEshop(2);
        $eshop->setMlIdUsuarioInterno( $usuario->getIdUsuario() );
        $eshop->save();
        
        $usuario = new usuario();
        $usuario->fromArray( $dataUsuario );
        $usuario->setIdUsuario( null );
        $usuario->setIdEshop( 3 );
        $usuario->save();
        
        $eshop = eshopTable::getInstance()->findOneByIdEshop(3);
        $eshop->setMlClientId('7885201734850020');
        $eshop->setMlClientSecret('i1HhHk3Dl3jhRzhNIOaHFVOsbMc8boGW');
        $eshop->setMlIdUsuarioInterno( $usuario->getIdUsuario() );
        $eshop->save();        
    }

    public function down()
    {
    }
}