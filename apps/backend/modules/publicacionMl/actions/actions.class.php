<?php

require_once dirname(__FILE__).'/../lib/publicacionMlGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/publicacionMlGeneratorHelper.class.php';

/**
 * publicacionMl actions.
 *
 * @package    deluxebuys
 * @subpackage publicacionMl
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class publicacionMlActions extends autoPublicacionMlActions
{
    
    public function executeCerrar(sfWebRequest $request)
    {
        $idProducto = $request->getParameter('idProducto');
        $producto = productoTable::getInstance()->findOneByIdProducto( $idProducto );
        
        $ok = $producto->getPublicacionMl()->close();
        
        if ( $ok )
        {
            $this->getUser()->setFlash('notice', 'Se ha cerrado la publicación en ML del producto #' . $idProducto);
        }
        else
        {
            $this->getUser()->setFlash('error', 'Ha ocurrido un error al cerrar la publicación en ML del producto #' . $idProducto);
        }
        
        $this->redirect('@publicacion_ml');
    }
    
    public function executeEliminar(sfWebRequest $request)
    {
        $idProducto = $request->getParameter('idProducto');
        $producto = productoTable::getInstance()->findOneByIdProducto( $idProducto );
        $ok = $producto->getPublicacionMl()->delete();
        
        if ( $ok )
        {
            $this->getUser()->setFlash('notice', 'Se ha eliminado la publicacion en ML del producto #' . $idProducto);
        }
        else
        {
            $this->getUser()->setFlash('error', 'Ha ocurrido un error al eliminar la publicación en ML del producto #' . $idProducto);
        }
        
        $this->redirect('@publicacion_ml');
    }
    
    protected function executeBatchCerrar(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        
        $publicacionesMl = publicacionMlTable::getInstance()->listByIdProductos( $ids );
        
        $result = array('ok' => 0, 'ko' => 0);
        foreach ($publicacionesMl as $publicacionMl)
        {
            $ok = $publicacionMl->close();
            ( $ok ) ? $result['ok']++ : $result['ko']++;
        }
    
        if ( $result['ko'] == 0 )
        {
            $this->getUser()->setFlash('notice', 'Se cerraron correctamente todos las publicaciones en ML de los productos seleccionados.');
        }
        else
        {            
            $this->getUser()->setFlash('error', 'El proceso finalizo con algunos errores. ' . $result['ok'] . ' ' . ngettext("publicación", "publicaciones", $result['ok']) . ' se ' . ngettext("cerró", "cerraron", $result['ok']) . ' correctamente. / ' . $result['ko'] . ' ' . ngettext("publicación", "publicaciones", $result['ko']) . ' ' . ngettext("falló", "fallaron", $result['ko']) . ' al intentar ' . ngettext("cerrarla", "cerrarlas", $result['ko']) . '.');
        }            
        
        $this->redirect('@publicacion_ml');
    }
    
    protected function executeBatchEliminar(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        
        $publicacionesMl = publicacionMlTable::getInstance()->listByIdProductos( $ids );
        
        $result = array('ok' => 0, 'ko' => 0);
        foreach ($publicacionesMl as $publicacionMl)
        {
            $ok = $publicacionMl->delete();
            ( $ok ) ? $result['ok']++ : $result['ko']++;
        }

        if ( $result['ko'] == 0 )
        {
            $this->getUser()->setFlash('notice', 'Se eliminaron correctamente todos las publicaciones en ML de los productos seleccionados.');
        }
        else
        {
            $this->getUser()->setFlash('error', 'El proceso finalizo con algunos errores. ' . $result['ok'] . ' ' . ngettext("publicación", "publicaciones", $result['ok']) . ' se ' . ngettext("eliminó", "eliminaron", $result['ok']) . ' correctamente. / ' . $result['ko'] . ' ' . ngettext("publicación", "publicaciones", $result['ko']) . ' ' . ngettext("falló", "fallaron", $result['ko']) . ' al intentar ' . ngettext("eliminarla", "eliminarlas", $result['ko']) . '.');
        }
        
        $this->redirect('@publicacion_ml');
    }
    
}
