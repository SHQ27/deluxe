<?php

class importarFacebookLeadsTask extends deluxebuysBaseTask
{

	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'importar-facebook-leads';
		$this->briefDescription = 'Importa los leads de facebook como usuarios suscriptos';
		$this->detailedDescription = <<<EOF
La tarea [importar-facebook-leads|INFO] importa los leads de facebook como usuarios suscriptos
Call it with: [php symfony deluxebuys:importar-facebook-leads|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
		$this->log('--- Comienzo de ejecucion: "importar-facebook-leads"');

        \FacebookAds\Api::init('1531476837170681','2296df7c32164857fd62b7257dde8b84', 'CAAVw3rzcffkBAEvglMtY6TOUeChOxLHT9sEv3ZCal2IKqLiLSqHRCUSu7A2753fKOyJmmOMtV7QdHLXq0a4huopZA3jdspuKuxSfnGY8EcbgiAjJZB3kQAaXOmpZC3PYGvkwm3SgH5BmNO8Fq60vBb8QA3pKvCiZBAy61hzNgWuHSPoeQ7UNAGn4WZBriGBBYZD');
        $form = new \FacebookAds\Object\LeadgenForm('166039757076934');

        try {
	        $response = $form->getLeads( array(), array('limit' => 500) );
	        $response = $response->getResponse()->getContent();


	        $rows = $response['data'];
	        $next = $response['paging']['next'];

	        $this->importarPagina($rows, $next);        	
        } catch (Exception $e) {
        	errorLogHelper::getInstance()->cronErrorEmail('importar-facebook-leads', $e->getMessage() );
        	$this->log('Se produjo un error al importar leads');
        }

		$this->log('--- Fin de ejecucion: "importar-facebook-leads"');
	}

	protected function importarPagina($rows, $next)
	{
		$hoy = date('Y-m-d', strtotime('yesterday'));

        $c = count($rows);
        for ($i = 0 ; $i < $c ; $i++) {
            $row = arrayHelper::getInstance()->toArray( $rows[$i] );
            $hora = date('H:i:s', strtotime($row['created_time']));
            $fecha = date('Y-m-d', strtotime($row['created_time']));

            $data = array();
            foreach ($row['field_data'] as $fieldData) {
            	$data[ $fieldData['name'] ] = $fieldData['values'][0];
            }

            $email = $data['email'];
            $sexo = strtolower( trim( $data['gender'] ) );
            if ( in_array($sexo, array('male', 'masculino')) ) {
            	$sexo = 'h';
            } else {
            	$sexo = 'm';
            }

            if ( $fecha < $hoy ) {
            	break;
            }

            if ( $email && $sexo) {

			  	if ( !newsletterTable::getInstance()->subscriberExist( $sexo, $email, null ) )
			  	{
					$newsletter = new newsletter();
					$newsletter->setNombre('');
					$newsletter->setApellido('');
					$newsletter->setSexo($sexo);
					$newsletter->setEmail($email);
					$newsletter->setIdEshop( null );
					$newsletter->setSource( 'Facebook' );
				    $newsletter->setFechaSource( $fecha . ' ' . $hora );
				    $newsletter->setUtmCampaign( 'LeadAds' );
				    $newsletter->setUtmTerm( '' );
					$newsletter->suscribir();

					$this->log( $email . ' -> suscripto!');
			  	}
			}
        }

        if ( $i == $c ) {
	        $data = file_get_contents($next);
	        $data = json_decode($data);
	        $rows = $data->data;
	        $next = $data->paging->next;

        	$this->importarPagina($rows, $next);
        }

	}
}
