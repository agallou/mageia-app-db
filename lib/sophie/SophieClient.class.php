<?php

class SophieClient
{
  protected $urlSophie = 'http://sophie.zarb.org';
  protected $defaultType = 'json';
  
  public function getAvailableTypes()
  {
    return array('json', 'xmlrpc');
  }
  
  public function setUrlSophie($url)
  {
    $this->urlSophie = $url;
  }
  
  public function getUrlSophie()
  {
    return $this->urlSophie;
  }
  
  public function setDefaultType($type)
  {
    if (in_array($type, $this->getAvailableTypes()))
    {
      $this->defaultType = $type;
    }
    else 
    { 
      throw new SophieClientException("Type '$type' is not a valid type."); // TOOD : improve this 
    }
  }
  
  public function getDefaultType()
  {
    return $this->defaultType;
  }
  
  public function jsonQuery($query)
  {
    $json = file_get_contents($this->urlSophie . '/' . $query . "?json=1");
    if (!$json)
    {
      throw new SophieClientException("Error getting JSON response from Sophie for request $query.");
    }
    $result = json_decode($json);
    if ($result === null)
    {
      throw new SophieClientException("Error decoding JSON response from Sophie for request $query.");
    }
    return $result;
  }
  
  
  public function xmlrpcQuery($method, $args)
  {
    //TODO
  }
  
  
  public function executeForType($method, $args = array(), $type=null)
  {
    $type = ($type === null) ? $this->getDefaultType() : $type;
    if (in_array($type, $this->getAvailableTypes()))
    {
      if (method_exists($this, $method . $type))
      {
        // TODO : better error management (try catch ?)
        return call_user_func_array(array($this, $method . $type), $args);
      }
      else 
      {
        throw new SophieClientException("Method $method$type doesn't exist."); // TOOD : improve this
      }
    }
    else
    {
      throw new SophieClientException("Type '$type' is not a valid type."); // TOOD : improve this 
    }
  }
  
  /**
   * 
   * Filter the result (treated like an associative array) with
   * $options['only'] if defined
   * $options['exclude'] if defined
   * both must be arrays of regexps (without the enclosing //, and without / in them)
   * 
   * @param array $result
   * @param array $options
   */
  public function filterResult($result, $options)
  {
    if (isset($options['only']))
    {
      $result = madbToolkit::filterArrayKeepOnly($result, $options['only'], true);
    }
    
    if (isset($options['exclude']))
    {
      $result = madbToolkit::filterArrayExclude($result, $options['exclude']);
    }
    return $result;
  }
  
  public function getReleases($distribution, $options=array())
  {
    // TODO : only use the default type
    $type = isset($options['type']) ? $options['type'] : $this->getDefaultType();
    // TODO : better error management
    $releases = $this->executeForType('getRawReleases', array($distribution), $type);
    return $this->filterResult($releases, $options);
  }
  
  public function getRawReleasesJson($distribution)
  {
    return($this->jsonQuery("distrib/$distribution"));
  }
  
  public function getArchs($distribution, $release, $options=array())
  {
    $type = isset($options['type']) ? $options['type'] : $this->getDefaultType();
    // TODO : better error management
    $archs = $this->executeForType('getRawArchs', array($distribution, $release), $type);
    return $this->filterResult($archs, $options);
  }
  
  public function getRawArchsJson($distribution, $release)
  {
    return($this->jsonQuery("distrib/$distribution/$release"));
  }  
  
  public function getMedias($distribution, $release, $arch, $options=array())
  {
    $type = isset($options['type']) ? $options['type'] : $this->getDefaultType();
    // TODO : better error management
    $medias = $this->executeForType('getRawMedias', array($distribution, $release, $arch), $type);
    return $this->filterResult($medias, $options);
  }
  
  public function getRawMediasJson($distribution, $release, $arch)
  {
    return($this->jsonQuery("distrib/$distribution/$release/$arch"));
  }

  /**
   * 
   * Returns the list of RPMs for a given media, as an associative array pkgid => filename
   * Note that filters apply both on RPMs and SRPMs, be careful when defining them,
   * so that you don't exclude a SRPM without its RPM or vice versa
   * 
   * @param string $distribution
   * @param string $release
   * @param string $arch
   * @param string $media
   * @param array $options
   * 
   * @return array
   */
  public function getRpmsFromMedia($distribution, $release, $arch, $media, $options=array())
  {
    $type = isset($options['type']) ? $options['type'] : $this->getDefaultType();
    // TODO : better error management
    $rpms = $this->executeForType('getRawRpmsFromMedia', array($distribution, $release, $arch, $media), $type);
    return $this->filterResult($rpms, $options);
  }
  
  public function getRawRpmsFromMediaJson($distribution, $release, $arch, $media)
  {
    $result = (array) $this->jsonQuery("distrib/$distribution/$release/$arch/media/$media");
    $rpms = array();
    foreach ($result as $object)
    {
      $rpms[$object->pkgid] = $object->filename;
    }
    return $rpms;
  }  
  
  /**
   * 
   * Returns the RPM infos
   * 
   * @param string $pkgid
   * 
   * @return array
   */
  public function getRpmByPkgid($pkgid, $options = array())
  {
    $type = isset($options['type']) ? $options['type'] : $this->getDefaultType();
    // TODO : better error management
    $rpm = $this->executeForType('getRawRpmByPkgid', array($pkgid), $type);
    $rpm['description'] = str_replace("\t", '\t', str_replace("\n", '\n', $rpm['description']));
    return $rpm;
  }
  
  public function getRawRpmByPkgidJson($pkgid)
  {
    $result = $this->jsonQuery("rpms/$pkgid/info");
    return (array) $result;
  }  
  
  public function convertMediaName($media)
  {
    // remove the -src suffix
    $media = str_replace('-src', '', $media);
    return $media;
  }
}
