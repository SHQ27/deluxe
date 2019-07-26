<?php
require_once(dirname(__FILE__) . '/../../../../../plugins/sfAdminDashPlugin/modules/sfAdminDash/lib/BasesfAdminDashActions.class.php');

/**
 * sfAdminDash actions.
 *
 * @package    plugins
 * @subpackage sfAdminDash
 * @author     kevin
 * @version    SVN: $Id: actions.class.php 25203 2009-12-10 16:50:26Z Crafty_Shadow $
 */ 
class sfAdminDashActions extends BasesfAdminDashActions
{
    public function executeDashboard()
    {
        $alertas = array();
        
        
        // Alerta de pedidos con intervencion manual
        $countIntervencionManual = pedidoTable::getInstance()->countIntervencionManual();
        
        if ( $countIntervencionManual )
        {
            $pedidosPlural = ($countIntervencionManual > 1)? 's' : '';
            $requierePlural = ($countIntervencionManual > 1)? 'n' : '';
            
            $alertas[] = array(
                    'descripcion' =>  "Hay $countIntervencionManual pedido$pedidosPlural que requiere$requierePlural intervención manual",
                    'route' => 'pedido'
            );
        }
                        
        // Alerta de publicaciones activas en ML y no vigentes en Deluxe 
        $countPublicacionesML = publicacionMlTable::getInstance()->countActivasErroneamenteEnML();
        
        if ( $countPublicacionesML )
        {                    
            $alertas[] = array(
                'descripcion' =>  "Hay $countPublicacionesML " . ngettext('publicación', 'publicaciones', $countPublicacionesML) . "en Mercado Libre que " . ngettext('requiere', 'requieren', $countPublicacionesML) . " intervención manual. Debido a que la api fallo al darlas de baja.",
                'route' => 'publicacion_ml'
            );
        }
        
                
        $this->alertas = $alertas;
    }
    
}
