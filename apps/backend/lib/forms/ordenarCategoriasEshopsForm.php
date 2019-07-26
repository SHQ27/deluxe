<?php

class ordenarCategoriasEshopsForm extends sfFormSymfony
{
  	public function configure()
  	{  	      	      	      	    
      $this->setWidget('data', new sfWidgetFormInputHidden() );
      $this->setValidator('data', new sfValidatorPass() );
        
  		$this->getWidgetSchema()->setNameFormat('ordenarCategoriasEshops[%s]');
  	}

  	
    public function save()
    {
      $idEshop = $this->getOption('idEshop');

      $data = $this->getValue('data');
      $data = json_decode($data, true);


      $conn = Doctrine_Manager::connection();
  
      try
      {
        $conn->beginTransaction();

        productoCategoriaEshopTable::getInstance()->deleteByIdEshop( $idEshop );

        foreach ($data['prendas'] as $idProductoCategoria => $orden) {
            $this->addOrden(
              $idEshop,
              productoCategoriaEshop::TIPO_PRENDA_PRENDA,
              $idProductoCategoria,
              $orden
            );
        }

        foreach ($data['accesorios'] as $idProductoCategoria => $orden) {
            $this->addOrden(
              $idEshop,
              productoCategoriaEshop::TIPO_PRENDA_ACCESORIO,
              $idProductoCategoria,
              $orden
            );
        }

        $conn->commit();
        
        cacheHelper::getInstance()->deleteByPrefix('productoCategoria_listByIdProductoGenero');
        cacheHelper::getInstance()->deleteByPrefix('productoCategoriaEshop_getByCompoundKey_' . $idEshop);
      }
      catch(Doctrine_Exception $e)
      {       
        echo $e;
        $conn->rollback();
        exit;
      }

    }

    protected function addOrden($idEshop, $tipoPrenda, $idProductoCategoria, $orden ) {

      $productoCategoriaEshop = new productoCategoriaEshop();
      $productoCategoriaEshop->setIdProductoCategoria( $idProductoCategoria );
      $productoCategoriaEshop->setIdEshop( $idEshop );
      $productoCategoriaEshop->setTipoPrenda( $tipoPrenda );
      $productoCategoriaEshop->setOrden( $orden );
      $productoCategoriaEshop->save();

    }
}