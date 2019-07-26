<?php


class sfGuardPermissionTable extends PluginsfGuardPermissionTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardPermission');
    }
    
    public function listAllOrdered()
    {
        return $this->createQuery('p')
                     ->orderBy('description')
                     ->execute();
    }
}