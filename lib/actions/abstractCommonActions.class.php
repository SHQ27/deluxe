<?php

/**
 * common actions.
 *
 * @package    deluxebuys
 * @subpackage common
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class abstractCommonActions extends deluxebuysActions
{

 /**
  * Llamada Ajax para obtener todas las provincias
  *
  * @param sfRequest $request A request object
  */
  public function executeListProvincias(sfWebRequest $request)
  {   
    $provincias = provinciaTable::getInstance()->listAll();
    
    $data = array();
    foreach($provincias as $provincia)
    {
      $row['idProvincia'] = $provincia->getIdProvincia();
      $row['nombre'] = $provincia->getNombre();
      $data[] = $row;
    }
    
    echo json_encode($data);
    return sfView::NONE;
  }


 /**
  * Llamada Ajax para cotizar un envio a domicilio
  *
  * @param sfRequest $request A request object
  */
  public function executeCotizarDOM(sfWebRequest $request)
  {   
    $codigoPostal = $request->getParameter('codigoPostal');
    $idProvincia = $request->getParameter('idProvincia');
    
    $session = sessionTable::getInstance()->getSession();
    $pesoTotalCarrito = carritoProductoItemTable::getInstance()->getPesoByIdSesion( $session->getIdSession() );

    $eshop = eshopTable::getInstance()->getCurrent();
    $idEshop = ( $eshop ) ?  $eshop->getIdEshop() : null;

    $cotizaciones = EnvioPack::getInstance( $idEshop )->cotizarPrecioDOM($codigoPostal, $idProvincia, $pesoTotalCarrito);

    $campana = campanaTable::getInstance()->getCampanaEnCarrito( $session->getIdSession() );
    $montoFreeShipping = configuracionTable::getInstance()->montoFreeShipping( $eshop, $campana );
    $montoProductos = sessionTable::getInstance()->getMontoProductos( $session->getIdSession() );

    if ( $montoProductos >= $montoFreeShipping ) {
      
      $c = count($cotizaciones);
      for ( $i = 0 ; $i < $c ; $i++ ) {
        if ( $cotizaciones[$i]['servicio'] === 'P' ) {
          unset($cotizaciones[$i]);
        } else {
          $cotizaciones[$i]['valor'] = 0;  
        }   
      }

      $cotizaciones = array_values($cotizaciones);
    }

    echo json_encode($cotizaciones);
    return sfView::NONE;
  }


 /**
  * Llamada Ajax para cotizar un envio a sucursal
  *
  * @param sfRequest $request A request object
  */
  public function executeCotizarSUC(sfWebRequest $request)
  {   
    $codigoPostal = $request->getParameter('codigoPostal');
    $correo = $request->getParameter('correo');
    
    $session = sessionTable::getInstance()->getSession();
    $pesoTotalCarrito = carritoProductoItemTable::getInstance()->getPesoByIdSesion( $session->getIdSession() );

    $eshop = eshopTable::getInstance()->getCurrent();
    $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;

    $cotizaciones = EnvioPack::getInstance( $idEshop )->cotizarPrecioSUC($codigoPostal, $correo, $pesoTotalCarrito);

    $campana = campanaTable::getInstance()->getCampanaEnCarrito( $session->getIdSession() );
    $montoFreeShipping = configuracionTable::getInstance()->montoFreeShipping( $eshop, $campana );
    $montoProductos = sessionTable::getInstance()->getMontoProductos( $session->getIdSession() );

    if ( $montoProductos >= $montoFreeShipping ) {
      
      $c = count($cotizaciones);
      for ( $i = 0 ; $i < $c ; $i++ ) {
        $cotizaciones[$i]['valor'] = 0;
      }
    }

    echo json_encode($cotizaciones);
    return sfView::NONE;
  }


 /**
  * Llamada Ajax para cotizar una devolucion
  *
  * @param sfRequest $request A request object
  */
  public function executeCotizarRET(sfWebRequest $request)
  {   
    $codigoPostal = $request->getParameter('codigoPostal');
    $peso = $request->getParameter('peso');
  
    $eshop = eshopTable::getInstance()->getCurrent();
    $idEshop = ( $eshop ) ?  $eshop->getIdEshop() : null;
    
    $correo = EnvioPack::getInstance( $idEshop )->getCorreoParaDevolucion( $idEshop, $codigoPostal );
    $valor = EnvioPack::getInstance( $idEshop )->costoCorreo($correo, 'urbano', $peso, 'DOM', 'R');  

    echo $valor;
    return sfView::NONE;
  }

 /**
  * Llamada Ajax que devuelve el listado de localidades para una provincia.
  *
  * @param sfRequest $request A request object
  */
  public function executeLocalidades(sfWebRequest $request)
  {   
    $idProvincia = $request->getParameter('idProvincia');

    $provincia = provinciaTable::getInstance()->getById($idProvincia);

    $eshop = eshopTable::getInstance()->getCurrent();
    $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;

    $localidades = EnvioPack::getInstance( $idEshop )->localidades( $provincia->getIso() );

    echo json_encode($localidades);
    return sfView::NONE;
  }

 /**
  * Llamada Ajax que devuelve el listado de sucursales para una localidad.
  *
  * @param sfRequest $request A request object
  */
  public function executeSucursales(sfWebRequest $request)
  {   
    $idLocalidad = $request->getParameter('idLocalidad');

    $eshop = eshopTable::getInstance()->getCurrent();
    $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;

    $sucursales = EnvioPack::getInstance( $idEshop )->sucursales( $idLocalidad );

    echo json_encode($sucursales);
    return sfView::NONE;
  }

 /**
  * Llamada Ajax que devuelve la informacion de una sucursal
  *
  * @param sfRequest $request A request object
  */
  public function executeSucursal(sfWebRequest $request)
  {   
    $idSucursal = $request->getParameter('idSucursal');

    $eshop = eshopTable::getInstance()->getCurrent();
    $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;

    $sucursal = EnvioPack::getInstance( $idEshop )->sucursal( $idSucursal );

    echo json_encode($sucursal);
    return sfView::NONE;
  }


  
   /**
  * Arma el sitemap.xml
  *
  * @param sfRequest $request A request object
  */
  public function executeSitemapXml(sfWebRequest $request)
  {
      set_time_limit(0);
      
	  $this->setLayout(false);  
	  $this->getResponse()->setContentType('text/xml');
	  
	  $this->productos = productoTable::getInstance()->listActivos();
	  
	  $this->productoCategorias = productoCategoriaTable::getInstance()->listActivas();
	  	  	  
	  $this->campanas = campanaTable::getInstance()->listVigentes();
	  
	  // Url Estaticas
	  $estaticas[] = 'ofertas_listado';
	  $estaticas[] = 'homepage';
	  $estaticas[] = 'consultas';
	  $estaticas[] = 'usuario';
	  $estaticas[] = 'producto_outlet';
	  $estaticas[] = 'consultas_como_comprar';
	  $estaticas[] = 'tyc';
	  	  
	  $this->estaticas = $estaticas;
	  
	  
  }  
  
  public function executeTyc(sfWebRequest $request)
  {
      $this->eshop = eshopTable::getInstance()->getCurrent();
  }
  
  public function executeLegales(sfWebRequest $request)
  {
      $promo = $request->getParameter('promo');
      $this->setTemplate( 'legales' . $promo);
  }
  
  public function executeXmlVorcu(sfWebRequest $request)
  {
	$this->setLayout(false);  
	$this->getResponse()->setContentType('text/xml');
	
  	$filePath =  sfConfig::get('sf_temp_dir') . '/vorcu.xml';
  	$this->xml = file_get_contents($filePath);
  }
  
  public function executeXmlFacebook(sfWebRequest $request)
  {
      $this->setLayout(false);
      $this->getResponse()->setContentType('text/xml');
  
      $eshop = eshopTable::getInstance()->getCurrent();
      if ( $eshop ) {
        $filePath =  sfConfig::get('sf_temp_dir') . '/facebook_' . $eshop->getIdEshop() . '.xml';  
      } else {
        $filePath =  sfConfig::get('sf_temp_dir') . '/facebook.xml';  
      }
      
      echo file_get_contents($filePath);
      exit;
  }

  public function executeCsvAdwords(sfWebRequest $request)
  {
      $this->setLayout(false);
      $this->getResponse()->setContentType('text/csv');
  
      $filePath =  sfConfig::get('sf_temp_dir') . '/adwords.csv';
      $this->xml = file_get_contents($filePath);
  }

}


