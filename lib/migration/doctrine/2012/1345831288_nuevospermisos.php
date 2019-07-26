<?php

class Nuevospermisos extends Doctrine_Migration_Base
{
  public function up()
  {
      
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $q->execute("DELETE FROM sf_guard_user_group;");
    $q->execute("DELETE FROM sf_guard_user_permission;");
    $q->execute("DELETE FROM sf_guard_group_permission;");
    $q->execute("DELETE FROM sf_guard_group;");
    $q->execute("DELETE FROM sf_guard_permission");
          
    $permiso = new sfGuardPermission();
    $permiso->setName('usuarios_usuarios_de_frontend');
    $permiso->setDescription('Usuarios / Usuarios de Frontend');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('usuarios_newsletter_listado');
    $permiso->setDescription('Usuarios / Newsletter (Listado)');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('usuarios_newsletter_descargar');
    $permiso->setDescription('Usuarios / Newsletter (Descargar)');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_productos');
    $permiso->setDescription('Prod. y Campañas / Productos');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_campanas');
    $permiso->setDescription('Prod. y Campañas / Campañas');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_looks');
    $permiso->setDescription('Prod. y Campañas / Looks');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_categorias');
    $permiso->setDescription('Prod. y Campañas / Categorias');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_marcas');
    $permiso->setDescription('Prod. y Campañas / Marcas');
    $permiso->save();
    
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_talles');
    $permiso->setDescription('Prod. y Campañas / Talles');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_colores');
    $permiso->setDescription('Prod. y Campañas / Colores');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_tags');
    $permiso->setDescription('Prod. y Campañas / Tags');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_rubros');
    $permiso->setDescription('Prod. y Campañas / Rubros');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_importar_productos');
    $permiso->setDescription('Prod. y Campañas / Importar Productos');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_control_de_stock');
    $permiso->setDescription('Prod. y Campañas / Control de Stock');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_waitlist');
    $permiso->setDescription('Prod. y Campañas / WaitList');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_gestionar_cupones');
    $permiso->setDescription('Prod. y Campañas / Gestionar Cupones');
    $permiso->save();
    
    
    
    $permiso = new sfGuardPermission();
    $permiso->setName('gestion_pedidos');
    $permiso->setDescription('Gestión / Pedidos');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('gestion_exportar_ord_de_compra');
    $permiso->setDescription('Gestión / Exportar Ord. de Compra');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('gestion_importar_guias_de_envío');
    $permiso->setDescription('Gestión / Importar Guias de Envío');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('gestion_faltantes');
    $permiso->setDescription('Gestión / Faltantes');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('gestion_devoluciones');
    $permiso->setDescription('Gestión / Devoluciones');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('gestion_devueltos_por_oca');
    $permiso->setDescription('Gestión / Devueltos por OCA');
    $permiso->save();
    
    
    $permiso = new sfGuardPermission();
    $permiso->setName('facturacion_facturación_pendientes');
    $permiso->setDescription('Facturación / Facturación (Pendientes)');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('facturacion_generar_nota_de_credito');
    $permiso->setDescription('Facturación / Generar Nota de Credito');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('facturacion_listado_y_control_de_facturas');
    $permiso->setDescription('Facturación / Listado y Control de Facturas');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('facturacion_listado_de_notas_de_credito');
    $permiso->setDescription('Facturación / Listado de Notas de Credito');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('facturacion_consulta_de_comprobantes_afip');
    $permiso->setDescription('Facturación / Consulta de Comprobantes (AFIP)');
    $permiso->save();
    
    
    $permiso = new sfGuardPermission();
    $permiso->setName('banners_banners');
    $permiso->setDescription('Banners / Banners ');
    $permiso->save();
    
    
    $permiso = new sfGuardPermission();
    $permiso->setName('config_amazon');
    $permiso->setDescription('Config. / Amazon');
    $permiso->save();
    $permisoAWS = $permiso->getId();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('config_comerciales');
    $permiso->setDescription('Config. / Comerciales');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('config_valores_predefinidos');
    $permiso->setDescription('Config. / Valores Predefinidos');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('config_zonas_y_costos_de_envio');
    $permiso->setDescription('Config. / Zonas y Costos de Envio');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('config_localidades_de_envio');
    $permiso->setDescription('Config. / Localidades de Envio');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('config_sucursales_oca');
    $permiso->setDescription('Config. / Sucursales Oca');
    $permiso->save();
    
    
    $permiso = new sfGuardPermission();
    $permiso->setName('desc_y_bonif_descuentos');
    $permiso->setDescription('Desc. y Bonif. / Descuentos');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('desc_y_bonif_bonificaciones');
    $permiso->setDescription('Desc. y Bonif. / Bonificaciones');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('blog_posts');
    $permiso->setDescription('Blog / Posts');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('blog_categorias');
    $permiso->setDescription('Blog / Categorias');
    $permiso->save();
    
    
    $permiso = new sfGuardPermission();
    $permiso->setName('reportes_reporte_de_ventas_x_periodo');
    $permiso->setDescription('Reportes / Reporte de Ventas x Periodo');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('reportes_reporte_de_promo_suscribite');
    $permiso->setDescription('Reportes / Reporte de Promo Suscribite!');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('reportes_reportes_de_campanas');
    $permiso->setDescription('Reportes / Reportes de Campañas');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('reportes_reportes_de_comerciales');
    $permiso->setDescription('Reportes / Reportes de Comerciales');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('reportes_reportes_de_venta_online');
    $permiso->setDescription('Reportes / Reportes de Venta Online');
    $permiso->save();
    $permisoVtaOnline = $permiso->getId();
       
    
    $usuario = sfGuardUserTable::getInstance()->findOneById(2);
    $usuario->delete();
    
    $usuario = sfGuardUserTable::getInstance()->findOneById(3);
    $usuario->delete();
    
    $usuario = sfGuardUserTable::getInstance()->findOneById(4);
    $usuario->delete();
    
    $usuario = sfGuardUserTable::getInstance()->findOneById(5);
    $usuario->delete();
    
    $usuario = sfGuardUserTable::getInstance()->findOneById(6);
    $usuario->delete();
    
    $usuario = sfGuardUserTable::getInstance()->findOneById(7);
    $usuario->delete();
    
    $usuario = sfGuardUserTable::getInstance()->findOneById(9);
    $usuario->delete();

    $usuarios = sfGuardUserTable::getInstance()->findAll();
    foreach( $usuarios as $usuario )
    {
        if ( $usuario->getId() == 1 ) {}
        else if ( $usuario->getId() == 8 ) {}
        else if ( $usuario->getId() == 80 ) {
            $userPermision = new sfGuardUserPermission();
            $userPermision->setUserId($usuario->getId());
            $userPermision->setPermissionId( $permisoAWS );
            $userPermision->save();
        }
        else {
            $userPermision = new sfGuardUserPermission();
            $userPermision->setUserId($usuario->getId());
            $userPermision->setPermissionId( $permisoVtaOnline );
            $userPermision->save();
        }       
        
    }

    
  }

  public function down()
  {
  }
}
