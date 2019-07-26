<?php

class pmMemcacheCache extends sfMemcacheCache
{

  CONST HASH_PREFIX = 'view_key';
  CONST SALT = 'D3LUX3-C4CH3';


  public function getOption($name, $default = null)
  {
    $value = isset($this->options[$name]) ? $this->options[$name] : $default;

    if ( $name == 'prefix' ) {
      $value = $value . '_' . deviceHelper::getInstance()->getDevice();
    }

    return $value;
  }



  public function genKey($key)
  {
      $len = 40 + strlen(self::HASH_PREFIX);

      if ( strlen($key) == $len && substr($key, 0, strlen(self::HASH_PREFIX) ) == self::HASH_PREFIX ) {
        return $key;
      }

      return self::HASH_PREFIX . '_' . sha1($key . self::SALT);
  }

 /**
  * @see sfCache
  */
  public function get($key, $default = null)
  {
    $key = $this->genKey( $key );

    $value = $this->memcache->get($this->getOption('prefix') . $key);


    return false === $value ? $default : $value;
  }

  /**
   * @see sfCache
   */
  public function has($key)
  {
    $key = $this->genKey( $key );

    return !(false === $this->memcache->get($this->getOption('prefix') . $key));
  }

  /**
   * @see sfCache
   */
  public function set($key, $data, $lifetime = null)
  {
    $key = $this->genKey( $key );

    $lifetime = null === $lifetime ? $this->getOption('lifetime') : $lifetime;

    // save metadata
    $this->setMetadata($key, $lifetime);

    // save key for removePattern()
    if ($this->getOption('storeCacheInfo', false))
    {
      $this->setCacheInfo($key);
    }

    if (false !== $this->memcache->replace($this->getOption('prefix') . $key, $data, false, time() + $lifetime))
    {
      return true;
    }

    return $this->memcache->set($this->getOption('prefix') . $key, $data, false, time() + $lifetime);
  }

  /**
   * @see sfCache
   */
  public function remove($key)
  {
    $key = $this->genKey( $key );

    // delete metadata
    $this->memcache->delete($this->getOption('prefix').'_metadata'.self::SEPARATOR.$key, 0);
    if ($this->getOption('storeCacheInfo', false))
    {
      $this->setCacheInfo($key, true);
    }
    return $this->memcache->delete($this->getOption('prefix') . $key, 0);
  }

  /**
   * @see sfCache
   */
  public function getMany($keys)
  {
    $aux = array();
    foreach ($keys as $key => $value) {
      $aux[$key] = $this->genKey($value);
    }
    $keys = $aux;

    $values = array();
    foreach ($this->memcache->get(array_map(create_function('$k', 'return "'.$this->getOption('prefix').'".$k;'), $keys)) as $key => $value)
    {
      $values[str_replace($this->getOption('prefix'), '', $key)] = $value;
    }

    return $values;
  }

  /**
   * Gets metadata about a key in the cache.
   *
   * @param string $key A cache key
   *
   * @return array An array of metadata information
   */
  protected function getMetadata($key)
  {
    $key = $this->genKey( $key );

    return $this->memcache->get($this->getOption('prefix').'_metadata'.self::SEPARATOR.$key);
  }

  /**
   * Stores metadata about a key in the cache.
   *
   * @param string $key      A cache key
   * @param string $lifetime The lifetime
   */
  protected function setMetadata($key, $lifetime)
  {
    $key = $this->genKey( $key );
    $this->memcache->set($this->getOption('prefix').'_metadata'.self::SEPARATOR.$key, array('lastModified' => time(), 'timeout' => time() + $lifetime), false, $lifetime);
  }

  /**
   * Updates the cache information for the given cache key.
   *
   * @param string $key The cache key
   * @param boolean $delete Delete key or not
   */
  protected function setCacheInfo($key, $delete = false)
  {
    $key = $this->genKey( $key );

    $keys = $this->memcache->get($this->getOption('prefix').'_metadata');
    if (!is_array($keys))
    {
      $keys = array();
    }

    if ($delete)
    {
       if (($k = array_search($this->getOption('prefix') . $key, $keys)) !== false)
       {
         unset($keys[$k]);
       }
    }
    else
    {
      if (!in_array($this->getOption('prefix') . $key, $keys))
      {
        $keys[] = $this->getOption('prefix') . $key;
      }
    }

    $this->memcache->set($this->getOption('prefix').'_metadata', $keys, 0);
  }
}
