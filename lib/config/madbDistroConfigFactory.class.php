<?php
class madbDistroConfigFactory
{
  /**
   * 
   * Create a madbDistroConfig object from a filename pointing to a distro config file
   * 
   * @param string $filename
   * @return madbDistroConfig
   * @throws madbDistroConfigFactoryException
   */
  public function createFromFile($filename)
  {
    if (!is_file($filename))
    {
      throw new madbDistroConfigFactoryException("File '$filename' not found");
    }
    $values = sfYaml::load($filename);
    return new madbDistroConfig($values);
  }
  
  /**
   * Get the madbDistroConfig object for current distro
   * 
   * @param madbConfig $madbConfig 
   * @return madbDistroConfig
   * 
   */
  public function getCurrentDistroConfig(madbConfig $madbConfig)
  {
    $relative_filename = $madbConfig->get('distro_config_file');
    $absolute_filename = sfConfig::get('sf_root_dir') . '/' . $relative_filename;
    return self::createFromFile($absolute_filename);
  }
}