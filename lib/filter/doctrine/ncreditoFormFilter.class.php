<?php

/**
 * ncredito filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ncreditoFormFilter extends BasencreditoFormFilter
{
  public function configure()
  {
      $this->setWidget('id_pedido', new sfWidgetFormInput());
      $this->setWidget('comprobante', new sfWidgetFormInput());
      $options = array( Afip::PROD => ucfirst(Afip::PROD), Afip::HOMO => ucfirst( Afip::HOMO ) );
      $this->setWidget('entorno', new sfWidgetFormSelect(array('choices' => $options)));
      $this->setWidget('fecha_emision',  new sfWidgetFormFilterDate(
              array(
                  'from_date' => new pmWidgetFormDate(),
                  'to_date' => new pmWidgetFormDate(),
                  'with_empty' => false)
              ));

      $this->setValidators(array(
            'fecha_emision'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
            'entorno'            => new sfValidatorString(array('required' => false)),
            'comprobante'        => new sfValidatorString(array('required' => false)),
            'id_pedido'          => new sfValidatorString(array('required' => false))
      ));
  }
  
  public function buildQuery(array $values)
  {
      $values = $this->processValues($values);
      $q = parent::doBuildQuery($values);

      $rootAlias = $q->getRootAlias();
      $q->select($rootAlias.'.*');
      $q->innerJoin($rootAlias.'.ncreditoFactura ncf');
      $q->innerJoin('ncf.factura f');
      $q->distinct();

      if ((isset($values["fecha_emision"]["from"]) && $values["fecha_emision"]["from"]) && (isset($values["fecha_emision"]["to"]) && $values["fecha_emision"]["to"]))
      {
          $q->innerJoin($rootAlias . ".ncreditoWsRequestNcredito ncrnc");
          $q->innerJoin("ncrnc.ncreditoWsRequest ncr");
          $q->addWhere('(? <= ncr.fecha AND  ncr.fecha <= ?)', array($values["fecha_emision"]["from"], $values["fecha_emision"]["to"]));
      }

      if (isset($values["id_pedido"]) && $values["id_pedido"])
      {
          $q->addWhere("f.id_pedido = ? ", $values["id_pedido"]);
      }

      if (isset($values["comprobante"]) && $values["comprobante"])
      {
          $q->addWhere($rootAlias.".comprobante = ? ", $values["comprobante"]);
      }

      if (isset($values["entorno"]) && $values["entorno"])
      {
          $q->addWhere($rootAlias.".entorno = ? ", $values["entorno"]);
      }

      return $q;
  }
}
