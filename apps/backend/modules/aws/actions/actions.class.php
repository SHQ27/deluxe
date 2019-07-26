<?php
/**
 * aws actions.
 *
 * @package    deluxebuys
 * @subpackage aws
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class awsActions extends sfActions
{
    
    const LAUNCH_NAME = 'LaunchWebServers64-';
    const GROUP_NAME = 'WebServers64';
    const SNS_MESSAGE_AUMENTAR_INSTANCIAS = 'RECOMENDACION_AUMENTAR_INSTANCIAS';
    const SNS_MESSAGE_REDUCIR_INSTANCIAS = 'RECOMENDACION_REDUCIR_INSTANCIAS';
    
    protected $ec2;
    protected $iam;
    protected $as;
    protected $autoScalingGroup;
    protected $currentAmi;
    protected $cloudWatch;
    
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        define('AWS_KEY', sfConfig::get('app_aws_key'));
        define('AWS_SECRET_KEY', sfConfig::get('app_aws_secret_key'));
        define('AWS_DATA_INSTANCE_ID', sfConfig::get('app_aws_data_instance_id'));  
        define('AWS_CACHE_INSTANCE_ID', sfConfig::get('app_aws_cache_instance_id'));
                
        $this->cloudWatch = new AmazonCloudWatch();

        $this->mensaje = $this->getUser()->getFlash('mensaje');       
        $this->status = $this->getUser()->getFlash('status', true);
                
        $instancias = $request->getParameter('instancias', 0);
        
        $this->desiredCapacity = $this->getAutoScalingGroup()->DesiredCapacity;
        if ($instancias)
        {
            $this->desiredCapacity = $instancias;
            $this->cambiarInstancias($this->desiredCapacity);
            $this->getUser()->setFlash('mensaje', "Instancias modificadas correctamente");
            $this->getUser()->setFlash('status', true);
            $this->redirect('aws');            
        }
                        
        $dbChartData = array(array('Fecha', 'Base de Datos'));
        $data = $this->getChartData( AWS_DATA_INSTANCE_ID, 300 );
        foreach( $data as $fecha => $valor )
        {
            $dbChartData[] = array(date('H:i', strtotime($fecha)) , $valor);
        }        
        
        $this->estados = $this->getInstancesStatus();
        $this->ami = $this->getCurrentAmi();
        $other = sfConfig::get('app_aws_other_instances');
        $stopped = isset($this->estados['stopped']) ? $this->estados['stopped'] : 0; 
        $this->max = sfConfig::get('app_aws_max_instances');        
        $this->estados['running'] -= $other;
        $this->runningInstances = $this->getRunningInstances();
        $this->instancesChartsData = json_encode( $this->getInstancesChartData( $this->runningInstances ) );
        $this->dbChartData = json_encode( $dbChartData );
    }
    
    /**
     * Executes notificacion action
     *
     * @param sfRequest $request A request object
     */
    public function executeNotificacion(sfWebRequest $request)
    {
        define('AWS_KEY', sfConfig::get('app_aws_key'));
        define('AWS_SECRET_KEY', sfConfig::get('app_aws_secret_key'));
        define('AWS_DATA_INSTANCE_ID', sfConfig::get('app_aws_data_instance_id'));
        define('AWS_CACHE_INSTANCE_ID', sfConfig::get('app_aws_cache_instance_id'));
                
        $data = file_get_contents('php://input');
                        
        if( !AmazonSNSVerify::getInstance()->verify($data, 'us-east-1', '963756727804', array(self::SNS_MESSAGE_REDUCIR_INSTANCIAS, self::SNS_MESSAGE_AUMENTAR_INSTANCIAS) ) )
        {
            exit;
        }
        
        $data = json_decode($data, true);
        
        $runningInstances = count( $this->getRunningInstances() );
        
        $snsPrefix = sfConfig::get('app_aws_sns_prefix');
        if ( ($data['TopicArn'] ==  $snsPrefix . self::SNS_MESSAGE_REDUCIR_INSTANCIAS) && $runningInstances > 1 )
        {    
            $subject = 'Se recomienda reducir la cantidad de instancias en ejecución';
            $to = explode( ',', sfConfig::get('app_email_to_avisoAWS') );
            $mailer = new Mailer('alarmaReducirInstancias', array( 'title' => $subject ));
            $mailer->send( $subject, $to );
        }
        
        if ( $data['TopicArn'] ==  $snsPrefix . self::SNS_MESSAGE_AUMENTAR_INSTANCIAS )
        {
            $subject = 'Se recomienda aumentar la cantidad de instancias en ejecución';
            $to = explode( ',', sfConfig::get('app_email_to_avisoAWS') );
            $mailer = new Mailer('alarmaAumentarInstancias', array( 'title' => $subject ));
            $mailer->send( $subject, $to );
        }
        
        header("Status: 200");
        exit;
    }
    
    public function getInstancesChartData( $runningInstances )
    {
        $keysChartData = array('Fecha');
        $instancesChartsData = array();
        $i = 1;
        foreach ( $runningInstances as $instance )
        {
            $data = $this->getChartData( $instance->instanceId );
        
            $keysChartData[] = 'Instancia Nº ' . $i;
        
            foreach ($data as $fecha => $valor)
            {                
                $instancesChartsData[$fecha][0] = date('H:i', strtotime($fecha));
                $instancesChartsData[$fecha][$i] = $valor;
            }
        
            $i++;
        }
        
        $max = count($runningInstances);
        
        $aux = array();
        foreach( $instancesChartsData as $row )
        {
            $fecha = $row[0];
            
            for($j = 1 ; $j <= $max ; $j++ ){
                if ( !isset( $row[$j] )) {
                    $row[$j] = 0;
                }
            }
            $aux[ $fecha ] = array_values($row);
        }

        $instancesChartsData = $aux;
        
        ksort($instancesChartsData);
        
        $instancesChartsData = array_merge( array($keysChartData), array_values($instancesChartsData) );
                
        return $instancesChartsData;
    }
    
    public function getChartData($instance, $interval = 60)
    {
        $desde =  date('Y-m-d H:i',  time() - (3600 * 1.5) );
        $hasta=  date('Y-m-d H:i',  time() - $interval );
        
        $response = $this->cloudWatch->get_metric_statistics('AWS/EC2', 'CPUUtilization', $desde, $hasta, $interval, 'Maximum', 'Percent', array('Dimensions' => array(array('Name' => 'InstanceId', 'Value' => $instance))));
        $dataResponse = current($response->body->GetMetricStatisticsResult->Datapoints);
        
        $data = array();
        foreach( $dataResponse as $row )
        {
            $fecha = (string) $row->Timestamp;
            $data[$fecha] = (float) $row->Maximum;
        }
        
        ksort($data);
        
        return $data;
    }
    
    
    public function cambiarInstancias($desiredCapacity)
    {
        $this->checkLaunchConfiguration();
        $rs = $this->getAs()->set_desired_capacity(self::GROUP_NAME, $desiredCapacity);
        $this->responseError($rs);
        return true;
    }
    
    public function checkLaunchConfiguration()
    {        
        $version = $this->getCurrentAmi()->Version;
        if (self::LAUNCH_NAME . $version == $this->getAutoScalingGroup()->LaunchConfigurationName) {
            return true;
        }        
        $this->createLaunchConfiguration();
        $this->updateAutoScalingGroup();
    }
    
    public function createLaunchConfiguration()
    {
        $rs = $this->getAs()->create_launch_configuration(
            self::LAUNCH_NAME . $this->getCurrentAmi()->Version, 
            $this->getCurrentAmi()->imageId, 
            sfConfig::get('app_aws_instance_type'), 
            array(
    			'SecurityGroups' => array(sfConfig::get('app_aws_security_groups')),
    			'KeyName' => sfConfig::get('app_aws_key_name'),
            )
        );
        $this->responseError($rs);
    }
    
    public function updateAutoScalingGroup()
    {
        $opts = array('LaunchConfigurationName' => self::LAUNCH_NAME . $this->getCurrentAmi()->Version);
        $rs = $this->getAs()->update_auto_scaling_group(self::GROUP_NAME, $opts);
        $this->responseError($rs);
    }
    
    protected function responseError(CFResponse $response)
    {
        if (isset($response->body->Error)) {
            throw new Exception($response->body->Error->Message);
        }
    }
    
    public function getInstancesStatus()
    {
        $response = $this->getEc2()->describe_instances();
        $instances = array();
        foreach ($response->body->reservationSet->item as $reservationSet) {
            foreach ($reservationSet->instancesSet->item as $instance) {
                $state = (string) $instance->instanceState->name;                                    
                if (!isset($instances[$state])) $instances[$state] = 0;
                $instances[$state]++;
            }
        }
        return $instances;        
    }
    /**
     * @return AmazonEC2
     */
    public function getEc2()
    {
        if (!$this->ec2) {
            $this->ec2 = new AmazonEC2(); 
        }
        return $this->ec2;
    }
    /**
     * @return AmazonIAM
     */
    public function getIam()
    {
        if (!$this->iam) {
            $this->iam = new AmazonIAM(); 
        }
        return $this->iam;        
    }
    /**
     * @return AmazonAS
     */
    public function getAs()
    {
        if (!$this->as) {
            $this->as = new AmazonAS(); 
        }
        return $this->as;        
    }
    
    public function getCurrentAmi()
    {        
        if ($this->currentAmi) {
            return $this->currentAmi;
        }             
        $selectedVersion = 0;
       	$images = $this->listImagesByOwner($this->getUserId());
       	foreach ($images as $i => $ami) {
       	    $ami = $ami->to_stdClass();
       	    $version = $this->nameToVersion($ami->imageLocation);
       	    if ($version > $selectedVersion) {
       	        $selectedVersion = $version;
       	        $this->currentAmi = $ami;
       	        $this->currentAmi->Version = $version; 	
       	    }
       	}
       	return $this->currentAmi;
    }
    
    public function getAutoScalingGroup()
    {                     
        if ($this->autoScalingGroup) {
            return $this->autoScalingGroup;
        }
        $opts = array('AutoScalingGroupNames' => self::GROUP_NAME);
        $response = $this->getAs()->describe_auto_scaling_groups($opts);
        $this->responseError($response);
        $result = $response->body->DescribeAutoScalingGroupsResult;
        $this->autoScalingGroup = $result->AutoScalingGroups->member->to_stdClass();
        return $this->autoScalingGroup;
    }
    
    public function getRunningInstances()
    {
        $response = $this->getEc2()->describe_instances();
        $instances = array();
        foreach ($response->body->reservationSet->item as $reservationSet) {
            foreach ($reservationSet->instancesSet->item as $instance) {
            	$state = (string) $instance->instanceState->name;
            	$instanceId = (string) $instance->instanceId;
            	if ($state == 'running' && $instanceId != AWS_DATA_INSTANCE_ID && $instanceId != AWS_CACHE_INSTANCE_ID) {
            		$instances[] = (object) array(
        		        'instanceId' => (string) $instance->instanceId,
            		    'privateIpAddress' => (string) $instance->privateIpAddress
            		); 
            	} 
            }
        }
        return $instances;        
    }
    
    protected function nameToVersion($name)
    {
        $pos = strrpos($name, '-');
        if ($pos === false) {
            return 0;
        }
        return (float) substr($name, $pos + 1);
    }
    
    
    public function listImagesByOwner($owner)
    {
        $response = $this->getEc2()->describe_images(array('Owner' => $owner));
        $images = array();
        foreach ($response->body->imagesSet->item as $item) {
            $images[] = $item;
        }        
    	return $images;
    }
    
    public function getUserId()
    {
       	$response = $this->getIam()->get_user();
        return $response->body->GetUserResult->User->UserId->to_string();        
    }
}
    
