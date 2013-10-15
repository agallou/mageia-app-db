<?php
class madbUpdateScreenshotsCacheTask extends madbBaseTask
{

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'update-screenshots-cache';
  }

  protected function execute($arguments = array(), $options = array())
  {
    $json = json_decode(file_get_contents('http://screenshots.debian.net/json/screenshots'), true);
    $screenshots = $json['screenshots'];

    $packages = array();
    foreach ($screenshots as $screenshot) {
      $name = $screenshot['name'];
      if (!isset($packages[$name])) {
        $packages[$name] = array();
      }
      $packages[$name][] = array(
        'large_image_url' => $screenshot['large_image_url'],
        'small_image_url' => $screenshot['small_image_url'],
      );
    }

    $cache = new sfFileCache(array(
      'cache_dir' => sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'screenshots',
    ));
    foreach ($packages as $name => $images) {
      $cache->set($name, serialize($images));
    }
  }

}
