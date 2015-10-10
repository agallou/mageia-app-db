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
    $context = stream_context_create(array(
      'http'=> array(
        'timeout' => 300,
      )
    ));
    $json = json_decode(file_get_contents('http://screenshots.debian.net/json/screenshots', false, $context), true);
    $screenshots = $json['screenshots'];

    $packages = array();
    foreach ($screenshots as $screenshot) {
      $name = $screenshot['name'];
      if (!isset($packages[$name])) {
        $packages[$name] = array();
      }
      $packages[$name][] = array(
        'large_image_url' => $this->cleanUrl($screenshot['large_image_url']),
        'small_image_url' => $this->cleanUrl($screenshot['small_image_url']),
      );
    }

    $cache = new sfFileCache(array(
      'cache_dir' => sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . 'screenshots',
      'lifetime' => 86400 * 365 * 2,
    ));
    foreach ($packages as $name => $images) {
      $cache->set($name, serialize($images));
    }
  }

  /**
   * Allow to use screenshots in https
   */
  protected function cleanUrl($url)
  {
      return ltrim($url, 'http:');
  }

}
