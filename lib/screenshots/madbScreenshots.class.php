<?php

class madbScreenshots
{

  protected $packageName;
  protected $images;


  public function __construct($packageName)
  {
    $this->packageName = $packageName;
    $this->initialize();
  }

  protected function initialize()
  {
    $cache = new sfFileCache(array(
      'cache_dir' => sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'screenshots',
    ));
    if (!$cache->has($this->packageName))
    {
      $this->images = array();
    }
    else
    {
      $this->images = unserialize($cache->get($this->packageName));
    }
  }

  public function getFirst()
  {
    if (!isset($this->images[0]))
    {
      return array();
    }
    return $this->images[0];
  }

  public function getOthers()
  {
    $images = $this->images;
    array_shift($images);
    return $images;
  }

}
