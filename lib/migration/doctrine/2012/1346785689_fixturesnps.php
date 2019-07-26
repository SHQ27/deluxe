<?php

class Fixturesnps extends Doctrine_Migration_Base
{
  public function up()
  {
      
       $bancos = array(
                'RIOP' => 'Bco. Santander Rio',
                'FNCS' => 'BBVA Bco. Francés',
                'GLCA' => 'Bco. Galicia',
                'BSTN' => 'Standard Bank',
                'RBTS' => 'HSBC',
                'SDMR' => 'Bco. Patagonia',
                'CTBK' => 'Citibank',
                'BMBS' => 'Bco. Macro',
                'TUCU' => 'Bco. del Tucumán',
                'IBAY' => 'Bco. Itaú',
                'SPRE' => 'Bco. Supervielle',
                'BCYO' => 'Bco. Reg. De Cuyo',
                'QLMS' => 'Bco. Comafi',
                'EXPR' => 'Clientes Bco. Supervielle (Ex Banex)'
            );
              
    foreach( $bancos as $id => $denominacion )
    {
      $banco = new banco();
      $banco->setIdBanco( $id );
      $banco->setDenominacion( $denominacion );
      $banco->save();
    }
    
    $productos = array
        (
            '1' => 'American Express',
            '2' => 'Diners',
            '5' => 'Mastercard',
            '8' => 'Cabal',
            '9' => 'Naranja',
            '14' => 'Visa',
            '21' => 'Nevada',
            '29' => 'Visa Naranja',
            '43' => 'Italcred',
            '48' => 'Mas',
            '49' => 'Naranja MO',
            '50' => 'Pyme Nación',
            '55' => 'Visa Débito',
            '63' => 'Nativa',
            '65' => 'Argencard',
            '72' => 'Consumax',
            '300' => 'Rapipago',
            '301' => 'Pagofacil',
            '302' => 'Bapropagos',
            '320' => 'PagoMisCuentas'
        );
    
    foreach( $productos as $id => $denominacion )
    {
        $banco = new tarjeta();
        $banco->setIdTarjeta( $id );
        $banco->setDenominacion( $denominacion );
        $banco->save();
    }
    
    
    
  }

  public function down()
  {
  }
}
