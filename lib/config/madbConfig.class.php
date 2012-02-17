<?php
class madbConfig
{
  public function get($key, $default=null)
  {
    // search for value in config/madbconf.yml
    $value = sfConfig::get('madb_' . $key, null);
    if ($value !== null)
    {
      return $value;
    }
    
    // if none found, give madbConfig default value
    switch ($key)
    {
      case 'name':
        return "Mageia App Db";
      case 'force-ssl':
        return false;
      case 'host': 
        return "localhost";
      case 'distribution': 
        return "mageia";
      case 'distro_config_file': 
        return "data/distros/" . $this->get('distribution') . "/distro.yml";
      case 'applications_list_file': 
        return "data/distros/" . $this->get('distribution') . "/applications.txt";
      case 'notifications_display_notice': 
        return true;
      case 'homepage_groups_line': 
        return 5;
      case 'homepage_rpm_limit': 
        return 6;
      case 'clean-urls': 
        return true;
    }
    
    return $default;
  }
}