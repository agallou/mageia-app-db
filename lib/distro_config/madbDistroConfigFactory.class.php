<?php
class madbDistroConfigFactory
{
  /**
   * 
   * Create a madbDistroConfig object from a filename pointing to a distro config file
   * 
   * @param string $filename
   * @return madbDistroConfig
   * @throws madbDistroConfigException
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
}