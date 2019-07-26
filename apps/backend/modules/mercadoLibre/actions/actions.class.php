<?php
/**
 * aws actions.
 *
 * @package    deluxebuys
 * @subpackage aws
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mercadoLibreActions extends sfActions
{
        
    /**
     * Executes auth action
     *
     * @param sfRequest $request A request object
     */
    public function executeAuth(sfWebRequest $request)
    {
        $idEshop = $request->getParameter('idEshop');
        
        if ( $idEshop ) {
            $eshop = eshopTable::getInstance()->findOneByIdEshop( $idEshop );
            $clientId = $eshop->getMlClientId();
            $clientSecret = $eshop->setMlClientSecret();
        } else {
            $clientId = sfConfig::get('app_ml_client_id');
            $clientSecret = sfConfig::get('app_ml_client_secret');
        }
        
        $api = new Meli( $clientId, $clientSecret );
    
        if( $_GET['code'] )
        {
            if ( $idEshop ) {
                $oAuth = $api->authorize($_GET['code'], sfConfig::get('app_host') . '/backend/ml/' . $idEshop . '/auth');
            } else {
                $oAuth = $api->authorize($_GET['code'], sfConfig::get('app_host') . '/backend/ml/auth');
            }
            
            
            var_dump($oAuth['body']);
        }
        else
        {
            echo 'Login with MercadoLibre';
        }
        exit;
    }
    
    
    /**
     * Executes notifications action
     *
     * @param sfRequest $request A request object
     */
    public function executeNotifications(sfWebRequest $request)
    {    	
        $idEshop = $request->getParameter('idEshop');
        
    	if ($_SERVER['REQUEST_METHOD'] === 'POST')
    	{
    		$input = file_get_contents('php://input'); 
    		$data = json_decode($input, true);
    		
    		$method = 'process' . ucfirst( $data['topic'] );
    		$this->$method( $data, $idEshop );
    		    		
    		$status= "200";
    		$status_header = 'HTTP/1.0 ' . $status . ' OK';
    		header($status_header);
    	}
    	
    	exit;
    }
    
    protected function processOrders( $data, $idEshop = null )
    {
        $resource = $data['resource'];
    	$orderId = str_replace( '/orders/', '', $resource);
    	
    	$pagoNotificacion = pagoNotificacionTable::getInstance()->getByCompoundKey(formaPago::MERCADOLIBRE, $orderId);
    	
    	/*
    	 *  Si ya existe una notificacion para la misma orden no la toma en cuenta.
    	 *  Esto es necesario porque ML informa varias veces la misma orden
    	 */    	
    	if ( $pagoNotificacion )
    	{
    	    return;
    	}
    	
    	$pagoNotificacion = new pagoNotificacion();
    	$pagoNotificacion->setIdFormaPago(formaPago::MERCADOLIBRE);
    	$pagoNotificacion->setMetodo(pagoNotificacion::INTERNO);
    	$pagoNotificacion->setIdPedido( null );
    	$pagoNotificacion->setResponse( json_encode( array('order_id' => $orderId, 'idEshop' => $idEshop ) ) );
    	$pagoNotificacion->setProcesado(false);
    	$pagoNotificacion->setId($orderId);
    	$pagoNotificacion->save();
    	
    	// Se vuelve a verificar unicidad, para evitar ingresos simultaneos
    	$pagoNotificaciones = pagoNotificacionTable::getInstance()->listByCompoundKey(formaPago::MERCADOLIBRE, $orderId);
    	if ( count( $pagoNotificaciones ) > 1 ) {
    	    $pagoNotificacion->delete();
    	    return;
    	}
    	    	
    	$client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
    	
    	$task = new Net_Gearman_Task ('ProcesarComprasMLWorker', array ('idPagoNotificacion' => $pagoNotificacion->getIdPagoNotificacion()) );
    	$task->type = Net_Gearman_Task::JOB_BACKGROUND;
    	
    	$set = new Net_Gearman_Set();
    	$set->addTask ($task);
    	
    	$client->runSet($set);
    }
    
    protected function processPayments( $data, $idEshop = null )
    {
        $status= "200";
        $status_header = 'HTTP/1.0 ' . $status . ' OK';
        header($status_header);
        exit;
    }

    protected function processItems( $data, $idEshop = null )
    {
        $status= "200";
        $status_header = 'HTTP/1.0 ' . $status . ' OK';
        header($status_header);
        exit;
    }
    

    protected function processQuestions( $data, $idEshop = null )
    {
        $status= "200";
        $status_header = 'HTTP/1.0 ' . $status . ' OK';
        header($status_header);
        exit;
    }
    
    
    
    
}
    