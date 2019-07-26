<?php

class pmValidatorUsuarioUnique extends sfValidatorBase
{
    protected function configure($options = array(), $messages = array())
    {
        $this->addOption('eshop');
    }

    protected function doClean($values)
    {
        if ( !isset( $values['email'] )) {
            return $values;
        }        
        
        $idUsuario = ( isset( $values['id_usuario'] ) ) ? $values['id_usuario'] : null;
        $email = $values['email'];
        $eshop = $this->getOption('eshop');
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
        
        $isUnique = usuarioTable::getInstance()->isUnique($email, $idUsuario, $idEshop );
                
        if (!$isUnique)
        {
            throw new sfValidatorError($this, 'Ya existe un usuario con el mismo email', array('column' => 'email'));
        }
        
        return $values;
    }
}