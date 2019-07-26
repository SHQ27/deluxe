<?php
/**
 * aws actions.
 *
 * @package    deluxebuys
 * @subpackage aws
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class remarketyActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $task   = $request->getParameter('task');
        $apiKey = $request->getParameter('remarkety_api_key');

        $params = $request->getGetParameters();
        unset($params['task'], $params['remarkety_api_key']);

        $response = Remarkety::getInstance()->get($task, $apiKey, $params);

        return $this->renderText( $response );
        
    }
    
    
    
    
}
    