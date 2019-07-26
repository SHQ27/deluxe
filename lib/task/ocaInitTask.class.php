<?php

class ocaInitTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'oca-init';
		$this->briefDescription = '';
		$this->detailedDescription = '';
	}

	public function doExecute($arguments = array(), $options = array())
	{		
	    Oca::getInstance()->initMarcas();
	}
}
