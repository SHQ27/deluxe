<?php

class informarFalladosTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'informar-fallados';
		$this->briefDescription = 'Envia un mail a cada marca que tenga fallados';
		$this->detailedDescription = <<<EOF
La tarea [informar-fallados|INFO] envia un mail a cada marca que tenga fallados
Call it with: [php symfony deluxebuys:informar-fallados|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "informarFallados"');
		
		$fallados = falladoTable::getInstance()->listForCron();
				
		$idMarca = null;
		$data = array();
		foreach ( $fallados as $fallado )
		{
		    if ( $idMarca != $fallado['id_marca'] )
		    {
		        $idMarca = $fallado['id_marca'];
		        $marca = marcaTable::getInstance()->getOneById($idMarca);

		        $data[$idMarca]['marca'] = $marca;
		    }
		    
		    $data[$idMarca]['fallados'][] = $fallado;
		}
		
		foreach( $data as $row )
		{		    		    
		    $marca = $row['marca'];
		    
		    $email = ( $marca->getEmailComercial() ) ? array($marca->getEmailComercial(), 'administracion@deluxebuys.com') : 'administracion@deluxebuys.com';
		    
		    $subject = 'Hemos recibido prendas falladas en las ultimas entregas de ' . $row['marca']->getNombre();
		    $vars = array( 'title'   => $subject, 'marca' => $row['marca'], 'fallados' => $row['fallados'] );
		    $mailer = new Mailer('informarFallados', $vars);
		    $mailer->send( $subject, $email, sfConfig::get('app_email_from_finanzas')  );
		    
		    $this->log('Se le envio un aviso de fallados a la marca "' . $row['marca']->getNombre() . '"');
		}
		
				
		$this->log('--- Fin de ejecucion: "informarFallados"');
	}  
}
