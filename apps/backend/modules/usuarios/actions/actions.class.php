<?php

require_once dirname(__FILE__).'/../lib/usuariosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/usuariosGeneratorHelper.class.php';

/**
 * usuarios actions.
 *
 * @package    deluxebuys
 * @subpackage usuarios
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuariosActions extends autoUsuariosActions
{
	
  public function executeListView(sfWebRequest $request)
  {
  	$usuario = $this->getRoute()->getObject();
  	$this->direccionesAsociada = $usuario->getDireccionesEnvios();
  	  	
  	$limiteDevolucion = ( $usuario->getDiasDevolucion() ) ? $usuario->getDiasDevolucion() : sfConfig::get('app_devolucion_dias');
  	$this->pedidoProductoItems = pedidoProductoItemTable::getInstance()->listParaDevolucion( $usuario->getIdUsuario(), $limiteDevolucion );  	
  	$this->usuario = $usuario;
  	
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->usuario = $this->getRoute()->getObject();
    $this->form = new usuarioForm($this->usuario, array('isBackend' => true, 'eshop' => $this->usuario->getEshop() ));    
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    $this->usuario = $this->getRoute()->getObject();
    $this->form = new usuarioForm($this->usuario, array('isBackend' => true, 'eshop' => $this->usuario->getEshop() ));

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }
  
  public function executeDescargarCSV(sfWebRequest $request)
  {  	
  	set_time_limit(0);  	
  	$usuarios = $this->buildQuery()->fetchArray();
  	
  	$sexoConversor = array('h'=>'M', 'm'=>'F', ''=>'');

  	$filepath = sfConfig::get('sf_temp_dir') . '/usuarios_' . time() . '.csv';
  	$file = fopen($filepath, 'w');  	
  	foreach ($usuarios as $usuario)
  	{  		
  	    $eshop = ( $usuario["nombre_eshop"] ) ? $usuario["nombre_eshop"] : 'Deluxe Buys';  	    
  		$row = array($usuario["nombre"], $usuario["apellido"], $usuario["email"], $sexoConversor[ $usuario["sexo"] ], $usuario['compras'], $usuario['monto_compras'], $eshop);
  		fputcsv($file, $row);
  	}
  	
  	fclose($file);
  	
  	$data = file_get_contents( $filepath );
  	header("Content-type: application/octet-stream");
  	header("Content-Disposition: attachment; filename=usuarios.csv");
  	echo "Nombre,Apellido,Email,Sexo,Compras,Monto Comprado,Prendas Compradas,eShop\n" . $data;
  	
  	unlink($filepath);
  	exit;
  }
  
  public function executeReactivar(sfWebRequest $request)
  {
      $usuario = $this->getRoute()->getObject();
      $usuario->setFechaBaja(null);
      $usuario->save();
      
      $this->redirect('@usuario');
  }
  
  
  	
}
