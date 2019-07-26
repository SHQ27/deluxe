<?php


function make_producto_listado_url($idMarcas, $method = null, $value  = null)
{
	$request = sfContext::getInstance()->getRequest();
		
	$urlParams = array();

	if ($method == 'ADD_MARCA')
	{
		$idMarcas[] = $value;
	}
	
	if ( $method == 'REMOVE_MARCA' )
  	{
  		$key = array_search($value, $idMarcas);
		unset($idMarcas[$key]);
  	}
	
  	if ($idMarcas) $urlParams['marcas'] = implode(',', $idMarcas);
	  	
  	$urlParams['orden'] = ($method == 'ORDER_BY')? $value : $request->getParameter('orden', 'MAS_VENDIDOS');
  	  	
  	$urlParams['page'] = ($method == 'PAGINATION')? $value : 1;
  	  	
	return $request->getPathInfo() . '?' . http_build_query($urlParams);
}

function make_marca_listado_url($page)
{	
	$request = sfContext::getInstance()->getRequest();
		
	$urlParams = array();
  	
  	$urlParams['page'] = $page;
  	  	
	return $request->getPathInfo() . '?' . http_build_query($urlParams);
}

function make_producto_busqueda_url($idMarcas, $method = null, $value  = null)
{	
	$request = sfContext::getInstance()->getRequest();
		
	$urlParams = array();
	$urlParams['q'] = $request->getParameter('q');
	
	if ($method == 'ADD_MARCA')
	{
		$idMarcas[] = $value;
	}
	
	if ( $method == 'REMOVE_MARCA' )
  	{
  		$key = array_search($value, $idMarcas);
		unset($idMarcas[$key]);
  	}
  	 	
  	if ( $method == 'GENERO' )
  	{
  		if( $value->getSlug() ) $urlParams['genero'] = $value->getSlug();
  	}
  	else 
  	{  		
	    if ( $method == 'CATEGORIA' )
	  	{
	  		$categoria = $value->getSlug();
	  		$genero = $value->getProductoGenero()->getSlug();
	  	}
	  	else 
	  	{
	  		$categoria = $request->getParameter('categoria', '');
	  		$genero = $request->getParameter('genero', '');
	  	}
	  	
	  	if ($method != 'SIN_GENERO')
	  	{
  			if($categoria) $urlParams['categoria'] = $categoria;
  			if($genero) $urlParams['genero'] = $genero;
	  	}
  	}
  	  	
  	if ($idMarcas) $urlParams['marcas'] = implode(',', $idMarcas);
  	
  	$urlParams['orden'] = ($method == 'ORDER_BY')? $value : $request->getParameter('orden', 'PRECIO_ASC');
  	
  	$rpp = explode('|', sfConfig::get('app_rpp_productos_categoria') );
  	$urlParams['rpp'] = ($method == 'RPP')? $value : $request->getParameter('rpp', $rpp[0]);
  	
  	$urlParams['pag'] = ($method == 'PAGINATION')? $value : 1;
  	
	return $request->getPathInfo() . '?' . http_build_query($urlParams);
}

function make_producto_listaTag_url($method = null, $value  = null)
{	
	$request = sfContext::getInstance()->getRequest();
		
	$urlParams = array();
	$urlParams['q'] = $request->getParameter('q');
	  	
  	$urlParams['orden'] = ($method == 'ORDER_BY')? $value : $request->getParameter('orden', 'PRECIO_ASC');
  	  	
  	$urlParams['pag'] = ($method == 'PAGINATION')? $value : 1;
  	
	return $request->getPathInfo() . '?' . http_build_query($urlParams);
}

function make_oferta_listado_url($idMarcas, $method = null, $value  = null)
{
    $request = sfContext::getInstance()->getRequest();

    $urlParams = array();

    if ($method == 'ADD_MARCA')
    {
        $idMarcas[] = $value;
    }

    if ( $method == 'REMOVE_MARCA' )
    {
        $key = array_search($value, $idMarcas);
        unset($idMarcas[$key]);
    }

    if ($idMarcas) $urlParams['marcas'] = implode(',', $idMarcas);

    $urlParams['page'] = ($method == 'PAGINATION')? $value : 1;

    return $request->getPathInfo() . '?' . http_build_query($urlParams);
}