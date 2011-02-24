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
      throw new sfException("Type '$type' is not a valid type."); // TOOD : improve this 
    }
  }
  
  public function getDefaultType()
  {
    return $this->defaultType;
  }
  
  public function jsonQuery($query)
  {
    // TODO : better error management
    $json = file_get_contents($this->urlSophie . '/' . $query . "?json=1");
    if ($json)
    {
      $result = json_decode($json);
      if ($result)
      {
        return $result;
      }
      else 
      {
        return false;
      }
    }
    else
    {
      return false;
    }
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
        throw new sfException("Method $method$type doesn't exist."); // TOOD : improve this
      }
    }
    else
    {
      throw new sfException("Type '$type' is not a valid type."); // TOOD : improve this 
    }
  }
  
  public function filterResult($result, $options)
  {
    if ($options['only'])
    {
      // is it a list of values or a regexp ?
      if (is_array($options['only']))
      {
        $result = array_intersect($result, $options['only']);
      }
      else
      {
        foreach ($result as $key => $value)
        {
          if (!preg_match($options['only'], $value))
          {
            unset($result[$key]);
          }
        }
      }
    }
    if ($options['exclude'])
    {
      // is it a list of values or a regexp ?
      if (is_array($options['exclude']))
      {
        $result = array_diff($result, $options['exclude']);
      }
      else
      {
        foreach ($result as $key => $value)
        {
          if (preg_match($options['exclude'], $value))
          {
            unset($result[$key]);
          }
        }
      }
    }
    return $result;
  }
  
  public function getReleases($distribution, $options=array())
  {
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
  
  public function getMedia($distribution, $release, $arch, $options=array())
  {
    $type = isset($options['type']) ? $options['type'] : $this->getDefaultType();
    // TODO : better error management
    $media = $this->executeForType('getRawMedia', array($distribution, $release, $arch), $type);
    return $this->filterResult($media, $options);
  }
  
  public function getRawMediaJson($distribution, $release, $arch)
  {
    return($this->jsonQuery("distrib/$distribution/$release/$arch"));
  }  
}
