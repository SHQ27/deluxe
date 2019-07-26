<?php

class remplazarImagenesTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'reemplazar-imagenes';
		$this->briefDescription = 'Reemplaza las imagenes de los productos en un directorio determinado';
		$this->addOption('archivo', null, sfCommandOption::PARAMETER_REQUIRED, 'Archivo', false);
		$this->detailedDescription = <<<EOF
La tarea [vaciar-carritos-expirados|INFO] reemplaza las imagenes de los productos en un directorio determinado
Call it with: [php symfony deluxebuys:reemplazar-imagenes|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "remplazarImagenes"');
		
		$archivo = $options['archivo'];

		if (($gestor = fopen("/tmp/" . $archivo, "r")) !== FALSE) {
		    
		    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {

			    $id = $datos[0];

			    $this->log('Procesando #' . $id);

			    $productoImagen = new productoImagen();
			    $productoImagen->setIdProductoImagen($id);

			    $imagenFilePathS3 = imageHelper::getInstance()->getPath('producto_detalle_grande', $productoImagen );
			    $imagenFilePath = '/tmp/' . $productoImagen->getIdProductoImagen() . '.jpg';
			    
			    copy($imagenFilePathS3, $imagenFilePath);

				if ( file_exists ( $imagenFilePath ) ) {

					$size = filesize( $imagenFilePath ) / 1024;
					if ($size < 10) {
						$this->log('No existe la imagen #' . $id );
						continue;
					}

					imageHelper::getInstance()->processSaveFile('producto_thumb', $productoImagen, $imagenFilePath );
					@unlink($imagenFilePath );

				} else {
					$this->log('No existe la imagen #' . $id );
				}
		    }

		    fclose($gestor);
		}

		$this->log('--- Fin de ejecucion: "remplazarImagenes"');
	}  
}


