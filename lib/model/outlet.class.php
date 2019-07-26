<?php

class outlet
{
    protected $data;
    
	public function getImageFilename()
	{
		return 'outlet.jpg';		
	}
	
	public function getData()
	{
	    return $this->data;
	}
	
	public function setData($data)
	{
	    $this->data = $data;
	}
}