<?php
class madbDistroConfig
{
  // TODO : one attribute per configuration element ? or use a parameterHolder ?
  protected $values = array();

  function __construct($values = array())
  {
    $this->values = $values;
  }


  /**
   * 
   * If the value is a scalar, make an array of it
   * 
   * @param mixed $value
   * @return array
   */
  protected function valueToArray($value)
  {
    // Empty array if value is null or empty string
    if ($value === null or (!is_array($value) and trim($value) === ''))
    {
      return array();
    }
    return is_array($value) ? $value : array($value);
  }
  
  public function check()
  {
    // TODO : check config file validity
    return ($this->checkValidity() and $this->checkConsistency());
  }

  public function checkValidity()
  {
    // TODO : check config file validity
    return true;
  }

  public function checkConsistency()
  {
    // TODO : check consistency between config file and database
    // e.g. : releases not in config file but present in database
    return true;
  }

  public function getName()
  {
    return $this->values['name'];
  }

  public function getDevelReleases()
  {
    $value = $this->values['devel_releases'];
    return $this->valueToArray($value);
  }

  public function getLatestStableRelease()
  {
    return $this->values['latest_stable_release'];
  }

  public function getOnlyReleases()
  {
    $value = $this->values['only_releases'];
    return $this->valueToArray($value);
  }
  
  public function getExcludeReleases()
  {
    $value = $this->values['exclude_releases'];
    return $this->valueToArray($value);
  }
  
  public function getOnlyArchs()
  {
    $value = $this->values['only_archs'];
    return $this->valueToArray($value);
  }

  public function getExcludeArchs()
  {
    $value = $this->values['exclude_archs'];
    return $this->valueToArray($value);
  }

  public function getOnlyMedias()
  {
    $value = $this->values['only_medias'];
    return $this->valueToArray($value);
  }

  public function getExcludeMedias()
  {
    $value = $this->values['exclude_medias'];
    return $this->valueToArray($value);
  }

  public function getOnlyRpms()
  {
    $value = $this->values['only_rpms'];
    return $this->valueToArray($value);
  }

  public function getExcludeRpms()
  {
    $value = $this->values['exclude_rpms'];
    return $this->valueToArray($value);
  }
  
  public function getUpdatesMedias()
  {
    $value = $this->values['updates_medias'];
    return $this->valueToArray($value);
  }

  public function getTestingMedias()
  {
    $value = $this->values['testing_medias'];
    return $this->valueToArray($value);
  }

  public function getBackportsMedias()
  {
    $value = $this->values['backports_medias'];
    return $this->valueToArray($value);
  }

  public function getThirdPartyMedias()
  {
    $value = $this->values['third_party_medias'];
    return $this->valueToArray($value);
  }
}