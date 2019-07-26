<?php

abstract class ContactListProvider
{
    /**
     * @return ContactListProvider 
     */
    static public function factory($provider)
    {
        $class = 'ContactListProvider_' . ucfirst($provider);
        return new $class;
    }
    
    abstract public function fetch($email, $password);
}