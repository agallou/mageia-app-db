<?php
class madbUrlHelperFactory
{
  /**
   * Creates the madbUrlHelper object for the current distro
   * Depends on a madbConfig object. I (Stormi) intentionnally embedded the madbConfig object creation in this method
   * for ease of use. The createFromDistro method, though, is not subject to this dependency
   * 
   * @return madbBugtrackerInterface
   */
  public function create()
  {
    $madbConfig = new madbConfig();
    $distro = $madbConfig->get('distribution');
    return $this->createFromDistro($distro);
  }
  
  /**
   * Creates the madbBugtracker object for $distro
   * Returns null if no class found
   * 
   * @param string $distro distribution name, lowercase
   * @return madbBugtrackerInterface
   */
  public function createFromDistro($distro)
  {
    $class = 'madbUrlHelper' . ucfirst($distro);
    if (!class_exists($class))
    {
      return null;
    }
    return new $class();
  }
  
}