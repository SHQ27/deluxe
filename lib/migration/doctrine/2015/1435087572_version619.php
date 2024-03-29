<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version619 extends Doctrine_Migration_Base
{
    public function up()
    {
        $eshop = new eshop();
        $eshop->setDenominacion('Kimeika');
        $eshop->setDominio('eshop.kimeika.pm');
        $eshop->setIdMarca(222);
        $eshop->setIdProductoGenero(productoGenero::MUJER);
        $eshop->setTextoHomeBanners('DESTACADOS');
        $eshop->setTextoHomeProductos('HOT CLOTHES');
        $eshop->setAcercaTitulo('Sobre Kimeika');
        $eshop->setAcercaTextoPrincipal('Kimeika es una marca de indumentaria femenina que nace en el año 2012 como resultado de una evolución de 8 años de trayectoria de la marca Kimmei. Esta evolución y crecimiento se plantea para un progreso y cambio estratégico de la marca a nivel diseño, calidad e imagen. el objetivo principal de este cambio se debe a un proyecto a largo plazo para posicionarse en el mercado de marcas de moda nacionales con una excelente relación entre diseño, precio y calidad. insertándose en un circuito “ready to wear” + “fast fashion”.');
        $eshop->setAcercaTextoSecundario('La nueva mujer Kimeika es joven, urbana, extrovertida y moderna. nos basamos en un target entre 17 y 25 años con espíritu libre y feliz. Dentro de sus características generales la mujer Kimeika es colorida, novedosa y femenina y esta; completamente ligada con el arte. Admite la mezcla de estilos , las combinaciones descontracturadas, las prendas claves que dan onda a un look. esta; en transición constante con aspiraciones y objetivos.');
        $eshop->setLinkColor('#000000');
        $eshop->save();

    }

    public function down()
    {
    }
}