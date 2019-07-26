<?php

require_once 'symfony-1.4.20/lib/autoload/sfCoreAutoload.class.php';
require_once(dirname(__FILE__).'/../lib/UniversalClassLoader.php');
require_once(dirname(__FILE__).'/../lib/ApcUniversalClassLoader.php');
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
    public function setup()
    {
        $this->namespacesClassLoader();
        $this->enablePlugins('sfDoctrinePlugin');
        $this->enablePlugins('sfDoctrineGuardPlugin');
        $this->enablePlugins('sfAdminDashPlugin');
        $this->enablePlugins('sfThumbnailPlugin');
        $this->enablePlugins('sfFormExtraPlugin');
        $this->enablePlugins('sfDependentSelectPlugin');

        sfConfig::set('sf_temp_dir', sfConfig::get('sf_root_dir') . '/tmp');
        sfConfig::set('app_reporteCronologico_dir', sfConfig::get('sf_root_dir') . '/data/reportesCronologicosSemanales');

        $this->dispatcher->connect('context.load_factories', array($this, 'chargeAlerts'));

        ini_set("session.entropy_file", "/dev/urandom");
        ini_set("session.entropy_length", "512");
    }


    public function chargeAlerts(sfEvent $event)
    {
        sfValidatorBase::setDefaultMessage('required', 'Este campo es obligatorio');
        sfValidatorEmail::setDefaultMessage('invalid', 'El dato ingresado no es válido');
        sfValidatorBase::setDefaultMessage('max_length', 'Se permiten %max_length% caracteres como maxímo');
    }

    public function configureDoctrine(Doctrine_Manager $manager)
    {
        // Gestion de CACHE
        $memcachePort = sfConfig::get('app_memcache_port');
        $memcacheIp = sfConfig::get('app_memcache_ip');
        
        if ( $memcacheIp && $memcachePort )
        {
            $cacheDriver = new Doctrine_Cache_Memcached ( array ( 'servers' => array('host' => $memcacheIp, 'port' => $memcachePort) ) );
            //$cacheDriver->flush();
            $manager = Doctrine_Manager::getInstance();
            $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, $cacheDriver);
        }

        // Registro de Customs Hydrators
        $manager->registerHydrator('HYDRATE_KEY_VALUE_PAIR', 'KeyValuePairHydrator');
        $manager->registerHydrator('HYDRATE_ARRAY_SHALLOW', 'Doctrine_Hydrator_ArrayShallowDriver');
    }


    public function namespacesClassLoader() {
       if (extension_loaded('apc')) {
           $loader = new ApcUniversalClassLoader('S2A');
       } else {
           $loader = new UniversalClassLoader();
       }

       $loader->registerNamespaces( array(
            'FacebookAds' => __DIR__ . '/../lib/facebook-php-ads-sdk/src'
          )
       );

       $loader->register();
    }

}
