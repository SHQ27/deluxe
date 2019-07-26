<?php

class Sucursalesocadireccion extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
  	$q->execute("update sucursal_oca set calle = direccion");
  	
  	$sucursales = sucursalOcaTable::getInstance()->listActivas();
  	foreach ($sucursales as $sucursal)
  	{

  		$pos = strrpos($sucursal->getCalle(), ' ');
  		$calle  = substr($sucursal->getCalle(), 0, $pos);
  		$numero = substr($sucursal->getCalle(), $pos+1);  		
  		
  		$sucursal->setCalle( $calle );
  		$sucursal->setNumero( $numero );
  		$sucursal->save();
  	}
  	
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('ADG');
  	$sucursal->setCalle( 'Boulevard Bs. As.' );
  	$sucursal->setNumero( '1459' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('PCH');
  	$sucursal->setCalle( 'Hipolito Yrigoyen' );
  	$sucursal->setNumero( '1607' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('CI5');
  	$sucursal->setCalle( 'José Hernández' );
  	$sucursal->setNumero( '2379' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('SMN');
  	$sucursal->setCalle( 'CALLE 89 Nro. - San Martín' );
  	$sucursal->setNumero( '2271' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('PRS');
  	$sucursal->setCalle( 'Rivadavia (Calle 16) y Superio' );
  	$sucursal->setNumero( '0' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('RS1');
  	$sucursal->setCalle( 'OLIVER' );
  	$sucursal->setNumero( '407' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('TTG');
  	$sucursal->setCalle( 'Paraguay y Guemes' );
  	$sucursal->setNumero( '0' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('UAQ');
  	$sucursal->setCalle( 'Mendoza' );
  	$sucursal->setNumero( '2778' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('VCP');
  	$sucursal->setCalle( 'Cassaffhousth' );
  	$sucursal->setNumero( '91' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('VTO');
  	$sucursal->setCalle( '12 de Octubre' );
  	$sucursal->setNumero( '806' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('BCE');
  	$sucursal->setCalle( 'Calle 21' );
  	$sucursal->setNumero( '734' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('DES');
  	$sucursal->setCalle( 'calle 27' );
  	$sucursal->setNumero( '417' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('NEC');
  	$sucursal->setCalle( 'Calle 64' );
  	$sucursal->setNumero( '3164' );
  	$sucursal->save();
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('PNM');
  	$sucursal->setCalle( 'Bunge' );
  	$sucursal->setNumero( '1596' );
  	$sucursal->save();
  	
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('PUN');
  	$sucursal->setCalle( 'Urquiza' );
  	$sucursal->setNumero( '401' );
  	$sucursal->save();
  	
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('LPG');
  	$sucursal->setCalle( 'Diagonal 74' );
  	$sucursal->setNumero( '1047' );
  	$sucursal->save();
  	
  	
  	$sucursal = sucursalOcaTable::getInstance()->getByCodigo('OYO');
  	$sucursal->setCalle( 'Av. San Martín' );
  	$sucursal->setNumero( '375' );
  	$sucursal->save();
  }

  public function down()
  {
  }
}
