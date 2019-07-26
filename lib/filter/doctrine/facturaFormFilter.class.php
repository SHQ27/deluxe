<?php

/**
 * factura filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class facturaFormFilter extends BasefacturaFormFilter
{
  public function configure()
  {
      $this->setWidget('id_pedido', new sfWidgetFormInput());
      $this->setWidget('comprobante', new sfWidgetFormInput());
      $options = array( Afip::PROD => ucfirst(Afip::PROD), Afip::HOMO => ucfirst( Afip::HOMO ) );
      $this->setWidget('entorno', new sfWidgetFormSelect(array('choices' => $options)));
      $this->setWidget('fecha_facturacion',  new sfWidgetFormFilterDate(
              array(
                  'from_date' => new pmWidgetFormDate(),
                  'to_date' => new pmWidgetFormDate(),
                  'with_empty' => false)
              ));

      $this->setValidators(array(
            'fecha_facturacion'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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

      if ((isset($values["fecha_facturacion"]["from"]) && $values["fecha_facturacion"]["from"]) && (isset($values["fecha_facturacion"]["to"]) && $values["fecha_facturacion"]["to"]))
      {
          $q->innerJoin($rootAlias.".pedido pe");
          $q->addWhere('(? <= pe.fecha_facturacion AND  pe.fecha_facturacion <= ?)', array($values["fecha_facturacion"]["from"], $values["fecha_facturacion"]["to"]));
      }

      if (isset($values["id_pedido"]) && $values["id_pedido"])
      {
          $q->addWhere($rootAlias.".id_pedido = ? ", $values["id_pedido"]);
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