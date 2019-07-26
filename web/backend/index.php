<?php


set_time_limit(0);

ini_set('session.gc_maxlifetime','21600');
ini_set("memory_limit","512M");

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'prod', true);
sfContext::createInstance($configuration)->dispatch();
