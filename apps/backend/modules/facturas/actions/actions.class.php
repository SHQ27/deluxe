<?php

require_once dirname(__FILE__).'/../lib/facturasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/facturasGeneratorHelper.class.php';

/**
 * facturas actions.
 *
 * @package    deluxebuys
 * @subpackage facturas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class facturasActions extends autoFacturasActions
{
    public function executeNormalizarCorrelativo (sfWebRequest $request)
    {
        $incidencia = incidenciaFacturaTable::getInstance()->getByValor($request->getParameter("comprobante"));
        $incidencia->setResuelta(true);
        $incidencia->save();
        $this->redirect('/backend/facturas');
    }
}
