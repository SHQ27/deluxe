<?php


class talleSetZonaTable extends Doctrine_Table
{
    
    /**
     * Retorna una instancia de talleSetZonaTable;
     *
     * @return talleSetZonaTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('talleSetZona');
    }
    
    /**
     * Inserta o edita un nuevo talleSetZona
     *
     */
    public function save($idTalleSet, $idTalleZona, $idProductoTalle, $desde, $hasta, $orden)
    {                    
        $talleSetZona =  $this->createQuery('tsz')
                              ->addWhere('tsz.id_talle_set = ?', $idTalleSet)
                              ->addWhere('tsz.id_talle_zona = ?', $idTalleZona)
                              ->addWhere('tsz.id_producto_talle = ?', $idProductoTalle)
                              ->fetchOne();
    
                
        if (!$talleSetZona)
        {
              $talleSetZona = new talleSetZona();
              $talleSetZona->setIdTalleSet( $idTalleSet );
              $talleSetZona->setIdTalleZona( $idTalleZona );
              $talleSetZona->setIdProductoTalle( $idProductoTalle );
        }
        
        $talleSetZona->setDesde( $desde );
        $talleSetZona->setHasta( $hasta );
        $talleSetZona->setOrden( $orden );
        $talleSetZona->save();
        
        return $talleSetZona->getIdTalleSetZona();
    }
    
    /**
     * Lista todas los valores para un $idTalleSet
     *
     * @param integer $idTalleSet
	 * 
	 * @return Doctrine_Collection
     */
    public function listByIdTalleSet($idTalleSet)
    {
        return   $this->createQuery('tsz')
                        ->innerJoin('tsz.talleZona tz')
                        ->innerJoin('tsz.productoTalle pt')
                        ->addWhere('tsz.id_talle_set = ?', $idTalleSet)
                        ->orderBy('tz.orden, tsz.orden')
                        ->execute();
    }
    
    /**
     * Elimina todos los valores para un $idTalleSet
     *
     * @param integer $idTalleSet
     */
    public function deleteByIdTalleSet($idTalleSet)
    {
        $this->createQuery('tsz')
             ->addWhere('tsz.id_talle_set = ?', $idTalleSet)
             ->delete()
             ->execute();
    }
    
    public function deleteByIdsTalleSetZona($idsTalleSetZona)
    {
        // Si no se pasa ningun array no borra nada
        if (!count($idsTalleSetZona)) return null; 
        
        $this->createQuery('tsz')
             ->WhereIn('tsz.id_talle_set_zona', $idsTalleSetZona)
             ->delete()
             ->execute();
    }
    
    /**
     * Retorna la estructura de probador Default para Mujer
     *
     * @return Doctrine_Collection
     */
    public function getDefaultMUJ()
    {
        $talleSetZonas =  new Doctrine_Collection('talleSetZona');
               
        $talleZonaBusto = talleZonaTable::getInstance()->getById(1);
        $talleZonaCintura = talleZonaTable::getInstance()->getById(2);
        $talleZonaCadera = talleZonaTable::getInstance()->getById(3);
        $talleZonaPecho = talleZonaTable::getInstance()->getById(4);

        // 38 / XS   |   BUSTO 82-86   |   CINTURA 60-64   |   CADERA 86-90        
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-1');
        $productoTalle->setDenominacion('38 / XS');       
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(82);
        $talleSetZona->setHasta(86);
        $talleSetZona->setOrden(1);
        $talleSetZona->setTalleZona( $talleZonaBusto );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaBusto->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(60);
        $talleSetZona->setHasta(64);
        $talleSetZona->setOrden(1);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(86);
        $talleSetZona->setHasta(90);
        $talleSetZona->setOrden(1);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        
        
        // 40 / S   |   BUSTO 87-90   |   CINTURA 65-68   |   CADERA 91-94
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-2');
        $productoTalle->setDenominacion('40 / S');
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(87);
        $talleSetZona->setHasta(90);
        $talleSetZona->setOrden(2);
        $talleSetZona->setTalleZona( $talleZonaBusto );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaBusto->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(65);
        $talleSetZona->setHasta(68);
        $talleSetZona->setOrden(2);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(91);
        $talleSetZona->setHasta(94);
        $talleSetZona->setOrden(2);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        
        // 42 / M   |   BUSTO 91-94   |   CINTURA 69-72   |   CADERA 95-98
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-3');
        $productoTalle->setDenominacion('42 / M');
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(91);
        $talleSetZona->setHasta(94);
        $talleSetZona->setOrden(3);
        $talleSetZona->setTalleZona( $talleZonaBusto );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaBusto->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(69);
        $talleSetZona->setHasta(72);
        $talleSetZona->setOrden(3);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(95);
        $talleSetZona->setHasta(98);
        $talleSetZona->setOrden(3);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        

        // 44 / L   |   BUSTO 95-98   |   CINTURA 73-76   |   CADERA 99-102
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-4');
        $productoTalle->setDenominacion('44 / L');
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(95);
        $talleSetZona->setHasta(98);
        $talleSetZona->setOrden(4);
        $talleSetZona->setTalleZona( $talleZonaBusto );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaBusto->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(73);
        $talleSetZona->setHasta(76);
        $talleSetZona->setOrden(4);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(99);
        $talleSetZona->setHasta(102);
        $talleSetZona->setOrden(4);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        
        // 46 / XL   |   BUSTO 99-102   |   CINTURA 77-80   |   CADERA 103-106        
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-5');
        $productoTalle->setDenominacion('46 / XL');
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(99);
        $talleSetZona->setHasta(102);
        $talleSetZona->setOrden(5);
        $talleSetZona->setTalleZona( $talleZonaBusto );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaBusto->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(77);
        $talleSetZona->setHasta(80);
        $talleSetZona->setOrden(5);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(103);
        $talleSetZona->setHasta(106);
        $talleSetZona->setOrden(5);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
        
        return $talleSetZonas;        
    }
    
    /**
     * Retorna la estructura de probador Default para Hombre
     *
     * @return Doctrine_Collection
     */
    public function getDefaultHOM()
    {
        $talleSetZonas =  new Doctrine_Collection('talleSetZona');
         
        $talleZonaCintura = talleZonaTable::getInstance()->getById(2);
        $talleZonaCadera = talleZonaTable::getInstance()->getById(3);
        $talleZonaPecho = talleZonaTable::getInstance()->getById(4);
    
        
        // S   |   PECHO 89-96   |   CINTURA 73-80   |   CADERA 89-96
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-1');
        $productoTalle->setDenominacion('S');
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(86);
        $talleSetZona->setHasta(96);
        $talleSetZona->setOrden(1);
        $talleSetZona->setTalleZona( $talleZonaPecho );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaPecho->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(73);
        $talleSetZona->setHasta(80);
        $talleSetZona->setOrden(1);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(86);
        $talleSetZona->setHasta(96);
        $talleSetZona->setOrden(1);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
    
    
        // M   |   PECHO 97-103   |   CINTURA 81-87   |   CADERA 97-103
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-2');
        $productoTalle->setDenominacion('M');
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(97);
        $talleSetZona->setHasta(103);
        $talleSetZona->setOrden(2);
        $talleSetZona->setTalleZona( $talleZonaPecho );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaPecho->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(91);
        $talleSetZona->setHasta(87);
        $talleSetZona->setOrden(2);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(97);
        $talleSetZona->setHasta(103);
        $talleSetZona->setOrden(2);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
    
        // L   |   PECHO 104-111   |   CINTURA 88-95   |   CADERA 104-111
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-3');
        $productoTalle->setDenominacion('L');
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(104);
        $talleSetZona->setHasta(11);
        $talleSetZona->setOrden(3);
        $talleSetZona->setTalleZona( $talleZonaPecho );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaPecho->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(88);
        $talleSetZona->setHasta(85);
        $talleSetZona->setOrden(3);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(104);
        $talleSetZona->setHasta(111);
        $talleSetZona->setOrden(3);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
    
    
        // XL   |   PECHO 112-122   |   CINTURA 99-106   |   CADERA 112-122
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-4');
        $productoTalle->setDenominacion('XL');
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(112);
        $talleSetZona->setHasta(122);
        $talleSetZona->setOrden(4);
        $talleSetZona->setTalleZona( $talleZonaPecho );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaPecho->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(99);
        $talleSetZona->setHasta(106);
        $talleSetZona->setOrden(4);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(112);
        $talleSetZona->setHasta(122);
        $talleSetZona->setOrden(4);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
    
        // XXL   |   PECHO 123-135   |   CINTURA 107-119   |   CADERA 123-135
        $productoTalle = new productoTalle();
        $productoTalle->setIdProductoTalle('DEFAULT-5');
        $productoTalle->setDenominacion('XXL');
         
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(123);
        $talleSetZona->setHasta(135);
        $talleSetZona->setOrden(5);
        $talleSetZona->setTalleZona( $talleZonaPecho );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaPecho->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(107);
        $talleSetZona->setHasta(119);
        $talleSetZona->setOrden(5);
        $talleSetZona->setTalleZona( $talleZonaCintura );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCintura->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        $talleSetZona = new talleSetZona();
        $talleSetZona->setDesde(123);
        $talleSetZona->setHasta(135);
        $talleSetZona->setOrden(5);
        $talleSetZona->setTalleZona( $talleZonaCadera );
        $talleSetZona->setProductoTalle( $productoTalle );
        $talleSetZona->setIdTalleZona( $talleZonaCadera->getIdTalleZona() );
        $talleSetZona->setIdProductoTalle( $productoTalle->getIdProductoTalle() );
        $talleSetZonas->add($talleSetZona);
    
        return $talleSetZonas;
    }
    
}