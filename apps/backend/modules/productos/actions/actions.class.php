<?php
require_once dirname(__FILE__) . '/../lib/productosGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/productosGeneratorHelper.class.php';

/**
 * productos actions.
 *
 * @package deluxebuys
 * @subpackage productos
 * @author Your name here
 * @version SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productosActions extends autoProductosActions
{

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $clone = $request->hasParameter('_clone');
        $form->setOption('clone', $clone);
        
        $params = $request->getParameter($form->getName());
        
        $params['stock'] = $form->mergeDefaults($params['stock']);
        
        $form->bind($params, $request->getFiles($form->getName()));
        
        if ($form->isValid()) {
            $notice = $form->getObject()->isNew() ? 'El producto se ha creado satisfactoriamente.' : 'El producto se ha editado satisfactoriamente.';
            
            try {
                $producto = $form->save();
                $notice .= $form->getMessage();
            } catch (Doctrine_Validator_Exception $e) {
                
                $errorStack = $form->getObject()->getErrorStack();
                
                $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ? 's' : null) . " with validation errors: ";
                foreach ($errorStack as $field => $errors) {
                    $message .= "$field (" . implode(", ", $errors) . "), ";
                }
                $message = trim($message, ', ');
                
                $this->getUser()->setFlash('error', $message);
                return sfView::SUCCESS;
            }
            
            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array(
                'object' => $producto
            )));
            
            if ($request->hasParameter('_save_and_go_to_list')) {
                $this->redirect('@producto');
            } elseif ($request->hasParameter('_save_and_add')) {
                $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');
                
                $this->redirect('@producto_new');
            } elseif ($request->hasParameter('_clone')) {
                $this->redirect(array(
                    'sf_route' => 'producto_edit',
                    'sf_subject' => $producto
                ));
            } else {
                $this->getUser()->setFlash('notice', $notice);
                
                $this->redirect(array(
                    'sf_route' => 'producto_edit',
                    'sf_subject' => $producto
                ));
            }
        } else {
            $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }

    public function executeListGoToImagenes(sfWebRequest $request)
    {
        $producto = $this->getRoute()->getObject();
        $this->redirect('/backend/productoImagenes?id_producto=' . $producto->getIdProducto());
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        
        $idProducto = $request->getParameter('id_producto');
        
        $estaAsignado = productoCampanaTable::getInstance()->exist($idProducto);
        
        if ($estaAsignado) {
            $this->getUser()->setFlash('error', 'No se pudo borrar el producto seleccionado debido a que está asignado a una campaña.');
            $this->redirect('@producto');
            return;
        }
        
        $estaAsignado = pedidoProductoItemTable::getInstance()->existProducto($idProducto);
        
        if ($estaAsignado) {
            $this->getUser()->setFlash('error', 'No se pudo borrar el producto seleccionado debido a que se encuentra dentro de al menos un pedido.');
            $this->redirect('@producto');
            return;
        }
        
        $productoItems = productoItemTable::getInstance()->listByIdProducto($idProducto);
        
        productoTagTable::getInstance()->deleteByIdProducto($idProducto);
        
        productoLogTable::getInstance()->deleteByIdProducto($idProducto);

        publicacionMlTable::getInstance()->deleteByIdProducto($idProducto);

        productoImagenTable::getInstance()->deleteByIdProducto($idProducto);
        
        foreach ($productoItems as $productoItem) {
            stockTable::getInstance()->deleteByIdProductoItem($productoItem->getIdProductoItem());
        }
        
        productoItemTable::getInstance()->deleteByIdProducto($idProducto);
        
        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array(
            'object' => $this->getRoute()
                ->getObject()
        )));
        
        if ($this->getRoute()
            ->getObject()
            ->delete()) {
            $this->getUser()->setFlash('notice', 'El producto fue borrado correctamente.');
        }
        
        $this->redirect('@producto');
    }

    protected function executeBatchChangePrice(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        
        $params['ids'] = ($all === 'true') ? 'all' : implode(',', $ids);
        
        $url = $this->getController()->genUrl(array(
            'sf_route' => 'producto_editPrices'
        ));
        
        $this->redirect($url . '?' . http_build_query($params));
    }

    protected function executeBatchSetCategoriaML(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        
        $params['ids'] = ($all === 'true') ? 'all' : implode(',', $ids);
        
        $url = $this->getController()->genUrl(array(
            'sf_route' => 'producto_setCategoriaML'
        ));
        
        $this->redirect($url . '?' . http_build_query($params));
    }

    protected function executeBatchPublicarML(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        
        $params['ids'] = ($all === 'true') ? 'all' : implode(',', $ids);
        
        $url = $this->getController()->genUrl(array(
            'sf_route' => 'producto_publicarML'
        ));
        
        $this->redirect($url . '?' . http_build_query($params));
    }


    protected function executeBatchChangeStock(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        
        $params['ids'] = ($all === 'true') ? 'all' : implode(',', $ids);
        
        $url = $this->getController()->genUrl(array(
            'sf_route' => 'producto_editStock'
        ));
        
        $this->redirect($url . '?' . http_build_query($params));
    }

    protected function executeBatchActivar(sfWebRequest $request)
    {
        $all = $request->getParameter('all');
        $ids = $request->getParameter('ids');
        
        if ($all === 'true') {
            $productos = $this->buildQuery()->execute();
        } else {
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        // Valida que el precio sea mayora a cero
        $validate = true;
        foreach ($productos as $producto) {
            if ($producto->getOrigen() == producto::ORIGEN_OUTLET && $producto->getPrecioOutlet() <= 0 || $producto->getOrigen() != producto::ORIGEN_OUTLET && $producto->getPrecioNormal() <= 0) {
                $validate = false;
                break;
            }
        }
        
        if ($validate) {
            foreach ($productos as $producto) {
                $producto->setActivo(true);
                $producto->doNotPostActions(array(
                    producto::POST_ACTION_UPDATE_PRECIO,
                    producto::POST_ACTION_UPDATE_STOCK,
                    producto::POST_ACTION_UPDATE_ML
                ));
                $producto->save();
            }
            
            $this->getUser()->setFlash('notice', 'Se activaron correctamente los productos seleccionados');
        } else {
            $this->getUser()->setFlash('error', 'No se activaron los productos debido a que hay productos con precio cero.');
        }
    }

    protected function executeBatchDesactivar(sfWebRequest $request)
    {
        $all = $request->getParameter('all');
        $ids = $request->getParameter('ids');
        
        if ($all === 'true') {
            $productos = $this->buildQuery()->execute();
        } else {
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        foreach ($productos as $producto) {
            $producto->setActivo(false);
            $producto->doNotPostActions(array(
                producto::POST_ACTION_UPDATE_PRECIO,
                producto::POST_ACTION_UPDATE_STOCK,
                producto::POST_ACTION_UPDATE_ML
            ));
            $producto->save();
        }
        
        $this->getUser()->setFlash('notice', 'Se desactivaron correctamente los productos seleccionados');
    }

    protected function executeBatchEsOutlet(sfWebRequest $request)
    {
        $all = $request->getParameter('all');
        $ids = $request->getParameter('ids');
                
        if ($all === 'true') {
            $productos = $this->buildQuery()->execute();
            
            $ids = array();
            foreach ($productos as $producto) {                
                $ids[] = $producto->getIdProducto();
            }
        } else {
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        foreach ($productos as $producto) {
        
            if ( $producto->esOferta() ) {
                $this->getUser()->setFlash('error', 'Existen productos asignados a campañas, quitalos de la campaña antes de pasarlos a outlet');
                $this->redirect('producto');
                exit;
            }
        }
        
        $client = new Net_Gearman_Client(array( sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port') ));
        $idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();        
        
        $task = new Net_Gearman_Task('ProductosSetOutletWorker', array(
            'idsProductos' => $ids,
            'esOutlet' => true,
            'idUsuario' => $idUsuario
        ));
        
        $task->type = Net_Gearman_Task::JOB_BACKGROUND;
        
        $set = new Net_Gearman_Set();
        $set->addTask($task);
        
        $client->runSet($set);
        
        $this->redirect('notificacion_backend_start');
        exit();
    }

    protected function executeBatchNoEsOutlet(sfWebRequest $request)
    {
        $all = $request->getParameter('all');
        $ids = $request->getParameter('ids');
        
        if ($all === 'true') {
            $productos = $this->buildQuery()->execute();
            
            $ids = array();
            foreach ($productos as $producto) {
                $ids[] = $producto->getIdProducto();
            }
        }
        
        $client = new Net_Gearman_Client(array( sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port') ));
        $idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
        
        $task = new Net_Gearman_Task('ProductosSetOutletWorker', array(
            'idsProductos' => $ids,
            'esOutlet' => false,
            'idUsuario' => $idUsuario
        ));
        
        $task->type = Net_Gearman_Task::JOB_BACKGROUND;
        
        $set = new Net_Gearman_Set();
        $set->addTask($task);
        
        $client->runSet($set);
        
        $this->redirect('notificacion_backend_start');
        exit();
    }

    protected function executeBatchMostrarPrecioLista(sfWebRequest $request)
    {
        $all = $request->getParameter('all');
        $ids = $request->getParameter('ids');
        
        if ($all === 'true') {
            $productos = $this->buildQuery()->execute();
        } else {
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        foreach ($productos as $producto) {
            $producto->setMostrarPrecioLista(true);
            $producto->doNotPostActions(array(
                producto::POST_ACTION_UPDATE_PRECIO,
                producto::POST_ACTION_UPDATE_STOCK,
                producto::POST_ACTION_UPDATE_ML,
                producto::POST_ACTION_CERRAR_PUBLICACION_ML
            ));
            $producto->save();
        }
    }

    protected function executeBatchOcultarPrecioLista(sfWebRequest $request)
    {
        $all = $request->getParameter('all');
        $ids = $request->getParameter('ids');
        
        if ($all === 'true') {
            $productos = $this->buildQuery()->execute();
        } else {
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        foreach ($productos as $producto) {
            $producto->setMostrarPrecioLista(false);
            $producto->doNotPostActions(array(
                producto::POST_ACTION_UPDATE_PRECIO,
                producto::POST_ACTION_UPDATE_STOCK,
                producto::POST_ACTION_UPDATE_ML,
                producto::POST_ACTION_CERRAR_PUBLICACION_ML
            ));
            $producto->save();
        }
    }

    protected function executeBatchDestacarHomeEshop(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        
        $this->batchDestacar($ids, $all, 4);
    }

    protected function executeBatchDestacarArriba(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        
        $this->batchDestacar($ids, $all, 3);
    }

    protected function executeBatchDestacarMedio(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        $this->batchDestacar($ids, $all, 2);
    }

    protected function executeBatchDestacarAbajo(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        $this->batchDestacar($ids, $all, 1);
    }

    protected function executeBatchQuitarDestacado(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        $this->batchDestacar($ids, $all, 0);
    }

    protected function batchDestacar($ids, $all, $value)
    {
        if ($all === 'true') {
            $productos = $this->buildQuery()->execute();
        } else {
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        foreach ($productos as $producto) {
            $producto->setDestacar($value);
            $producto->doNotPostActions(array(
                producto::POST_ACTION_UPDATE_PRECIO,
                producto::POST_ACTION_UPDATE_STOCK,
                producto::POST_ACTION_UPDATE_ML,
                producto::POST_ACTION_CERRAR_PUBLICACION_ML
            ));
            $producto->save();
        }
    }

    protected function executeBatchSeleccionSticker(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        
        $params['ids'] = ($all === 'true') ? 'all' : implode(',', $ids);
        
        $url = $this->getController()->genUrl(array(
            'sf_route' => 'producto_editSticker'
        ));
        
        $this->redirect($url . '?' . http_build_query($params));
    }

    protected function executeBatchSeleccionSetTalle(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        
        $params['ids'] = ($all === 'true') ? 'all' : implode(',', $ids);
        
        $url = $this->getController()->genUrl(array(
            'sf_route' => 'producto_editSetTalle'
        ));
        
        $this->redirect($url . '?' . http_build_query($params));
    }

    protected function executeBatchSeleccionEshop(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $all = $request->getParameter('all');
        
        $params['ids'] = ($all === 'true') ? 'all' : implode(',', $ids);
        
        $url = $this->getController()->genUrl(array(
            'sf_route' => 'producto_editEshop'
        ));
        
        $this->redirect($url . '?' . http_build_query($params));
    }

    public function executeEditSticker(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        
        if ($ids === 'all') {
            $productos = $this->buildQuery()->execute();
        } else {
            $ids = explode(',', $ids);
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        $form = new productosEditarStickersForm(array(), array(
            'productos' => $productos
        ));
        
        if ($request->isMethod('post')) {
            $form->bind($request->getParameter('productosStickers'));
            
            if ($form->isValid()) {
                $form->save();
                $this->getUser()->setFlash('notice', 'Se editaron el sticker de los productos seleccionados');
                $this->redirect('@producto');
            }
        }
        
        $this->form = $form;
        $this->productos = $productos;
    }

    public function executeEditSetTalle(sfWebRequest $request)
    {
        set_time_limit(0);
        
        $ids = $request->getParameter('ids');
        
        if ($ids === 'all') {
            $productos = $this->buildQuery()->execute();
        } else {
            $ids = explode(',', $ids);
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }

        foreach ($productos as $producto) {
            $productosPorMarca[$producto->getMarca()->getNombre()][] = $producto;    
        }

        $form = new productosEditarSetTallesForm(array(), array(
            'productos' => $productos
        ));
        
        if ($request->isMethod('post')) {
            $form->bind($request->getParameter('productosSetTalles'));
            
            if ($form->isValid()) {
                $form->save();
                $this->getUser()->setFlash('notice', 'Se editaron los Set de Talles de los productos seleccionados');
                $this->redirect('@producto');
            }
        }
        
        $this->form = $form;
        $this->productosPorMarca = $productosPorMarca;
        //$this->producto = $producto;
    }

    public function executeEditEshop(sfWebRequest $request)
    {
        set_time_limit(0);
        
        $ids = $request->getParameter('ids');
        
        if ($ids === 'all') {
            $productos = $this->buildQuery()->execute();
        } else {
            $ids = explode(',', $ids);
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        $form = new productosEditarEshopForm(array(), array(
            'productos' => $productos
        ));
        
        if ($request->isMethod('post')) {
            $form->bind($request->getParameter('productosEditarEshop'));
            
            if ($form->isValid()) {
                $form->save();
                $this->getUser()->setFlash('notice', 'Se editó el eShop de los productos seleccionados');
                $this->redirect('@producto');
            }
        }
        
        $this->form = $form;
        $this->productos = $productos;
    }

    public function executeEditPrices(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        
        if ($ids === 'all') {
            $productos = $this->buildQuery()->execute();
        } else {
            $ids = explode(',', $ids);
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        $form = new productosEditarPreciosForm(array(), array(
            'productos' => $productos
        ));
        
        if ($request->isMethod('post')) {
            $form->bind($request->getParameter('productosEditarPrecios'));
            
            if ($form->isValid()) {
                $form->save();
                $this->redirect('notificacion_backend_start');
                exit();
            }
        }
        
        $this->form = $form;
        $this->productos = $productos;
    }

    public function executeEditStock(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        
        if ($ids === 'all') {
            $productos = $this->buildQuery()->execute();
        } else {
            $ids = explode(',', $ids);
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        $form = new editStockForm(array(), array(
            'productos' => $productos
        ));
        
        if ($request->isMethod('post')) {
            $params = $request->getParameter('editStock');
            
            $params = $form->mergeDefaults($params);
            $params['_csrf_token'] = $form->getCSRFToken();
            $form->bind($params);
            
            if ($form->isValid()) {
                $form->save();
                $this->redirect('notificacion_backend_start');
                exit();
            }
        }
        
        $this->form = $form;
        $this->productos = $productos;
    }

    public function executeSubir(sfWebRequest $request)
    {
        $idProductoImagen = $request->getParameter('id_producto_imagen');
        $productoImagen = productoImagenTable::getInstance()->findOneByIdProductoImagen($idProductoImagen);
        
        $currentOrden = $productoImagen->getOrden();
        $productoImagenAnterior = productoImagenTable::getInstance()->getPrev($productoImagen->getIdProducto(), $productoImagen->getOrden());
        $ordenAnterior = $productoImagenAnterior->getOrden();
        
        // intercambio los ordenes
        $productoImagenAnterior->setOrden($currentOrden);
        $productoImagenAnterior->save();
        
        $productoImagen->setOrden($ordenAnterior);
        
        $productoImagen->save();
        
        $this->producto = $productoImagen->getProducto();
        
        $this->setTemplate('gestionImagenes');
    }

    public function executeBajar(sfWebRequest $request)
    {
        $idProductoImagen = $request->getParameter('id_producto_imagen');
        $productoImagen = productoImagenTable::getInstance()->findOneByIdProductoImagen($idProductoImagen);
        
        $currentOrden = $productoImagen->getOrden();
        $productoImagenSiguiente = productoImagenTable::getInstance()->getNext($productoImagen->getIdProducto(), $productoImagen->getOrden());
        $ordenSiguiente = $productoImagenSiguiente->getOrden();
        
        // intercambio los ordenes
        $productoImagenSiguiente->setOrden($currentOrden);
        $productoImagenSiguiente->save();
        
        $productoImagen->setOrden($ordenSiguiente);
        
        $productoImagen->save();
        
        $this->producto = $productoImagen->getProducto();
        
        $this->setTemplate('gestionImagenes');
    }

    public function executeEliminar(sfWebRequest $request)
    {
        $idProductoImagen = $request->getParameter('id_producto_imagen');
        $productoImagen = productoImagenTable::getInstance()->findOneByIdProductoImagen($idProductoImagen);
        
        $productoImagen->delete();
        
        $this->producto = $productoImagen->getProducto();
        
        $this->setTemplate('gestionImagenes');
    }

    public function executeImportarRemoveCSV(sfWebRequest $request)
    {        
        $csvFilePath = sfConfig::get('sf_temp_dir') . '/importacion/productos.csv';
        unlink($csvFilePath);
        $this->redirect('/backend/productos/importar');
    }

    public function executeImportarRemoveZIP(sfWebRequest $request)
    {
        $imagenesFilePath = sfConfig::get('sf_temp_dir') . '/importacion/imagenes.zip';
        @unlink($imagenesFilePath);
        $this->redirect('/backend/productos/importar');
    }

    public function executeImportar(sfWebRequest $request)
    {
        set_time_limit(0);
        
        // Formulario de Carga de archivos
        $formCarga = new importarProductosForm();
        
        if ($request->isMethod('post')) {
            $formCarga->bind($request->getParameter($formCarga->getName()), $request->getFiles($formCarga->getName()));
            
            if ($formCarga->isValid()) {
                $formCarga->process();
                $this->redirect('/backend/productos/importar');
            }
        }
        
        $this->formCarga = $formCarga;
        

        // Cuadro de subidos paso 1
        $csvFilePath = sfConfig::get('sf_temp_dir') . '/importacion/productos.csv';
        $imagenesFilePath = sfConfig::get('sf_temp_dir') . '/importacion/imagenes.zip';
        
        $this->csvFileExists = file_exists($csvFilePath);
        if ($this->csvFileExists) {
            $this->csvFileDate = filemtime($csvFilePath);
        }
        
        $this->imagenesFileExists = file_exists($imagenesFilePath);
        if ($this->imagenesFileExists) {
            $this->imagenesFileDate = filemtime($imagenesFilePath);
        }
            
        $this->marcas = marcaTable::getInstance()->listAll();
        $this->eshops = eshopTable::getInstance()->listAll();
    }

    public function executeImportarPreview(sfWebRequest $request)
    {
        set_time_limit(0);
        
        $csvFilePath = sfConfig::get('sf_temp_dir') . '/importacion/productos.csv';
        $csvTmpFilePath = sfConfig::get('sf_temp_dir') . '/importacion/productos_tmp.csv';
        $imagenesFilePath = sfConfig::get('sf_temp_dir') . '/importacion/imagenes.zip';
        $dataSerializedFilePath = sfConfig::get('sf_temp_dir') . '/importacion/dataSerialized';
        
        // Borro el archivo de informacion serializada anterior
        @unlink($dataSerializedFilePath);
        
        // Borro la carpeta de imagenes descomprimida anteriormente
        $imagesTempFolderPath = sfConfig::get('sf_temp_dir') . '/importacion/imagenes';
        dirHelper::getInstance()->rrmdir($imagesTempFolderPath);
        
        $this->csvFileExists = file_exists($csvFilePath);
        $this->imagenesFileExists = file_exists($imagenesFilePath);
        
        $idEshop = $request->getParameter('id_eshop');
        $this->idEshop = $idEshop;

        if ( $idEshop ) {
            $eshop = eshopTable::getInstance()->getById( $idEshop );
            $marca = $eshop->getMarca();
            $origen = producto::ORIGEN_STOCK_PERMANENTE;
        } else {
            $idMarca = $request->getParameter('id_marca');
            $marca = marcaTable::getInstance()->findOneByIdMarca($idMarca);
            $origen = $request->getParameter('origen');
        }
        
        $this->marca = $marca;
        $this->origen = $origen;
        
        $errores = array();
        $controlDuplicados = array();
        
        if ($this->csvFileExists && $this->imagenesFileExists) {
            // Proceso productos.csv
            $content = file_get_contents($csvFilePath);
            @unlink($csvTmpFilePath);
            file_put_contents($csvTmpFilePath, $content);
            
            $file = fopen($csvTmpFilePath, "r");
            
            $row = fgetcsv($file, 0, ";");
            
            $productos = array();
            while (($row = fgetcsv($file, 0, ";")) !== FALSE) {
                if (count($row) != 42) {
                    $errores[] = 'El formato del CSV es incorrecto.';
                    break;
                }
                
                $n                  = $row[0];
                $denominacion       = $row[1];
                $peso               = $row[2];
                $categoria          = $row[3];
                $tags               = $row[4];
                $descripcion        = str_replace("\n", '<br/>', $row[5]);
                
                $colorDenominacion  = $row[6];
                
                $codigos            = array();
                $tallesDenominacion = array();
                $cantidades         = array();

                for ($i = 0; $i <= 27; $i = $i + 3) {
                    $codigo = $row[7 + $i];
                    $talleDenominacion = $row[8 + $i];
                    $cantidad = $row[9 + $i];
                    
                    if ( $talleDenominacion && is_numeric($cantidad) && $codigo ) {
                        $codigos[] = $codigo;
                        $tallesDenominacion[] = $talleDenominacion;
                        $cantidades[] = $cantidad;
                    }
                }
                
                $precioLista          = $row[38];
                $costo                = $row[39];
                $precioDeluxe         = $row[40];
                $talleSetDenominacion = $row[41];
                
                $index = ($n) ? $n : $index;
                
                if ($n) {
                    $productos[$index]['denominacion'] = $denominacion;
                    $productos[$index]['descripcion'] = $descripcion;
                    
                    $categoria = explode('/', $categoria);
                    
                    if (count($categoria) != 2) {
                        $errores[] = "Producto #$index: La categoria tiene un formato incorrecto. El formato correcto es por ej. \"Mujer/Remeras\"";
                    } else {
                        $denominacionProductoGenero = $categoria[0];
                        $denominacionProductoCategoria = $categoria[1];
                        
                        $categoria = productoCategoriaTable::getInstance()->getByDenominacion($denominacionProductoCategoria, $denominacionProductoGenero);
                        
                        if (! $categoria) {
                            $errores[] = "Producto #$index: No existe la categoria \"$denominacionProductoCategoria\" en el genero \"$denominacionProductoGenero\"";
                        }
                    }
                    
                    $color = productoColorTable::getInstance()->getByDenominacion($colorDenominacion);
                    
                    if (! $color) {
                        $errores[] = "Producto #$index: No existe el color \"$colorDenominacion\"";
                    }
                    
                    $productos[$index]['categoria'] = $categoria;
                    
                    if (! $tags && ! $errores) {
                        $arr = array();
                        $arr[] = $marca->getNombre();
                        $arr[] = $denominacionProductoCategoria;
                        $arr[] = $denominacionProductoGenero;
                        $arr[] = $color->getDenominacion();
                        $tags = implode(', ', $arr);
                    }
                    
                    $productos[$index]['tags'] = $tags;
                    
                    $productos[$index]['precioLista'] = $precioLista;
                    $productos[$index]['precioDeluxe'] = $precioDeluxe;
                    $productos[$index]['costo'] = $costo;
                    $productos[$index]['peso'] = $peso;
                    
                    $talleSet = talleSetTable::getInstance()->getByCompoundKey($marca->getIdMarca(), $talleSetDenominacion);
                    $productos[$index]['talleSet'] = $talleSet;
                    
                    if ($talleSetDenominacion && ! $talleSet) {
                        $errores[] = "Producto #$index: No existe el Set de Talles \"$talleSetDenominacion\" en la marca \"" . $marca->getNombre() . '"';
                    }
                    
                    $productos[$index]['items'] = array();
                    
                    $c = count($tallesDenominacion);
                    for ($i = 0; $i < $c; $i ++) {
                        $talleDenominacion = $tallesDenominacion[$i];
                        $cantidad          = $cantidades[$i];
                        $codigo            = $codigos[$i];
                        
                        $talle = productoTalleTable::getInstance()->getByDenominacion($talleDenominacion);
                        
                        if (! $talle) {
                            $errores[] = "Producto #$index: No existe el talle \"$talleDenominacion\"";
                        }
                        
                        $productos[$index]['items'][] = array(
                            'codigo' => $codigo,
                            'talle' => $talle,
                            'color' => $color,
                            'cantidad' => $cantidad
                        );

                        $uniqueKey = $codigo . '-' . $denominacion  . '-' . $talleDenominacion  . '-' . $colorDenominacion;
                        $controlDuplicados[ $uniqueKey ] = ( isset( $controlDuplicados[ $uniqueKey ] ) ) ? $controlDuplicados[ $uniqueKey ] : 0;
                        $controlDuplicados[ $uniqueKey ]++;
                        
                        if ( $controlDuplicados[ $uniqueKey ] > 1 ) {
                            $errores[] = "Producto #$index: La combinacion&nbsp;&nbsp;&nbsp;&nbsp;Talle:  $talleDenominacion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Color: $colorDenominacion esta repetida";
                        }
                        
                    }
                }
            }
            
            fclose($file);
            
            $this->productos = $productos;
            
            file_put_contents($dataSerializedFilePath, serialize($productos));
            @unlink($csvTmpFilePath);
            
            // Proceso imagenes.zip
            $zip = new ZipArchive();
            
            if ($zip->open($imagenesFilePath) === true) {
                $zip->extractTo(sfConfig::get('sf_temp_dir') . '/importacion/');
                $zip->close();
            } else {
                $errores[] = 'No se pudo extraer imagenes.zip, el archivo puede estar truncado. Vuelva a crear el .zip e intente nuevamente.';
            }
            
            $this->errores = $errores;
        }
    }


    public function executeImportarShowImage(sfWebRequest $request)
    {
        set_time_limit(0);
                
        $index = $request->getParameter('index');
        
        $imagenesDirName = sfConfig::get('sf_temp_dir') . '/importacion/imagenes/' . $index . '/';
        $files = glob("{$imagenesDirName}*.[jJ][pP][gG]");
        
        $imagePath = $files[0];
        
        header('Content-Type: image/jpeg');
        $thumbnail = new sfThumbnail(150, 169, true, true, 80, 'sfGDAdapter');
        $thumbnail->loadFile($imagePath);
        echo $thumbnail->toString();
        exit();
    }

    public function executeImportarProcesar(sfWebRequest $request)
    {
        set_time_limit(0);
        
        $params['idMarca'] = $request->getParameter('idMarca', null);
        $params['origen'] = $request->getParameter('origen', null);
        $params['idEshop'] = $request->getParameter('idEshop', null);        

        $params['idUsuario'] = sfContext::getInstance()->getUser()->getGuardUser()->getId();
                
        $client = new Net_Gearman_Client(array(
            sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')
        ));
        
        $task = new Net_Gearman_Task('ImportarProductoWorker', $params );
        $task->type = Net_Gearman_Task::JOB_BACKGROUND;
        
        $set = new Net_Gearman_Set();
        $set->addTask($task);
        
        $client->runSet($set);
        
        $this->redirect('notificacion_backend_start');
        exit();
    }

    public function executeProductoItemHistory(sfWebRequest $request)
    {
        $idProductoItem = $request->getParameter('idProductoItem');
        $this->history = stockTable::getInstance()->listByIdProductoItem($idProductoItem);
    }

    public function executeListRestaurarStockCampana(sfWebRequest $request)
    {
        $this->data = campanaTable::getInstance()->listPosiblesRestaurarStock();
    }

    public function executeRestaurarStockCampana(sfWebRequest $request)
    {
        set_time_limit(0);

        // Parametros GET
        $idCampana = $request->getParameter('idCampana');
        $idMarca = $request->getParameter('idMarca', 0);
        $idProductoCategoria = $request->getParameter('idProductoCategoria', 0);
       
        // Definicion de pre filtros
        $campana = campanaTable::getInstance()->getById($idCampana);
        $marca = marcaTable::getInstance()->getOneById($idMarca);
        $productoCategoria = productoCategoriaTable::getInstance()->getById($idProductoCategoria);
        
        $productoItems = productoItemTable::getInstance()->listRestaurablesDesdeCampanaFinalizada($idCampana, $idMarca, $idProductoCategoria);
        
        $data = array();
        foreach ($productoItems as $productoItem) {

            $producto = $productoItem->getProducto();
            if ( !isset( $data[ $producto->getIdProducto() ] ) ) {
                $data[ $producto->getIdProducto() ] = array();
            }
            
            $instanteReseteo = stockTable::getInstance()->getInstanteReseteo($productoItem->getIdProductoItem(), $campana->getFechaFin());            
            $stockReseteadoCampana = stockTable::getInstance()->getStockReseteado($productoItem->getIdProductoItem(), producto::ORIGEN_OFERTA, $instanteReseteo);
            $stockReseteadoRefuerzo = stockTable::getInstance()->getStockReseteado($productoItem->getIdProductoItem(), producto::ORIGEN_REFUERZO, $instanteReseteo);
            
            $row = array();
            $row['idProductoItem'] = $productoItem->getIdProductoItem();
            $row['talle'] = $productoItem->getProductoTalle()->getDenominacion();
            $row['color'] = $productoItem->getProductoColor()->getDenominacion();
            $row['diversidad'] = $producto->getDiversidad();
            $row['stockActual'] = (int) $productoItem->getStock();
            $row['stockCampanaARestaurar'] = $stockReseteadoCampana;
            $row['stockRefuerzoARestaurar'] = $stockReseteadoRefuerzo;

            $data[ $producto->getIdProducto() ]['producto'] = $producto;
            $data[ $producto->getIdProducto() ]['productoItems'][] = $row;
        }
        
        $this->campanas = campanaTable::getInstance()->listUltimas(10);
        $this->idProductoItemsConFaltantes = productoItemTable::getInstance()->getFaltantesByIdCampana( $idCampana );

        $this->campana = $campana;        
        $this->marca = $marca;
        $this->productoCategoria = $productoCategoria;

        $this->data = $data;
    }

    public function executeRestaurarStockCampanaResultado(sfWebRequest $request)
    {
        // Parametros POST
        $asignar = $request->getParameter('asignar');
        $stockEn = $request->getParameter('stockEn');
        $restaurarRefuerzo = (bool) $request->getParameter('restaurarRefuerzo');
        $idsProductoItems = $request->getParameter('idsProductoItems');
        $idsProductoItems = explode(',', $idsProductoItems);
        $idCampana = $request->getParameter('idCampana');
        
        $client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
        $idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
        
        $params = array(
                'asignar' => $asignar,
                'stockEn' => $stockEn,
                'restaurarRefuerzo' => $restaurarRefuerzo,
                'idsProductoItems' => $idsProductoItems,
                'idCampana' => $idCampana,
                'idUsuario' => $idUsuario
            );

        $task = new Net_Gearman_Task ('RestaurarCampanaWorker', $params );
        $task->type = Net_Gearman_Task::JOB_BACKGROUND;
        
        $set = new Net_Gearman_Set();
        $set->addTask ($task);
        
        $client->runSet($set);

        $this->redirect('notificacion_backend_start');
        exit();
    }

    public function executeEnviarMercaderiaOca(sfWebRequest $request)
    {}

    protected function getSort()
    {
        if (isset($_GET['sort'])) {
            $sort = array(
                $_GET['sort'],
                $_GET['sort_type']
            );
        } else {
            $sort = $this->getUser()->getAttribute('productos.sort', null, 'admin_module');
        }
        
        if (null !== $sort) {
            return $sort;
        }
        
        $this->setSort($this->configuration->getDefaultSort());
        
        return $this->getUser()->getAttribute('productos.sort', null, 'admin_module');
    }

    public function executeSetCategoriaML(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        
        if ($ids === 'all') {
            $productos = $this->buildQuery()->execute();
        } else {
            $ids = explode(',', $ids);
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        $form = new productosSetCategoriaMLForm(array(), array(
            'productos' => $productos
        ));
        
        if ($request->isMethod('post')) {
            $form->bind($request->getParameter('productosSetCategoriaML'));
            
            if ($form->isValid()) {
                $form->save();
                $this->redirect('notificacion_backend_start');
                exit();
            }
        }
        
        $this->form = $form;
        $this->productos = $productos;
    }

    public function executePublicarML(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        
        if ($ids === 'all') {
            $productos = $this->buildQuery()->execute();
        } else {
            $ids = explode(',', $ids);
            $productos = productoTable::getInstance()->listByIdProductos($ids);
        }
        
        $form = new productosPublicarMLForm();
        
        if ($request->isMethod('post')) {
            $form->bind($request->getParameter('productosPublicarML'));
            
            if ($form->isValid()) {
                $form->publicar();
                $this->redirect('notificacion_backend_start');
                exit();
            }
        }
        
        $this->form = $form;
        $this->productos = $productos;
        $this->eshopsEnabled = sfConfig::get('app_ml_eshopsEnabled');
    }
    
    public function executeDescargarExcel(sfWebRequest $request)
    {
        set_time_limit(0);
                           
        $productos = $this->buildQuery()->execute();
         
        $dateNow = date('Y-m-d H:i:s');
         
        $phpExcel = new PHPExcel();
    
        $phpExcel->getProperties()->setCreator("DeluxeBuys");
        $activeSheet = $phpExcel->setActiveSheetIndex(0);
    
        $headerCellStyle = array(
            'font' => array('bold' => true, 'size' => '10', 'color' => array('rgb' => 'FFFFFF')),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '333333')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '000000'))));
        
        $dataCellStyle = array(
            'font' => array('size' => "10"),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '000000'))));
        
        $activeSheet->setCellValue('A1', 'Deluxebuys - Planilla de productos');
        $activeSheet->mergeCells('A1:D1');
        $activeSheet->mergeCells('A2:D2');
    
        $activeSheet->setCellValue('A3', 'Generada: ' . $dateNow);
        $activeSheet->mergeCells('A3:D3');       
    
        $activeSheet->setCellValue('A5', 'Id Producto');
        $activeSheet->setCellValue('B5', 'Id Producto Item');
        $activeSheet->setCellValue('C5', 'Marca');
        $activeSheet->setCellValue('D5', 'Codigo');
        $activeSheet->setCellValue('E5', 'Denominacion');
        $activeSheet->setCellValue('F5', 'Talle');
        $activeSheet->setCellValue('G5', 'Color');
        $activeSheet->setCellValue('H5', 'Precio Lista');
        $activeSheet->setCellValue('I5', 'Precio DB');
        $activeSheet->setCellValue('J5', 'Costo c/IVA');
        $activeSheet->setCellValue('K5', 'eShop');
        $activeSheet->setCellValue('L5', 'Origen');
        $activeSheet->setCellValue('M5', 'Stock en Campaña');
        $activeSheet->setCellValue('N5', 'Stock en Permanente');
        $activeSheet->setCellValue('O5', 'Stock en Outlet');
        $activeSheet->setCellValue('P5', 'Stock de Refuerzo');
        $activeSheet->setCellValue('Q5', 'Link a imagen del producto');
        $activeSheet->setCellValue('R5', 'Link en a item en ML');
        
        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(15);
        $activeSheet->getColumnDimension('C')->setWidth(20);
        $activeSheet->getColumnDimension('D')->setWidth(15);
        $activeSheet->getColumnDimension('E')->setWidth(30);
        $activeSheet->getColumnDimension('F')->setWidth(12);
        $activeSheet->getColumnDimension('G')->setWidth(12);
        $activeSheet->getColumnDimension('H')->setWidth(12);
        $activeSheet->getColumnDimension('I')->setWidth(12);
        $activeSheet->getColumnDimension('J')->setWidth(12);
        $activeSheet->getColumnDimension('K')->setWidth(12);
        $activeSheet->getColumnDimension('L')->setWidth(12);
        $activeSheet->getColumnDimension('M')->setWidth(15);
        $activeSheet->getColumnDimension('N')->setWidth(15);
        $activeSheet->getColumnDimension('O')->setWidth(15);
        $activeSheet->getColumnDimension('P')->setWidth(15);
        $activeSheet->getColumnDimension('Q')->setWidth(80);
        $activeSheet->getColumnDimension('R')->setWidth(80);
        
        $activeSheet->getStyle('A5:R5')->applyFromArray($headerCellStyle);
        
        $i = 6;
        foreach ($productos as $producto)
        {
            $productoItems = $producto->getProductoItem();
            $publicacionMl = $producto->getPublicacionMl();
            
            $denominacionEshop = ( $producto->getIdEshop() ) ? $producto->getEshop()->getDenominacion() : 'Deluxe Buys'; 
            
            foreach( $productoItems as $productoItem ) 
            {
                
                $codigo = $productoItem->getCodigo();   
                

                $activeSheet->setCellValue('A' . $i, $producto->getIdProducto() );
                $activeSheet->setCellValue('B' . $i, $productoItem->getIdProductoItem() );

                $activeSheet->setCellValue('C' . $i, $producto->getMarca()->getNombre() );
                $activeSheet->setCellValue('D' . $i, $codigo );
                $activeSheet->setCellValue('E' . $i, $producto->getDenominacion() );
                $activeSheet->setCellValue('F' . $i, $productoItem->getProductoTalle()->getDenominacion() );
                $activeSheet->setCellValue('G' . $i, $productoItem->getProductoColor()->getDenominacion() );
                $activeSheet->setCellValue('H' . $i, $producto->getPrecioLista() );
                $activeSheet->setCellValue('I' . $i, $producto->getPrecioDeluxe() );
                $activeSheet->setCellValue('J' . $i, $producto->getCosto() );
                $activeSheet->setCellValue('K' . $i, $denominacionEshop );
                $activeSheet->setCellValue('L' . $i, $producto->getOrigenDenominacion() );
                $activeSheet->setCellValue('M' . $i, $productoItem->getStockCampana() );
                $activeSheet->setCellValue('N' . $i, $productoItem->getStockPermanente() );
                $activeSheet->setCellValue('O' . $i, $productoItem->getStockOutlet() );
                $activeSheet->setCellValue('P' . $i, $productoItem->getStockRefuerzo() );

                $activeSheet->getStyle('H'.$i.':J'.$i)->getNumberFormat()->setFormatCode('$#,##0.00');

                $urlImagen = imageHelper::getInstance()->getUrl('producto_detalle_grande', $producto);
                $activeSheet->setCellValue('Q' . $i, $urlImagen);
                $activeSheet->getCell('Q' . $i)->getHyperlink()->setUrl( $urlImagen );

                if ( $publicacionMl ) {
                    $urlML = 'http://articulo.mercadolibre.com.ar/MLA-' . substr($publicacionMl->getItemId(), 3) . '-producto_JM';
                    $activeSheet->setCellValue('R' . $i, $urlML);
                    $activeSheet->getCell('R' . $i)->getHyperlink()->setUrl( $urlML );
                }

                
                
                $activeSheet->getStyle('A' . $i . ':R' . $i )->applyFromArray($dataCellStyle);
                
                $i++;   
            }
        }
    
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="productos_descargar_excel.xls"');
        header('Cache-Control: max-age=0');
    
        $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
        $writer->save('php://output');
    
        exit;
    }

  public function executeEdicionStockPrecioCSV(sfWebRequest $request)
  {   
      $form = new edicionStockPrecioCSVForm();
      
      if( $request->isMethod('post') )
      {
          $form->bind( $request->getParameter('edicionStockPrecioCSV'), $request->getFiles('edicionStockPrecioCSV') );
      
          if ( $form->isValid() )
          {
              $ok = $form->process();
              
              if ( $ok ) {
                  $this->redirect('notificacion_backend_start');
              }
          }
      }
      
      $this->form = $form;
  }
    
}
