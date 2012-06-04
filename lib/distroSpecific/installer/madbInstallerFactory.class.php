<?php
class madbInstallerFactory
{
  /**
   * Creates the madbInstaller object for the current distro
   * Depends on a madbConfig object. I (Stormi) intentionnally embedded the madbConfig object creation in this method
   * for ease of use. The createFromDistro method, though, is not subject to this dependency
   * 
   * @return madbInstallerInterface
   */
  public function create()
  {
    $madbConfig = new madbConfig();
    $distro = $madbConfig->get('distribution');
    return $this->createFromDistro($distro);
  }
  
  /**
   * Creates the madbInstaller object for $distro
   * Returns null if no class found
   * 
   * @param string $distro distribution name, lowercase
   * @return madbInstallerInterface
   */
  public function createFromDistro($distro)
  {
    $class = 'madbInstaller' . ucfirst($distro);
    if (!class_exists($class))
    {
      return null;
    }
    return new $class();
  }
  
}