<?php

class modificarImagenCategoriaEshopForm extends sfFormSymfony
{
  	public function configure()
  	{
      $idEshop             = $this->getOption('idEshop');
      $idProductoCategoria = $this->getOption('idProductoCategoria');

      $productoCategoriaEshop = productoCategoriaEshopTable::getInstance()->getByCompoundKey( $idEshop, $idProductoCategoria );

      // Si no existe se lo crea
      if ( !$productoCategoriaEshop ) {
        $productoCategoriaEshop = new productoCategoriaEshop();
        $productoCategoriaEshop->setIdProductoCategoria( $idProductoCategoria );
        $productoCategoriaEshop->setIdEshop( $idEshop );
        $productoCategoriaEshop->setTipoPrenda( productoCategoriaEshop::TIPO_PRENDA_PRENDA );
        $productoCategoriaEshop->setOrden(999);
        $productoCategoriaEshop->save();
      }

      // Imagen
      $this->setWidget( "imagen", new sfWidgetFormInputFileEditable(
        imageHelper::getInstance()->getOptionForWidget('eshop_banner_listado', $productoCategoriaEshop) )
      );
        
      $this->setValidator( "imagen", new sfValidatorFile (
        imageHelper::getInstance()->getOptionForValidator('eshop_banner_listado', $productoCategoriaEshop),
        imageHelper::getInstance()->getMessagesForValidator('eshop_banner_listado')
      )); 
                        
      $this->setValidator( "imagen_delete", new sfValidatorBoolean() );
        
  		$this->getWidgetSchema()->setNameFormat('modificarImagenCategoriaEshop[%s]');
  	}

  	
    public function save()
    {
      $idEshop             = $this->getOption('idEshop');
      $idProductoCategoria = $this->getOption('idProductoCategoria');

      $productoCategoriaEshop = productoCategoriaEshopTable::getInstance()->getByCompoundKey( $idEshop, $idProductoCategoria );

      $file = $this->getValue('imagen');

      unset($this->values['imagen']);

      imageHelper::getInstance()->processDeleteFile('eshop_banner_listado', $productoCategoriaEshop, $this->getValue('imagen_delete') );

      if (isset($file))
      {
         imageHelper::getInstance()->processDeleteFile('eshop_banner_listado', $productoCategoriaEshop, true);
         imageHelper::getInstance()->processSaveFile('eshop_banner_listado', $productoCategoriaEshop, $file);
      }
    }

}