<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Updateproductogenerometas extends Doctrine_Migration_Base
{
    public function up()
    {
    	$hom = productoGeneroTable::getInstance()->getByIdProductoGenero('HOM');
    	$hom->setMetaTitulo('Zapatos, Ropa y Accesorios - Tienda de Moda Online para Hombre')
    		->setMetaDescripcion('DeluxeBuys te brinda lo mejor en moda y tendencia para hombres con descuento de hasta el 70%. Remeras, Camisas, Pantalones, Camperas, Cinturones, Sacos, Trajes, Underwear. Descubrí lo último en ropa en internet')
    		->setMetaTags('deluxebuys, camisa, remera, pantalon, ojotas, zapatos, zapatillas, saco, campera, bermuda, musculosa, accesorios, reef, rayban, blackfin, vans, zorzal del vaga, el burgues, garcon garcia, dufour, levis, felix, puma, adidas, nike, el cid, grupo 134, diesel, ona saez, fight for your right,  billabong, infinit, calvin klein, adidas, nike');
		$hom->save();
    	
    	$muj = productoGeneroTable::getInstance()->getByIdProductoGenero('MUJ');
    	$muj->setMetaTitulo('Zapatos, Ropa y Accesorios - Tienda de Moda Online para Mujer')
    		->setMetaDescripcion('DeluxeBuys te brinda lo mejor en moda y tendencia para mujer con descuento de hasta el 70%. Miles de vestidos, remeras, camisas, carteras, zapatos, accesorios y diseño. Descubrí lo último en ropa en internet')
    		->setMetaTags('deluxebuys, cartera, zapatos, ropa, mujer, camisas, blusas, remeras, moda, diseño, tendencia, club privado, benito fernandez, bikini, lenceria, descuento, shopping, pantalones, reef, rayban, maria lombardi, desiderata, pesqueira, garcon garcia, natalia antolin, tossone, dolores iguacel, agarrate catalina, peuque, triumph, dulce carola, admit one, punto uno, vestite y andate, cocot, anne bonny, carla danelli,vitamina, uma, holi, lupe, relojes, getien');
    	$muj->save();
    	
    	$dec = productoGeneroTable::getInstance()->getByIdProductoGenero('NIN');
    	$dec->setMetaTitulo('Decoracion - Tienda de Moda y Deco Online')
    		->setMetaDescripcion('DeluxeBuys te brinda lo mejor en diseño y tendencia para el hogar con descuento de hasta el 70%. Deco hogar, vasos, ensaladeras, vinilos, almohadones, percheros plegables, almanaques, utensilios cocina, porta documentos, alfombras, cuadros, objetos. Descubrí lo último en ropa en Internet')
    		->setMetaTags('deluxebuys, Deco, hogar, vasos, ensaladeras, vinilos, almohadones, percheros plegables, almanaques, utensilios cocina, porta documentos, alfombras, cuadros, objetos, practi-k, manifesto, kartell, marcos, relojes, organizadores, canastos, espejos');
    	$dec->save();
    }

    public function down()
    {

    }
}