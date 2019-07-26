<?php

class DatosPersonalesForm extends usuarioForm
{
    public function configure()
    {
        parent::configure();        
        $this->useFields(array('telefono'));
    }
}