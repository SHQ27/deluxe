<?php

class currentUser extends sfBasicSecurityUser
{
    const REMEMBER_ME_COOKIE = 'eshop_login'; 
    const USER_ATTR = 'user';
    
    /**
     * @return usuario
     */
    public function getCurrentUser()
    {
        return $this->getAttribute(self::USER_ATTR);
    }
    
    public function setCurrentUser(usuario $user)
    {
        $this->setAuthenticated(true);        
        return $this->setAttribute(self::USER_ATTR, $user);
    }
    
    private function clearCurrentUser()
    {
        return $this->setAttribute(self::USER_ATTR, null);
    }
        
    public function destroy()
    {
        sfContext::getInstance()->getResponse()->setCookie(self::REMEMBER_ME_COOKIE, '', time() - 3600, '');
        $this->setAuthenticated(false);
        return $this->clearCurrentUser();
    }

    public function rememberMe()
    {
        $user = $this->getCurrentUser();
        $value = base64_encode(serialize(array(
        	'id' => $user->getIdUsuario(), 
        	'remember' => $this->rememberHash($user),
        )));
        sfContext::getInstance()->getResponse()->setCookie(self::REMEMBER_ME_COOKIE, $value, time()+60*60*24*15, '');
    }

    public function checkRemember()
    {
        if (!isset($_COOKIE[self::REMEMBER_ME_COOKIE]) || !$_COOKIE[self::REMEMBER_ME_COOKIE]) {
            return false;
        }
        $values = unserialize(base64_decode($_COOKIE[self::REMEMBER_ME_COOKIE]));
        $user = usuarioTable::getInstance()->find($values['id']);
        if ($this->rememberHash($user) != $values['remember']) {
            return false;
        }
        $this->setCurrentUser($user);
        return true;
    }
    
    private function rememberHash(usuario $user)
    {
        return md5('some-salt-' . $user->getFechaAlta() . '-other');
    }

  /**
   * Sets authentication for user.
   *
   * @param  bool $authenticated
   */
  public function setAuthenticated($authenticated)
  {
    if ($this->options['logging'])
    {
      $this->dispatcher->notify(new sfEvent($this, 'application.log', array(sprintf('User is %sauthenticated', $authenticated === true ? '' : 'not '))));
    }

    if ((bool) $authenticated !== $this->authenticated)
    {
      if ($authenticated === true)
      {
        $this->authenticated = true;
      }
      else
      {
        $this->authenticated = false;
        $this->clearCredentials();
        $this->storage->regenerate(false);
      }

      $this->dispatcher->notify(new sfEvent($this, 'user.change_authentication', array('authenticated' => $this->authenticated)));
      
    }
  }
    
}
