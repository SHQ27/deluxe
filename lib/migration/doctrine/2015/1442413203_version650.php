<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version650 extends Doctrine_Migration_Base
{
    public function up()
    {


        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("update eshop set acerca_titulo = 'About';");

        $eshop = eshopTable::getInstance()->findOneByIdEshop(6);
        $eshop->setAcercaTitulo('KMK');
        $eshop->save();

        $eshop = new eshop();
        $eshop->setDenominacion('Asterisco');
        $eshop->setDominio('eshop.asterisco.pm');
        $eshop->setIdMarca(213);
        $eshop->setIdProductoGenero(productoGenero::MUJER);
        $eshop->setAcercaTitulo('About');
        $eshop->setAcercaTextoPrincipal('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $eshop->setAcercaTextoSecundario('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $eshop->setLinkColor('#000000');
        $eshop->save();

        $eshop = new eshop();
        $eshop->setDenominacion('Sal Si Puedes');
        $eshop->setDominio('eshop.salsipuedes.pm');
        $eshop->setIdMarca(534);
        $eshop->setIdProductoGenero(productoGenero::MUJER);
        $eshop->setAcercaTitulo('About');
        $eshop->setAcercaTextoPrincipal('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $eshop->setAcercaTextoSecundario('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $eshop->setLinkColor('#000000');
        $eshop->save();

        $eshop = new eshop();
        $eshop->setDenominacion('Felix');
        $eshop->setDominio('eshop.felix.pm');
        $eshop->setIdMarca(255);
        $eshop->setIdProductoGenero(productoGenero::HOMBRE);
        $eshop->setAcercaTitulo('About');
        $eshop->setAcercaTextoPrincipal('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $eshop->setAcercaTextoSecundario('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $eshop->setLinkColor('#000000');
        $eshop->save();
    }

    public function down()
    {

    }
}