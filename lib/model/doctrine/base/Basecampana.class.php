<?php

/**
 * Basecampana
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_campana
 * @property string $denominacion
 * @property clob $descripcion
 * @property string $texto_promocion
 * @property timestamp $fecha_inicio
 * @property timestamp $fecha_fin
 * @property boolean $tiene_envio_gratis
 * @property boolean $activo
 * @property date $estimacion_envio_fecha
 * @property clob $estimacion_envio_observacion
 * @property integer $estimacion_envio_horas
 * @property integer $objetivo_facturacion
 * @property boolean $mostrar_filtros
 * @property integer $total_stock
 * @property boolean $mostrar_reloj
 * @property boolean $mostrar_banner
 * @property boolean $mostrar_banner_hover
 * @property boolean $mostrar_descripcion
 * @property boolean $permitir_pago_offline
 * @property boolean $resetear_al_finalizar
 * @property integer $orden
 * @property char $color
 * @property Doctrine_Collection $campanaMarca
 * @property Doctrine_Collection $productoCampana
 * @property Doctrine_Collection $pedidoProductoItemCampana
 * @property Doctrine_Collection $campanaUsuario
 * @property Doctrine_Collection $productoCampanaFinalizada
 * @property Doctrine_Collection $reporteCampana
 * @property Doctrine_Collection $recepcionMercaderiaCampana
 * 
 * @method integer             getIdCampana()                    Returns the current record's "id_campana" value
 * @method string              getDenominacion()                 Returns the current record's "denominacion" value
 * @method clob                getDescripcion()                  Returns the current record's "descripcion" value
 * @method string              getTextoPromocion()               Returns the current record's "texto_promocion" value
 * @method timestamp           getFechaInicio()                  Returns the current record's "fecha_inicio" value
 * @method timestamp           getFechaFin()                     Returns the current record's "fecha_fin" value
 * @method boolean             getTieneEnvioGratis()             Returns the current record's "tiene_envio_gratis" value
 * @method boolean             getActivo()                       Returns the current record's "activo" value
 * @method date                getEstimacionEnvioFecha()         Returns the current record's "estimacion_envio_fecha" value
 * @method clob                getEstimacionEnvioObservacion()   Returns the current record's "estimacion_envio_observacion" value
 * @method integer             getEstimacionEnvioHoras()         Returns the current record's "estimacion_envio_horas" value
 * @method integer             getObjetivoFacturacion()          Returns the current record's "objetivo_facturacion" value
 * @method boolean             getMostrarFiltros()               Returns the current record's "mostrar_filtros" value
 * @method integer             getTotalStock()                   Returns the current record's "total_stock" value
 * @method boolean             getMostrarReloj()                 Returns the current record's "mostrar_reloj" value
 * @method boolean             getMostrarBanner()                Returns the current record's "mostrar_banner" value
 * @method boolean             getMostrarBannerHover()           Returns the current record's "mostrar_banner_hover" value
 * @method boolean             getMostrarDescripcion()           Returns the current record's "mostrar_descripcion" value
 * @method boolean             getPermitirPagoOffline()          Returns the current record's "permitir_pago_offline" value
 * @method boolean             getResetearAlFinalizar()          Returns the current record's "resetear_al_finalizar" value
 * @method integer             getOrden()                        Returns the current record's "orden" value
 * @method char                getColor()                        Returns the current record's "color" value
 * @method Doctrine_Collection getCampanaMarca()                 Returns the current record's "campanaMarca" collection
 * @method Doctrine_Collection getProductoCampana()              Returns the current record's "productoCampana" collection
 * @method Doctrine_Collection getPedidoProductoItemCampana()    Returns the current record's "pedidoProductoItemCampana" collection
 * @method Doctrine_Collection getCampanaUsuario()               Returns the current record's "campanaUsuario" collection
 * @method Doctrine_Collection getProductoCampanaFinalizada()    Returns the current record's "productoCampanaFinalizada" collection
 * @method Doctrine_Collection getReporteCampana()               Returns the current record's "reporteCampana" collection
 * @method Doctrine_Collection getRecepcionMercaderiaCampana()   Returns the current record's "recepcionMercaderiaCampana" collection
 * @method campana             setIdCampana()                    Sets the current record's "id_campana" value
 * @method campana             setDenominacion()                 Sets the current record's "denominacion" value
 * @method campana             setDescripcion()                  Sets the current record's "descripcion" value
 * @method campana             setTextoPromocion()               Sets the current record's "texto_promocion" value
 * @method campana             setFechaInicio()                  Sets the current record's "fecha_inicio" value
 * @method campana             setFechaFin()                     Sets the current record's "fecha_fin" value
 * @method campana             setTieneEnvioGratis()             Sets the current record's "tiene_envio_gratis" value
 * @method campana             setActivo()                       Sets the current record's "activo" value
 * @method campana             setEstimacionEnvioFecha()         Sets the current record's "estimacion_envio_fecha" value
 * @method campana             setEstimacionEnvioObservacion()   Sets the current record's "estimacion_envio_observacion" value
 * @method campana             setEstimacionEnvioHoras()         Sets the current record's "estimacion_envio_horas" value
 * @method campana             setObjetivoFacturacion()          Sets the current record's "objetivo_facturacion" value
 * @method campana             setMostrarFiltros()               Sets the current record's "mostrar_filtros" value
 * @method campana             setTotalStock()                   Sets the current record's "total_stock" value
 * @method campana             setMostrarReloj()                 Sets the current record's "mostrar_reloj" value
 * @method campana             setMostrarBanner()                Sets the current record's "mostrar_banner" value
 * @method campana             setMostrarBannerHover()           Sets the current record's "mostrar_banner_hover" value
 * @method campana             setMostrarDescripcion()           Sets the current record's "mostrar_descripcion" value
 * @method campana             setPermitirPagoOffline()          Sets the current record's "permitir_pago_offline" value
 * @method campana             setResetearAlFinalizar()          Sets the current record's "resetear_al_finalizar" value
 * @method campana             setOrden()                        Sets the current record's "orden" value
 * @method campana             setColor()                        Sets the current record's "color" value
 * @method campana             setCampanaMarca()                 Sets the current record's "campanaMarca" collection
 * @method campana             setProductoCampana()              Sets the current record's "productoCampana" collection
 * @method campana             setPedidoProductoItemCampana()    Sets the current record's "pedidoProductoItemCampana" collection
 * @method campana             setCampanaUsuario()               Sets the current record's "campanaUsuario" collection
 * @method campana             setProductoCampanaFinalizada()    Sets the current record's "productoCampanaFinalizada" collection
 * @method campana             setReporteCampana()               Sets the current record's "reporteCampana" collection
 * @method campana             setRecepcionMercaderiaCampana()   Sets the current record's "recepcionMercaderiaCampana" collection
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basecampana extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('campana');
        $this->hasColumn('id_campana', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('denominacion', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('descripcion', 'clob', 65535, array(
             'type' => 'clob',
             'length' => 65535,
             ));
        $this->hasColumn('texto_promocion', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('fecha_inicio', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('fecha_fin', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('tiene_envio_gratis', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('activo', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('estimacion_envio_fecha', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('estimacion_envio_observacion', 'clob', 65535, array(
             'type' => 'clob',
             'length' => 65535,
             ));
        $this->hasColumn('estimacion_envio_horas', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('objetivo_facturacion', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('mostrar_filtros', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('total_stock', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('mostrar_reloj', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('mostrar_banner', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('mostrar_banner_hover', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('mostrar_descripcion', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('permitir_pago_offline', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('resetear_al_finalizar', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('orden', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('color', 'char', 7, array(
             'type' => 'char',
             'default' => '#000000',
             'length' => 7,
             ));


        $this->index('campana_fecha_inicio', array(
             'fields' => 
             array(
              0 => 'fecha_inicio',
             ),
             ));
        $this->index('campana_fecha_fin', array(
             'fields' => 
             array(
              0 => 'fecha_fin',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('campanaMarca', array(
             'local' => 'id_campana',
             'foreign' => 'id_campana'));

        $this->hasMany('productoCampana', array(
             'local' => 'id_campana',
             'foreign' => 'id_campana'));

        $this->hasMany('pedidoProductoItemCampana', array(
             'local' => 'id_campana',
             'foreign' => 'id_campana'));

        $this->hasMany('campanaUsuario', array(
             'local' => 'id_campana',
             'foreign' => 'id_campana'));

        $this->hasMany('productoCampanaFinalizada', array(
             'local' => 'id_campana',
             'foreign' => 'id_campana'));

        $this->hasMany('reporteCampana', array(
             'local' => 'id_campana',
             'foreign' => 'id_campana'));

        $this->hasMany('recepcionMercaderiaCampana', array(
             'local' => 'id_campana',
             'foreign' => 'id_campana'));

        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'unique' => false,
             'fields' => 
             array(
              0 => 'denominacion',
             ),
             'canUpdate' => true,
             ));
        $this->actAs($sluggable0);
    }
}